<?php

use App\Http\Controllers\CoffeeWallController;
use App\Models\Business;
use App\Models\School;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/dashboard', function () {
//     return view('admin.app');
// })->middleware(['auth'])->name('dashboard');

// Route::get('/test/email', function () {
//     $defaulLang = getDefaultLanguage(1);
//     $data = Business::with(['businessDetail' => function ($q) use($defaulLang) {
//         $q->where('business_details.language_id', $defaulLang->id);
//     }])->whereId(1)->first();
//     return $data;
// });
Route::get('/paypal/success', [CoffeeWallController::class, 'paypalSuccess'])->name('paypal.success');
Route::get('/paypal/cancel', [CoffeeWallController::class, 'paypalCancel'])->name('paypal.cancel');

Route::get('/cron/job/run-queue', function () {
    \Artisan::call("queue:listen");
});

require __DIR__ . '/auth.php';
Route::post('/stripe/webhook', [StripeWebHookController::class, 'index'])->name('stripe.webhook');
Route::view('/admin/{any}', 'admin.app')
    ->middleware(['auth', 'auth:sanctum'])
    ->where('any', '.*');
require __DIR__ . '/web-routes.php';
if (env('APP_ENV') != 'local') {
    URL::forceScheme('https');
}
