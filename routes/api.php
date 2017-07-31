<?php

use Illuminate\Http\Request;


Route::get('/testing',   'TestingController@testing')->name('testing');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/mobile/member/register',                     'Api\MemberController@store')->name('api.member.store');
Route::post('/mobile/cash/transaction',                     'Api\TransactionController@to_cash')->name('api.transaction.cash');
Route::post('/mobile/remittance/transfer',                 'Api\RemittanceController@transfer')->name('api.remittance.transfer');
Route::post('/mobile/remittance/redeem',                   'Api\RemittanceController@redeem')->name('api.remittance.transfer');

Route::get('/secret',                     'SecretController@get')->name('secret');

Route::prefix('mobile')->middleware('auth:api')->group(function () {
    Route::get('/profile',                              'Api\MemberController@profile')->name('api.profile');
    Route::get('/last/balance/{accountNumber}',         'Api\MemberController@last_balance')->name('api.last.balance');
    Route::post('/upgrade',                             'Api\MemberController@upgrade')->name('api.upgrade');
    Route::get('/history/transaction/{accountNumber}',  'Api\TransactionController@history')->name('api.history.transaction');
    Route::post('/request/token',                       'Api\TransactionController@request_token')->name('api.request.token');
    Route::post('/transaction',                         'Api\TransactionController@transaction')->name('api.transaction');
    // Route::post('/cash/transaction',                    'Api\TransactionController@to_cash')->name('api.transaction.cash');
    Route::post('/member/mynt/create',                  'Api\MemberController@mynt')->name('api.member.mynt');
    Route::get('/check/transaction/status/{trx_id}',    'Api\TransactionController@check_status')->name('api.transaction.check');

    Route::get('/remittance/data',                      'Api\RemittanceController@get')->name('api.remittance.data');
    Route::post('/remittance/register',                 'Api\RemittanceController@register')->name('api.remittance.register');
    Route::get('/remittance/delete/account/{id}',       'Api\RemittanceController@delete_account')->name('api.remittance.delete.account');
//    Route::post('/remittance/transfer',                 'Api\RemittanceController@transfer')->name('api.remittance.transfer');
//    Route::post('/remittance/redeem',                   'Api\RemittanceController@redeem')->name('api.remittance.transfer');
});

Route::prefix('transaction')->group(function (){

    Route::post('/settle',      'Api\InquiryController@settle')->name('api.transaction.settle');
    Route::post('/inquiry',     'Api\InquiryController@store')->name('api.transaction.inquiry');

    Route::get('/list',         'Api\TransactionController@list')->name('api.transaction.list');

    Route::get('/',             'Api\TransactionController@index')->name('api.transaction.index');
    Route::post('/',            'Api\TransactionController@transaction')->name('api.transaction');
    Route::get('/success',      'Api\TransactionController@success')->name('api.transaction.success.index');
    Route::get('/refund',       'Api\TransactionController@refund')->name('api.transaction.refund.index');
    Route::post('/failed',      'Api\TransactionController@failed')->name('api.transaction.failed.store');
    Route::get('/{id}',         'Api\TransactionController@show')->name('api.transaction.show');
    Route::put('/{id}',         'Api\TransactionController@update')->name('api.transaction.update');
    Route::patch('/{id}',       'Api\TransactionController@update')->name('api.transaction.update');
    Route::delete('/{id}',      'Api\TransactionController@destroy')->name('api.transaction.delete');
});

Route::prefix('company')->group(function (){
    Route::get('/',             'Api\CompanyController@index')->name('api.company.index');
    Route::get('/check/{code?}','Api\CompanyController@checkCodeAvalibility')->name('api.company.check');
    Route::post('/',            'Api\CompanyController@store')->name('api.company.store');
    Route::get('/{id}',         'Api\CompanyController@show')->name('api.company.show');
    Route::put('/{id}',         'Api\CompanyController@update')->name('api.company.update');
    Route::patch('/{id}',       'Api\CompanyController@update')->name('api.company.update');
    Route::delete('/{id}',      'Api\CompanyController@destroy')->name('api.company.delete');
    Route::put('/upload/{id}',  'Api\CompanyController@uploadPhoto')->name('api.company.update.upload');
    Route::patch('/upload/{id}','Api\CompanyController@uploadPhoto')->name('api.company.update.upload');
});

Route::prefix('merchant')->group(function (){
    Route::get('/',             'Api\MerchantController@index')->name('api.merchant.index');
    Route::get('/group',        'Api\MerchantController@group')->name('api.merchant.group.index');
    Route::post('/individual',  'Api\MerchantController@individual')->name('api.merchant.individual.store');
    Route::get('/{id}',         'Api\MerchantController@show')->name('api.merchant.show');
    Route::put('/{id}',         'Api\MerchantController@update')->name('api.merchant.update');
    Route::patch('/{id}',       'Api\MerchantController@update')->name('api.merchant.update');
    Route::delete('/{id}',      'Api\MerchantController@destroy')->name('api.merchant.delete');
});

Route::prefix('member')->group(function (){
    Route::get('/',                             'Api\MemberController@index')->name('api.member.index');
    Route::get('/approve/{id}/{number}',        'Api\MemberController@approve')->name('api.member.approve');
    Route::post('/register',                    'Api\MemberController@store')->name('api.member.store');
    Route::get('/{id}',                         'Api\MemberController@show')->name('api.member.show');
    Route::put('/{id}',                         'Api\MemberController@update')->name('api.member.update');
    Route::patch('/{id}',                       'Api\MemberController@update')->name('api.member.update');
    Route::delete('/{id}',                      'Api\MemberController@destroy')->name('api.member.delete');
});

Route::prefix('service')->group(function (){
    Route::get('/',             'Api\ServiceController@index')->name('api.service.index');
    Route::post('/',            'Api\ServiceController@store')->name('api.service.store');
    Route::get('/{id}',         'Api\ServiceController@show')->name('api.service.show');
    Route::put('/{id}',         'Api\ServiceController@update')->name('api.service.update');
    Route::patch('/{id}',       'Api\ServiceController@update')->name('api.service.update');
    Route::delete('/{id}',      'Api\ServiceController@destroy')->name('api.service.delete');
});

Route::prefix('product')->group(function (){
    Route::get('/',             'Api\ProductController@index')->name('api.product.index');
    Route::post('/',            'Api\ProductController@store')->name('api.product.store');
    Route::get('/{id}',         'Api\ProductController@show')->name('api.product.show');
    Route::put('/{id}',         'Api\ProductController@update')->name('api.product.update');
    Route::patch('/{id}',       'Api\ProductController@update')->name('api.product.update');
    Route::delete('/{id}',      'Api\ProductController@destroy')->name('api.product.delete');
});

Route::prefix('administrator')->group(function (){
    Route::get('/{param}',      'Api\AdministratorController@index')->name('api.administrator.index');
    Route::post('/',            'Api\AdministratorController@store')->name('api.administrator.store');
    Route::get('/{id}',         'Api\AdministratorController@show')->name('api.administrator.show');
    Route::put('/{id}',         'Api\AdministratorController@update')->name('api.administrator.update');
    Route::patch('/{id}',       'Api\AdministratorController@update')->name('api.administrator.update');
    Route::delete('/{id}',      'Api\AdministratorController@destroy')->name('api.administrator.delete');
});

Route::prefix('terminal')->group(function (){
    Route::get('/',             'Api\TerminalController@index')->name('api.terminal.index');
    Route::post('/',            'Api\TerminalController@store')->name('api.terminal.store');
    Route::get('/{id}',         'Api\TerminalController@show')->name('api.terminal.show');
    Route::put('/{id}',         'Api\TerminalController@update')->name('api.terminal.update');
    Route::patch('/{id}',       'Api\TerminalController@update')->name('api.terminal.update');
    Route::delete('/{id}',      'Api\TerminalController@destroy')->name('api.terminal.delete');
});


Route::prefix('role')->group(function (){
    Route::get('/',             'Api\RoleController@index')->name('api.role.index');
    Route::post('/',            'Api\RoleController@store')->name('api.role.store');
    Route::get('/{id}',         'Api\RoleController@show')->name('api.role.show');
    Route::put('/{id}',         'Api\RoleController@update')->name('api.role.update');
    Route::patch('/{id}',       'Api\RoleController@update')->name('api.role.update');
    Route::delete('/{id}',      'Api\RoleController@destroy')->name('api.role.delete');
});

Route::prefix('identity')->group(function (){
    Route::get('/',             'Api\IdentityController@index')->name('api.identity.index');
    Route::post('/',            'Api\IdentityController@store')->name('api.identity.store');
    Route::get('/{id}',         'Api\IdentityController@show')->name('api.identity.show');
    Route::put('/{id}',         'Api\IdentityController@update')->name('api.identity.update');
    Route::patch('/{id}',       'Api\IdentityController@update')->name('api.identity.update');
    Route::delete('/{id}',      'Api\IdentityController@destroy')->name('api.identity.delete');
});

Route::prefix('industry')->group(function (){
    Route::get('/',             'Api\IndustryController@index')->name('api.industry.index');
    Route::post('/',            'Api\IndustryController@store')->name('api.industry.store');
    Route::get('/{id}',         'Api\IndustryController@show')->name('api.industry.show');
    Route::put('/{id}',         'Api\IndustryController@update')->name('api.industry.update');
    Route::patch('/{id}',       'Api\IndustryController@update')->name('api.industry.update');
    Route::delete('/{id}',      'Api\IndustryController@destroy')->name('api.industry.delete');
});

Route::prefix('partnership')->group(function (){
    Route::get('/',             'Api\PartnershipController@index')->name('api.partnership.index');
    Route::post('/',            'Api\PartnershipController@store')->name('api.partnership.store');
    Route::get('/{id}',         'Api\PartnershipController@show')->name('api.partnership.show');
    Route::put('/{id}',         'Api\PartnershipController@update')->name('api.partnership.update');
    Route::patch('/{id}',       'Api\PartnershipController@update')->name('api.partnership.update');
    Route::delete('/{id}',      'Api\PartnershipController@destroy')->name('api.partnership.delete');
});

Route::prefix('country')->group(function (){
    Route::get('/',             'Api\CountryController@index')->name('api.country.index');
    Route::post('/',            'Api\CountryController@store')->name('api.country.store');
    Route::get('/{id}',         'Api\CountryController@show')->name('api.country.show');
    Route::put('/{id}',         'Api\CountryController@update')->name('api.country.update');
    Route::patch('/{id}',       'Api\CountryController@update')->name('api.country.update');
    Route::delete('/{id}',      'Api\CountryController@destroy')->name('api.country.delete');
});

Route::prefix('state')->group(function (){
    Route::get('/',             'Api\StateController@index')->name('api.state.index');
    Route::post('/',            'Api\StateController@store')->name('api.state.store');
    Route::get('/{id}',         'Api\StateController@show')->name('api.state.show');
    Route::put('/{id}',         'Api\StateController@update')->name('api.state.update');
    Route::patch('/{id}',       'Api\StateController@update')->name('api.state.update');
    Route::delete('/{id}',      'Api\StateController@destroy')->name('api.state.delete');
});

Route::prefix('city')->group(function (){
    Route::get('/',             'Api\CityController@index')->name('api.city.index');
    Route::post('/',            'Api\CityController@store')->name('api.city.store');
    Route::get('/{id}',         'Api\CityController@show')->name('api.city.show');
    Route::put('/{id}',         'Api\CityController@update')->name('api.city.update');
    Route::patch('/{id}',       'Api\CityController@update')->name('api.city.update');
    Route::delete('/{id}',      'Api\CityController@destroy')->name('api.city.delete');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});