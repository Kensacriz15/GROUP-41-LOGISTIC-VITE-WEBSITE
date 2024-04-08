<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

//Controller for PPI
use App\Http\Controllers\ProcurementRequestsController;
use App\Http\Controllers\BiddingProductController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\ApiController;
use App\Models\BiddingProduct;
use App\Models\Invoice;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QualityStandardController;
use App\Http\Controllers\UserPageBiddingController;
use App\Http\Controllers\SupplierBidController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main Page Route
Route::get('/', [HomePage::class, 'index'])->name('app.home');
Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

// locale
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// pages
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::resources([
  'roles' => RoleController::class,
  'users' => UserController::class,
]);

Route::get('/procurement', [ApiController::class, 'Procurement']);
// procurement and purchase
Route::get('/procurement-requests', [ProcurementRequestsController::class, 'index'])->name('app.procurement.listrequest');
Route::get('/procurement-requests/{request}', [ProcurementRequestsController::class, 'show'])->name('app.procurement.listrequestshow');
Route::get('/generate-pdf/{id}', [ProcurementRequestsController::class, 'generatePDF'])->name('app.procurement.pdf');
Route::post('/procurement-requests/{requestId}/submit-bid', [BidController::class, 'store'])
    ->name('app.procurement.open_requests');
Route::get('/get-new-bids/{requestId}', [ProcurementRequestsController::class, 'getNewBids']);

Route::resource('/procurement/biddings', BiddingProductController::class);
Route::get('/procurement/biddings', [BiddingProductController::class, 'index'])->name('app.procurement.biddings.index');
Route::post('/procurement/biddings', [BiddingProductController::class, 'store'])->name('app.procurement.biddings.store');
Route::get('/procurement/biddings/create', [BiddingProductController::class, 'create'])->name('app.procurement.biddings.create');
Route::get('/procurement/biddings/{bidding}', [BiddingProductController::class, 'show'])->name('app.procurement.biddings.show');
Route::get('/procurement/biddings/{bidding}}/edit', [BiddingProductController::class, 'edit'])->name('app.procurement.biddings.edit');
Route::put('/procurement/biddings/{bidding}', [BiddingProductController::class, 'update'])->name('app.procurement.biddings.update');
Route::delete('/procurement/biddings/{bidding}', [BiddingProductController::class, 'destroy'])->name('app.procurement.biddings.destroy');
Route::post('/procurement/biddings/{bidding}/bids', [BiddingProductController::class, 'storeBid'])->name('app.procurement.biddings.bids.store');
Route::put('/bids/{bid}', [YourBidController::class, 'updateBid'])->name('bids.update');
Route::get('/procurement-indexbids', [BidController::class, 'index'])->name('app.procurement.indexbids');
Route::get('/procurement-listbids/{productId}', [BidController::class, 'show'])->name('app.procurement.listbids');
Route::get('/invoice/view/{invoiceId}', [BidController::class, 'viewInvoice'])->name('viewInvoice');
Route::put('/invoice/update/{invoiceId}', [BidController::class, 'updateInvoice'])->name('updateInvoice');
Route::get('app/procurement/invoices/invoice-template/{invoiceId}', [BidController::class, 'viewInvoice'])->name('app.procurement.invoices.invoice-template');
Route::get('/invoice/create/{winnerId}', [BidController::class, 'createInvoice'])->name('createInvoice');

Route::get('/invoices', [BidController::class, 'indexInvoices'])
     ->name('app.procurement.invoices.index');

Route::get('/bids/{bid}/invoice/edit', [BidController::class, 'editInvoice'])
     ->name('app.procurement.invoices.edit');

Route::put('/bids/{bid}/invoice/update', [BidController::class, 'updateInvoice'])
     ->name('app.procurement.invoices.update');
Route::post('/app/procurement/invoices/{invoice}/payment', [BidController::class, 'processPayment'])->name('app.procurement.invoices.payment');

Route::get('/BiddingsPage', [UserPageBiddingController::class, 'index'])->name('app.procurement.biddings.userpagebidding');

Route::resource('supplierbidding', SupplierBidController::class)
     ->except(['show', 'edit', 'update', 'destroy']); // Exclude actions not used initially

// You might need to manually add the create route (adjust if needed):
Route::get('/supplierbidding/create', [SupplierBidController::class, 'create'])->name('app.procurement.supplierbidding.create');
Route::post('/supplierbidding/submit-bid', [SupplierBidController::class, 'store'])->name('app.procurement.supplierbidding.store');


//inventory
Route::view('/inventory', 'app.inventory.dashboard');
Route::resource('products', ProductController::class);
Route::get('/products', [ProductController::class, 'index'])->name('app.products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('app.products.create');
Route::post('/products', [ProductController::class, 'store'])->name('app.products.store');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('app.products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('app.products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('app.products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('app.products.destroy');



//integration
Route::get('/quality-standards', [QualityStandardController::class, 'index'])->name('app.quality-standards.index');




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/test-winners', function () {
  Log::debug("determineWinners function started");
  $biddingProducts = BiddingProduct::where('end_date', '<=', now())
      ->whereDoesntHave('winners')
      ->get();

  if ($biddingProducts->isEmpty()) {
      return "Winners already determined for all bidding products.";
  }

  $productsProcessed = 0;

  foreach ($biddingProducts as $biddingProduct) {
      if ($biddingProduct->winners->count() > 0) {
          continue; // Skip to the next product if winners already exist
      }

      $biddingProduct->determineWinners();
      $productsProcessed++;
  }

  return "determineWinners function executed for $productsProcessed bidding products.";
});

Route::get('/phpinfo', function () {
  return phpinfo();
});
Route::get('/gdtest', function () {
  if (!function_exists('gd_info')) {
      return 'GD extension is not installed.';
  }

  $gdInfo = gd_info();
  return 'GD Support: Enabled <br>' .
         'GD Version: ' . $gdInfo['GD Version'];
});
