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
}
