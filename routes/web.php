<?php

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

Route::get('/', function () {
    return view('welcome');
})->name("index");

Route::prefix("vendor")->group(function (){
    Route::get("login", [\App\Http\Controllers\Auth\LoginController::class, "showVendorLoginForm"])->name("vendor-login");
    Route::post("login", [\App\Http\Controllers\Auth\LoginController::class, "submitVendorLoginForm"]);

    Route::get("register", [\App\Http\Controllers\Auth\RegisterController::class, "showVendorRegisterForm"])->name("vendor-register");
    Route::post("register", [\App\Http\Controllers\Auth\RegisterController::class, "submitVendorRegisterForm"]);

    Route::middleware("auth:vendor")->group(function (){
        Route::get("dashboard", [\App\Http\Controllers\Home::class, "index"])->name("vendor-dashboard");

        Route::get("create-plan", [\App\Http\Controllers\Vendor::class, "addPlan"])->name("create-plan");
        Route::post("create-plan", [\App\Http\Controllers\Vendor::class, "storePlan"]);

        Route::get("all-plans", [\App\Http\Controllers\Vendor::class, 'viewPlans'])->name("all-plans");
        Route::get("view-plans-ajax", [\App\Http\Controllers\Vendor::class, 'plansDatatableAjax'])->name("plans-datatable");

        Route::get("plan/{id}", [\App\Http\Controllers\Vendor::class, "viewPlan"])->name("view-plan");

        /**
         * view plan users
         */
        Route::get("plan/{id}/users", [\App\Http\Controllers\Vendor::class, "viewPlanUsers"])->name("view-plan-users");
        Route::get("plan/{id}/users/ajax", [\App\Http\Controllers\Vendor::class, "viewPlanUsersAjax"])->name("plan-users-ajax");

        Route::get("plan/{id}/delete", [\App\Http\Controllers\Vendor::class, "deletePlan"]);

        Route::get("plan/{id}/edit", [\App\Http\Controllers\Vendor::class, "showEditPlan"])->name("edit-plan");
        Route::post("plan/{id}/edit", [\App\Http\Controllers\Vendor::class, "editPlan"]);

        Route::get("profile", [\App\Http\Controllers\Vendor::class, "profileView"])->name("vendor-profile");
        Route::post("profile", [\App\Http\Controllers\Vendor::class, "storeProfile"]);

        Route::get("change-password", [\App\Http\Controllers\Vendor::class, "showChangePassword"])->name("change-password");
        Route::post("change-password", [\App\Http\Controllers\Vendor::class, "changePassword"]);

        Route::get("wallet", [\App\Http\Controllers\Vendor::class, "showWallet"])->name("vendor-wallet");
        Route::post("wallet", [\App\Http\Controllers\Vendor::class, "addAccount"]);

        Route::get("withdraw", [\App\Http\Controllers\Vendor::class, "showWithdraw"])->name("vendor-withdraw");
    });
});

/**
 * User Auth Routes
 */

Route::get("withdraw-request:ajax", [\App\Http\Controllers\Wallet::class, "withdrawRequestAjax"]);
Route::get("search-vendors:ajax", [\App\Http\Controllers\User::class, "vendorListAjax"]);

Route::get("/login", [\App\Http\Controllers\Auth\LoginController::class, "showUserLoginForm"])->name("login");
Route::post("/login", [\App\Http\Controllers\Auth\LoginController::class, "submitUserLoginForm"]);
Route::get("/register", [\App\Http\Controllers\Auth\RegisterController::class, "showUserRegisterForm"])->name("register");
Route::post("/register", [\App\Http\Controllers\Auth\RegisterController::class, "submitUserRegisterForm"]);
Route::get("logout", [\App\Http\Controllers\Auth\LoginController::class, "logout"])->name("logout");

Route::middleware("auth:web")->group(function (){
    Route::get("dashboard", [\App\Http\Controllers\Home::class, "index"])->name("dashboard");

    Route::get("/vendors", [\App\Http\Controllers\User::class, "vendorList"])->name("vendor-list");
    Route::get("/vendor/{id}", [\App\Http\Controllers\User::class, "viewSingleVendor"])->name("single-vendor");

    Route::get("/profile", [\App\Http\Controllers\User::class, 'profileView'])->name("profile");
    Route::post("/profile", [\App\Http\Controllers\User::class, 'storeProfile']);

    Route::get("ajaxMyPlans", [\App\Http\Controllers\User::class, 'myPlans'])->name("ajaxMyPlan");
    Route::get("/myplans", [\App\Http\Controllers\User::class, 'viewMyPlans'])->name('my-plans');

    /**
     * wallet
     */
    Route::get("/edit_account", [\App\Http\Controllers\User::class, 'accountDetails'])->name("edit-account");
    Route::post("/edit_account", [\App\Http\Controllers\User::class, 'addAccount']);
    Route::get("/withdraw", [\App\Http\Controllers\User::class, 'withdraw'])->name("user-withdraw");
    Route::post("/withdraw",[\App\Http\Controllers\User::class, 'submitWithdraw']);

    Route::get("/plan-subscribe/{id}", [\App\Http\Controllers\User::class, 'subscribeToPlan']);

    /**
     * fund wallet
     */
    Route::get('/fund-wallet', [\App\Http\Controllers\Pay::class, "fundWallet"])->name('fund-wallet');
    Route::post('/fund-wallet', [\App\Http\Controllers\Pay::class, "initialize"]);
    Route::post('/fund/callback', [\App\Http\Controllers\Pay::class, "fundWalletCallback"])->name('fund-callback');

});
