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


// procurement
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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
