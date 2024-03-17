<?php

namespace App\Http\Controllers;

use App\Models\ProcurementRequest;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class ProcurementRequestsController extends Controller
{
  public function index(Request $request)
  {
      $query = $request->input('search');

      $procurementRequests = ProcurementRequest::orderBy('created_at', 'desc')
          ->when($query, function ($query) use ($request) {
              $query->where('id', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('status', 'like', '%' . $request->input('search') . '%')
                  ->orWhereHas('department', function ($query) use ($request) {
                      $query->where('name', 'like', '%' . $request->input('search') . '%');
                  });
          })
          ->get();

      return view('app.procurement.listrequest', ['requests' => $procurementRequests]);
  }
    public function show($id)
    {
        $request = ProcurementRequest::with('department', 'user')->find($id);

        return view('app.procurement.listrequestshow', compact('request'));
    }

    public function openRequestsForSupplierVendor(Request $request)
{
    // Assuming the supplier/vendor ID is available in the session or from authentication
    $supplierVendorId = $request->session()->get('supplier_vendor_id'); // Adjust as needed

    $openRequests = ProcurementRequest::query()
        ->where('is_open_for_bids', true)
        ->where('deadline', '>', now())
        ->with(['bids' => function ($query) use ($supplierVendorId) {
            $query->bySupplierOrVendor($supplierVendorId, $supplierVendorId); // Using your helpful scope
        }])
        ->orderBy('deadline')
        ->paginate();

    return view('app.procurement.open_requests', ['requests' => $openRequests]);
    // Replace 'app.procurement.open_requests' with the actual view path
}
    public function generatePDF($id)
    {
        $request = ProcurementRequest::with('department','user')->find($id);

        $pdf = new Dompdf();
        $pdf->loadHtml(View::make('app.procurement.pdf', compact('request'))->render());
        $pdf->setPaper('A4', 'portrait');

        $pdf->render();

        $output = $pdf->output();
        return Response::make($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="app.procurement.pdf"'
        ]);
    }
    public function getNewBids(Request $request, $requestId)
{
    $supplierVendorId = $request->session()->get('supplier_vendor_id');
    // ... Adjust to include $requestId in your query ...

    $newBids = Bid::where('supplier_id', $supplierVendorId)
                   // OR  ->where('vendor_id', $supplierVendorId)
                  ->where('procurement_request_id', $requestId) // Fetch for specific request
                  ->where('created_at', '>', $recentBidCutoff)
                  ->get();

    return response()->json($newBids);
}
}
