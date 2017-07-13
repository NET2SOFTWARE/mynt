<?php

Route::get('/', function () {return view('welcome');});
            Route::post('/',            'Api\ProductPurchaseController@store')->name('product.purchase.store');

Route::get('/login/member/company',     'Auth\LoginController@showLoginMemberCompanyForm')->name('login.member.company');
Route::post('/login/member/company',    'Auth\LoginController@loginMemberCompany')->name('post.login.member.company');
Route::get('/login/merchant',           'Auth\LoginController@showLoginMerchantForm')->name('login.merchant');
Route::post('/login/merchant',          'Auth\LoginController@loginMerchant')->name('post.login.merchant');
Route::get('/login/company',            'Auth\LoginController@showLoginCompanyForm')->name('login.company');
Route::post('/login/company',           'Auth\LoginController@loginCompany')->name('post.login.company');


Route::get('/generate/token/{account}',    'Member\TokenController@requestToken')->name('generate.token');


Route::get('/get_captcha', function (\Mews\Captcha\Captcha $captcha){return $captcha->src('default');});
Route::get('/under_construction', function () { return view('under-construction'); })->name('construction');

Route::get('/notification/confirmation',    'EmailConfirmationController@notification')->name('notify.confirmation');
Route::get('/confirmation/{token}',         'EmailConfirmationController@confirm')->name('account.confirmed');
Route::post('/confirmation/resend',         'EmailConfirmationController@resend')->name('account.confirmation.resend');
Route::get('/mynt-id',                      'MyntController@showForm')->middleware('confirmation')->name('mynt_id');
Route::post('/mynt-id',                     'MyntController@store')->middleware('confirmation')->name('mynt_id.store');




Auth::routes();

Route::get('/home', 'HomeController@index')->middleware(['confirmation', 'mynt'])->name('home');



Route::group(['middleware' => ['auth', 'confirmation', 'mynt']], function () {

    Route::prefix('user/member')->group(function () {
        Route::get('/profile',                              'MemberController@profile')->name('profile');
        Route::get('/upgrade',                              'MemberController@upgrade')->name('upgrade');
        Route::post('/upgrade',                             'MemberController@upgraded')->name('upgrade.member');

        Route::get('/accounting',                           'Member\AccountingController@index')->name('member.accounting');
        Route::get('/accounting/{id}',                      'Member\AccountingController@show')->name('member.accounting.show');

        Route::get('/transactions/account',                 'Member\TransactionController@account')->name('member.transactions.account');
        Route::get('/transactions/bank',                    'Member\TransactionController@bank')->name('member.transactions.bank');
        Route::get('/transactions/remittance',              'Member\TransactionController@remittance')->name('member.transactions.remittance');
        Route::get('/transactions/redeem',                  'Member\TransactionController@redeem')->name('member.transactions.redeem');

        Route::post('/transactions/account',                'Member\TransactionController@transferToAccount')->name('member.transactions.account.store');
        Route::get('/purchase',                             'Member\PurchaseController@index')->name('member.purchase');
        Route::get('/payment',                              'Member\PaymentController@index')->name('member.payment');

        Route::get('/accessibility/personal',               'Member\AccessibilityController@personal')->name('member.accessibility');
        Route::get('/accessibility/notification',           'Member\AccessibilityController@notification')->name('member.accessibility.notification');
        Route::get('/accessibility/log/access',             'Member\AccessibilityController@log')->name('member.accessibility.log.access');

        Route::get('/management/personal',                  'Member\ManagementController@personal')->name('member.management');
        Route::get('/management/bank',                      'Member\BankController@index')->name('member.management.bank');
        Route::post('/management/bank',                     'Member\BankController@store')->name('member.management.bank.store');
        Route::patch('/management/bank',                    'Member\BankController@store')->name('member.management.bank.update');
        Route::get('/management/child',                     'Member\ManagementController@child')->name('member.management.child');

        Route::get('/token',                                'Member\TokenController@showForm')->name('member.token.form');
        Route::post('/token',                               'Member\TokenController@store')->name('member.token.store');

        Route::get('/child-account',                        'Member\ChildController@index')->name('child.index');
        Route::get('/child-account/new',                    'Member\ChildController@showForm')->name('child.form');
        Route::post('/child-account',                       'Member\ChildController@createChild')->name('child.store');
        Route::get('/bank',                                 'Member\BankController@index')->name('bank.index');
        Route::post('/bank',                                'Member\BankController@store')->name('bank.store');
    });



    Route::prefix('user/merchant')->group(function () {
        Route::get('/profile',                      'Merchant\ProfileController@profile')->name('merchant.profile');
        Route::get('/accounting',                   'Merchant\AccountingController@accounting')->name('merchant.accounting');
        Route::post('/accounting',                  'Merchant\AccountingController@sort_accounting')->name('merchant.sort.accounting');
        Route::get('/transaction/account',          'Merchant\TransactionController@account')->name('merchant.transaction.account');
        Route::post('/transaction/account',         'Merchant\TransactionController@store_account')->name('merchant.transaction.account.store');
        Route::get('/transaction/bank',             'Merchant\TransactionController@bank')->name('merchant.transaction.bank');
        Route::get('/transaction/remittance',       'Merchant\TransactionController@remittance')->name('merchant.transaction.remittance');
        Route::get('/transaction/redeem',           'Merchant\TransactionController@redeem')->name('merchant.transaction.redeem');
        Route::get('/summary/transaction/product',  'Merchant\SummaryController@summary')->name('merchant.summary.product');
        Route::get('/summary/transaction/payment',  'Merchant\SummaryController@summaryPayment')->name('merchant.summary.payment');
        Route::get('/summary/transaction/purchase', 'Merchant\SummaryController@summaryPurchase')->name('merchant.summary.purchase');
        Route::get('/accessibility/notification',   'Merchant\AccessibilityController@notification')->name('merchant.accessibility.notification');
        Route::get('/accessibility/log/access',     'Merchant\AccessibilityController@log_access')->name('merchant.accessibility.log_access');
        Route::get('/management/account',           'Merchant\ManagementController@account')->name('merchant.management.account');
        Route::get('/management/bank',              'Merchant\ManagementController@bank')->name('merchant.management.bank');
        Route::get('/management/bank/create',       'Merchant\ManagementController@bankCreate')->name('merchant.management.bank.create');
        Route::post('/management/bank',             'Merchant\ManagementController@bankStore')->name('merchant.management.bank.store');
    });

    Route::prefix('user/company')->group(function () {
        Route::get('/profile',                      'Company\ProfileController@profile')->name('company.profile');
        Route::get('/accounting',                   'Company\AccountingController@accounting')->name('company.accounting');
        Route::post('/accounting',                  'Company\AccountingController@sort')->name('company.sort.accounting');
        Route::get('/transaction/account',          'Company\TransactionController@account')->name('company.transaction.account');
        Route::post('/transaction/account',         'Company\TransactionController@store_account')->name('company.transaction.account.store');
        Route::get('/transaction/bank',             'Company\TransactionController@bank')->name('company.transaction.bank');
        Route::get('/transaction/remittance',       'Company\TransactionController@remittance')->name('company.transaction.remittance');
        Route::get('/transaction/redeem',           'Company\TransactionController@redeem')->name('company.transaction.redeem');
        Route::get('/list/member',                  'Company\GroupController@list')->name('company.list.member');
        Route::post('/list/member',                 'Company\GroupController@sort')->name('company.list.member.sort');
        Route::get('/list/merchant',                'Company\GroupController@listMerchant')->name('company.list.merchant');
        Route::post('/list/merchant',               'Company\GroupController@sortMerchant')->name('company.list.merchant.sort');
        Route::get('/accessibility/notification',   'Company\AccessibilityController@notification')->name('company.accessibility.notification');
        Route::get('/accessibility/log/access',     'Company\AccessibilityController@log')->name('company.accessibility.log');
        Route::get('/management/account',           'Company\ManagementController@account')->name('company.management.account');
        Route::get('/management/bank',              'Company\ManagementController@bank')->name('company.management.bank');
        Route::get('/management/bank/create',       'Company\ManagementController@showFormRegisterBank')->name('company.management.bank.create');
        Route::post('/management/bank',              'Company\ManagementController@storeBank')->name('company.management.bank.store');
    });
});





Route::prefix('admin')->group(function (){
    Route::get('/',         'AdminController@index')->name('admin.home');
    Route::get('/login',    'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login',   'Auth\AdminLoginController@login')->name('admin.login.submit');
});





Route::middleware(['auth:admin'])->group(function (){

    Route::prefix('transaction')->group(function (){
        Route::get('/',             'Api\TransactionController@index')->name('transaction.index');
        Route::get('/success',      'Api\TransactionController@success')->name('transaction.success.index');
        Route::get('/refund',       'Api\TransactionController@refund')->name('transaction.refund.index');
        Route::get('/failed',       'Api\TransactionController@failed')->name('transaction.failed.index');
        Route::get('/create',       'Api\TransactionController@create')->name('transaction.create');
        Route::post('/',            'Api\TransactionController@store')->name('transaction.store');
        Route::post('/sort',        'Api\TransactionController@sort')->name('transaction.sort.index');
        Route::get('/{id}',         'Api\TransactionController@show')->name('transaction.show');
        Route::get('/{id}/edit',    'Api\TransactionController@edit')->name('transaction.edit');
        Route::put('/{id}',         'Api\TransactionController@update')->name('transaction.update');
        Route::patch('/{id}',       'Api\TransactionController@update')->name('transaction.update');
        Route::delete('/{id}',      'Api\TransactionController@destroy')->name('transaction.delete');
    });

    Route::prefix('company')->group(function (){
        Route::get('/',                         'Api\CompanyController@index')->name('company.index');
        Route::get('/create',                   'Api\CompanyController@create')->name('company.create');
        Route::get('/{param}',                  'Api\CompanyController@index')->name('company.index');
        Route::post('/',                        'Api\CompanyController@store')->name('company.store');
        Route::post('/sort',                    'Api\CompanyController@sort')->name('company.sort.index');
        Route::post('/{id}/sort/transactions',  'Api\CompanyController@sortTransactions')->name('company.sort.transactions');
        Route::post('/{id}/sort/members',       'Api\CompanyController@sortMembers')->name('company.sort.members');
        Route::get('/{id}',                     'Api\CompanyController@show')->name('company.show');
        Route::get('/{id}/edit',                'Api\CompanyController@edit')->name('company.edit');
        Route::get('/{id}/transactions',        'Api\CompanyController@transactions')->name('company.transactions');
        Route::get('/{id}/members',             'Api\CompanyController@members')->name('company.members');
        Route::put('/{id}',                     'Api\CompanyController@update')->name('company.update');
        Route::patch('/{id}',                   'Api\CompanyController@update')->name('company.update');
        Route::delete('/{id}',                  'Api\CompanyController@destroy')->name('company.delete');
        Route::delete('/{id}/deactivate',       'Api\CompanyController@deactivate')->name('company.deactivate');
    });

    Route::prefix('merchant')->group(function (){

        Route::patch('/{id}/product',           'Api\MerchantController@saveProduct')->name('merchant.save.product');
        Route::patch('/{id}/terminal',          'Api\MerchantController@saveTerminal')->name('merchant.save.terminal');
        Route::patch('/{id}/bank',              'Api\MerchantController@saveBank')->name('merchant.save.bank');
        Route::patch('/{id}/account',           'Api\MerchantController@updateAccount')->name('merchant.update.account');
        Route::patch('/{id}/image',             'Api\MerchantController@changeImage')->name('merchant.change.image');
        Route::patch('/{id}/image',             'Api\MerchantController@changeImage')->name('merchant.change.image');
        Route::patch('/{id}/location',          'Api\MerchantController@saveLocation')->name('merchant.save.location');
        Route::patch('/{id}/pic',               'Api\MerchantController@savePic')->name('merchant.save.pic');
        Route::patch('/{id}/pic/location',      'Api\MerchantController@savePicLocation')->name('merchant.save.pic.location');
        Route::post('/sort',                    'Api\MerchantController@sort')->name('merchant.sort');
        Route::post('/sort/deactivate',         'Api\MerchantController@sortDeactivate')->name('merchant.deactivate.sort');
        Route::post('/sort/transactions',       'Api\MerchantController@sortTransactions')->name('merchant.transactions.sort');
        Route::post('{id}/sort/transactions',   'Api\MerchantController@sortDetailTransactions')->name('merchant.detail.transactions.sort');
        Route::get('/',                         'Api\MerchantController@index')->name('merchant.index');
        Route::get('/deactivate',               'Api\MerchantController@deactivate_page')->name('merchant.deactivate.index');
        Route::get('/transactions',             'Api\MerchantController@transactions_page')->name('merchant.transactions.index');
        Route::get('/group',                    'Api\MerchantController@group')->name('merchant.group.index');
        Route::get('/individual',               'Api\MerchantController@individual')->name('merchant.individual.index');
        Route::get('/create',                   'Api\MerchantController@create')->name('merchant.create');
        Route::post('/',                        'Api\MerchantController@store')->name('merchant.store');
        Route::get('/{id}',                     'Api\MerchantController@show')->name('merchant.show');
        Route::get('/{id}/edit',                'Api\MerchantController@edit')->name('merchant.edit');
        Route::get('/{id}/transactions',        'Api\MerchantController@transactions')->name('merchant.transactions');
        Route::put('/{id}',                     'Api\MerchantController@update')->name('merchant.update');
        Route::patch('/{id}',                   'Api\MerchantController@update')->name('merchant.update');
        Route::delete('/{id}',                  'Api\MerchantController@destroy')->name('merchant.delete');
        Route::delete('/{id}/deactivate',       'Api\MerchantController@deactivate')->name('merchant.deactivate');
    });

    Route::prefix('member')->group(function (){
        Route::get('/',                         'Api\MemberController@index')->name('member.index');
        Route::get('/create',                   'Api\MemberController@create')->name('member.create');
        Route::get('/pending/upgrade',          'Api\MemberController@pending_upgrade')->name('member.pending_upgrade');
        Route::get('/child_account',            'Api\MemberController@child_account')->name('member.child_account');
        Route::get('/approval',                 'Api\MemberController@approval')->name('member.approval');
        Route::get('/document',                 'Api\MemberController@document')->name('member.document');
        Route::get('/deactivate',               'Api\MemberController@deactivate')->name('member.deactivate');
        Route::get('/deactivate/{member_id}',   'Api\MemberController@deactivate_process')->name('member.deactivate.process');
        Route::get('/transactions',             'Api\MemberController@transactions')->name('member.transactions');
        Route::get('/{id}/transactions',        'Api\MemberController@detailTransactions')->name('member.detail.transactions.index');
        Route::get('/{id}',                     'Api\MemberController@show')->name('member.show');
        Route::get('/{id}/edit',                'Api\MemberController@edit')->name('member.edit');
        Route::get('/approve/{id}/{number}',    'Api\MemberController@approve')->name('member.approve');
        Route::post('/',                        'Api\MemberController@store')->name('member.store');
        Route::post('/sort',                    'Api\MemberController@sortAllMember')->name('member.sort.index');
        Route::post('/sort/deactivate',         'Api\MemberController@sortDeactivatePage')->name('member.sort.deactivate');
        Route::post('/sort/pending/upgrade',    'Api\MemberController@sortPendingUpgrade')->name('member.sort.pending_upgrade');
        Route::post('/sort/child_account',      'Api\MemberController@sortChildACccount')->name('member.child_account.sort');
        Route::post('/sort/document',           'Api\MemberController@sortDocument')->name('member.document.sort');
        Route::post('/sort/confirm',            'Api\MemberController@sortMemberNeedConfirmation')->name('member.sort.confirm');
        Route::post('/sort/transactions',       'Api\MemberController@sortTransactions')->name('member.transactions.sort');
        Route::post('/{id}/sort/transactions',  'Api\MemberController@sortDetailTransactions')->name('member.detail.transactions.sort');
        Route::put('/{id}',                     'Api\MemberController@update')->name('member.update');
        Route::patch('/{id}',                   'Api\MemberController@update')->name('member.update');
        Route::patch('/confirm/{id}',           'Api\MemberController@confirm')->name('member.confirm');
        Route::delete('/{id}',                  'Api\MemberController@destroy')->name('member.delete');
    });

    Route::prefix('service')->group(function (){
        Route::get('/',                 'Api\ServiceController@index')->name('service.index');
        Route::get('/create',           'Api\ServiceController@create')->name('service.create');
        Route::get('/deactivate',       'Api\ServiceController@deactivatePage')->name('service.deactivate.index');
        Route::get('/deactivate/{id}',  'Api\ServiceController@deactivateProcess')->name('service.deactivate.process');
        Route::post('/',                'Api\ServiceController@store')->name('service.store');
        Route::post('/sort',            'Api\ServiceController@sort')->name('service.sort.index');
        Route::post('/deactivate/sort', 'Api\ServiceController@deactivateSort')->name('service.deactivate.sort');
        Route::get('/{id}',             'Api\ServiceController@show')->name('service.show');
        Route::get('/{id}/edit',        'Api\ServiceController@edit')->name('service.edit');
        Route::put('/{id}',             'Api\ServiceController@update')->name('service.update');
        Route::patch('/{id}',           'Api\ServiceController@update')->name('service.update');
        Route::delete('/{id}',          'Api\ServiceController@destroy')->name('service.delete');
    });

    Route::prefix('product')->group(function (){
        Route::get('/',                 'Api\ProductController@index')->name('product.index');
        Route::get('/create',           'Api\ProductController@create')->name('product.create');
        Route::get('/deactivate',       'Api\ProductController@deactivatePage')->name('product.deactivate.index');
        Route::get('/deactivate/{id}',  'Api\ProductController@deactivateProcess')->name('product.deactivate.process');

        # Route::get('/{id}',             'Api\ProductController@show')->name('product.show');
        Route::get('/{id}/edit',        'Api\ProductController@edit')->name('product.edit');
        Route::post('/',                'Api\ProductController@store')->name('product.store');
        Route::post('/sort',            'Api\ProductController@sort')->name('product.sort');
        Route::post('/deactivate/sort', 'Api\ProductController@deactivateSort')->name('product.deactivate.sort');
        Route::put('/{id}',             'Api\ProductController@update')->name('product.update');
        Route::patch('/{id}',           'Api\ProductController@update')->name('product.update');
        Route::delete('/{id}',          'Api\ProductController@destroy')->name('product.delete');

        Route::prefix('/pricing/purchase')->group(function (){
            Route::get('/',             'Api\ProductPurchaseController@index')->name('product.purchase.index'); 
            Route::get('/create',       'Api\ProductPurchaseController@create')->name('product.purchase.create');
            Route::post('/',            'Api\ProductPurchaseController@store')->name('product.purchase.store');
            Route::post('/sort',        'Api\ProductPurchaseController@sort')->name('product.purchase.sort');
            Route::get('/{id}/edit',    'Api\ProductPurchaseController@edit')->name('product.purchase.edit');
            Route::put('/{id}',         'Api\ProductPurchaseController@update')->name('product.purchase.update');
            Route::patch('/{id}',       'Api\ProductPurchaseController@update')->name('product.purchase.update');
            Route::delete('/{id}',      'Api\ProductPurchaseController@destroy')->name('product.purchase.delete');
        });

        Route::prefix('/pricing/sales')->group(function (){
            Route::get('/',             'Api\ProductSalesController@index')->name('product.sales.index'); 
            Route::get('/create',       'Api\ProductSalesController@create')->name('product.sales.create');
            Route::post('/',            'Api\ProductSalesController@store')->name('product.sales.store');
            Route::post('/sort',        'Api\ProductSalesController@sort')->name('product.sales.sort');
            Route::get('/{id}/edit',    'Api\ProductSalesController@edit')->name('product.sales.edit');
            Route::put('/{id}',         'Api\ProductSalesController@update')->name('product.sales.update');
            Route::patch('/{id}',       'Api\ProductSalesController@update')->name('product.sales.update');
            Route::delete('/{id}',      'Api\ProductSalesController@destroy')->name('product.sales.delete');
        });

        Route::prefix('/charges')->group(function (){
            Route::get('/',             'Api\ProductChargeController@index')->name('product.charge.index'); 
            Route::get('/create',       'Api\ProductChargeController@create')->name('product.charge.create');
            Route::post('/',            'Api\ProductChargeController@store')->name('product.charge.store');
            Route::post('/sort',        'Api\ProductChargeController@sort')->name('product.charge.sort');
            Route::get('/{id}/edit',    'Api\ProductChargeController@edit')->name('product.charge.edit');
            Route::put('/{id}',         'Api\ProductChargeController@update')->name('product.charge.update');
            Route::patch('/{id}',       'Api\ProductChargeController@update')->name('product.charge.update');
            Route::delete('/{id}',      'Api\ProductChargeController@destroy')->name('product.charge.delete');
        });

        Route::prefix('/fees')->group(function (){
            Route::get('/',             'Api\ProductFeeController@all')->name('product.fee.all'); 
            Route::post('/sort',        'Api\ProductFeeController@sortAll')->name('product.fee.sort.all');
            Route::prefix('/{product_id}')->group(function (){
                Route::get('/',             'Api\ProductFeeController@index')->name('product.fee.index'); 
                Route::get('/create',       'Api\ProductFeeController@create')->name('product.fee.create');
                Route::post('/',            'Api\ProductFeeController@store')->name('product.fee.store');
                Route::post('/sort',        'Api\ProductFeeController@sort')->name('product.fee.sort');
                Route::get('/{id}/edit',    'Api\ProductFeeController@edit')->name('product.fee.edit');
                Route::put('/{id}',         'Api\ProductFeeController@update')->name('product.fee.update');
                Route::patch('/{id}',       'Api\ProductFeeController@update')->name('product.fee.update');
                Route::delete('/{id}',      'Api\ProductFeeController@destroy')->name('product.fee.delete');
            });
        });
    });

    Route::prefix('administrator')->group(function (){
        Route::get('/create',           'Api\AdministratorController@create')->name('administrator.create');
        Route::get('/deactivate',       'Api\AdministratorController@deactivatePage')->name('administrator.deactivate.index');
        Route::get('/deactivate/{id}',  'Api\AdministratorController@deactivateProcess')->name('administrator.deactivate.process');
        Route::get('/{param}',          'Api\AdministratorController@index')->name('administrator.index');
        Route::post('/',                'Api\AdministratorController@store')->name('administrator.store');
        Route::post('/sort',            'Api\AdministratorController@sort')->name('administrator.sort.index');
        Route::post('/deactivate/sort', 'Api\AdministratorController@deactivateSort')->name('administrator.deactivate.sort');
        Route::get('/{id}',             'Api\AdministratorController@show')->name('administrator.show');
        Route::get('/{id}/edit',        'Api\AdministratorController@edit')->name('administrator.edit');
        Route::put('/{id}',             'Api\AdministratorController@update')->name('administrator.update');
        Route::patch('/{id}',           'Api\AdministratorController@update')->name('administrator.update');
        Route::delete('/{id}',          'Api\AdministratorController@destroy')->name('administrator.delete');
    });

    Route::prefix('terminal')->group(function (){
        Route::get('/',                 'Api\TerminalController@index')->name('terminal.index');
        Route::get('/create',           'Api\TerminalController@create')->name('terminal.create');
        Route::get('/deactivate',       'Api\TerminalController@deactivatePage')->name('terminal.deactivate.index');
        Route::get('/deactivate/{id}',  'Api\TerminalController@deactivateProcess')->name('terminal.deactivate.process');
        Route::get('/{id}',             'Api\TerminalController@show')->name('terminal.show');
        Route::get('/{id}/edit',        'Api\TerminalController@edit')->name('terminal.edit');
        Route::post('/',                'Api\TerminalController@store')->name('terminal.store');
        Route::post('/sort',            'Api\TerminalController@sort')->name('terminal.sort');
        Route::post('/deactivate/sort', 'Api\TerminalController@deactivateSort')->name('terminal.deactivate.sort');
        Route::put('/{id}',             'Api\TerminalController@update')->name('terminal.update');
        Route::patch('/{id}',           'Api\TerminalController@update')->name('terminal.update');
        Route::delete('/{id}',          'Api\TerminalController@destroy')->name('terminal.delete');
    });

    Route::prefix('role')->group(function (){
        Route::get('/',             'Api\RoleController@index')->name('role.index');
        Route::get('/create',       'Api\RoleController@create')->name('role.create');
        Route::post('/',            'Api\RoleController@store')->name('role.store');
        Route::get('/{id}',         'Api\RoleController@show')->name('role.show');
        Route::get('/{id}/edit',    'Api\RoleController@edit')->name('role.edit');
        Route::put('/{id}',         'Api\RoleController@update')->name('role.update');
        Route::patch('/{id}',       'Api\RoleController@update')->name('role.update');
        Route::delete('/{id}',      'Api\RoleController@destroy')->name('role.delete');
    });

    Route::prefix('identity')->group(function (){
        Route::get('/',             'Api\IdentityController@index')->name('identity.index');
        Route::get('/create',       'Api\IdentityController@create')->name('identity.create');
        Route::post('/',            'Api\IdentityController@store')->name('identity.store');
        Route::post('/sort',        'Api\IdentityController@sort')->name('identity.sort.index');
        Route::get('/{id}',         'Api\IdentityController@show')->name('identity.show');
        Route::get('/{id}/edit',    'Api\IdentityController@edit')->name('identity.edit');
        Route::put('/{id}',         'Api\IdentityController@update')->name('identity.update');
        Route::patch('/{id}',       'Api\IdentityController@update')->name('identity.update');
        Route::delete('/{id}',      'Api\IdentityController@destroy')->name('identity.delete');
    });
    Route::prefix('industry')->group(function (){
        Route::get('/',             'Api\IndustryController@index')->name('industry.index');
        Route::get('/create',       'Api\IndustryController@create')->name('industry.create');
        Route::post('/',            'Api\IndustryController@store')->name('industry.store');
        Route::post('/sort',        'Api\IndustryController@sort')->name('industry.sort.index');
        Route::get('/{id}',         'Api\IndustryController@show')->name('industry.show');
        Route::get('/{id}/edit',    'Api\IndustryController@edit')->name('industry.edit');
        Route::put('/{id}',         'Api\IndustryController@update')->name('industry.update');
        Route::patch('/{id}',       'Api\IndustryController@update')->name('industry.update');
        Route::delete('/{id}',      'Api\IndustryController@destroy')->name('industry.delete');
    });
    Route::prefix('partnership')->group(function (){
        Route::get('/',             'Api\PartnershipController@index')->name('partnership.index');
        Route::get('/create',       'Api\PartnershipController@create')->name('partnership.create');
        Route::post('/',            'Api\PartnershipController@store')->name('partnership.store');
        Route::post('/sort',        'Api\PartnershipController@sort')->name('partnership.sort.index');
        Route::get('/{id}',         'Api\PartnershipController@show')->name('partnership.show');
        Route::get('/{id}/edit',    'Api\PartnershipController@edit')->name('partnership.edit');
        Route::put('/{id}',         'Api\PartnershipController@update')->name('partnership.update');
        Route::patch('/{id}',       'Api\PartnershipController@update')->name('partnership.update');
        Route::delete('/{id}',      'Api\PartnershipController@destroy')->name('partnership.delete');
    });
    Route::prefix('country')->group(function (){
        Route::get('/',             'Api\CountryController@index')->name('country.index');
        Route::get('/create',       'Api\CountryController@create')->name('country.create');
        Route::post('/',            'Api\CountryController@store')->name('country.store');
        Route::post('/sort',        'Api\CountryController@sort')->name('country.sort.index');
        Route::get('/{id}',         'Api\CountryController@show')->name('country.show');
        Route::get('/{id}/edit',    'Api\CountryController@edit')->name('country.edit');
        Route::put('/{id}',         'Api\CountryController@update')->name('country.update');
        Route::patch('/{id}',       'Api\CountryController@update')->name('country.update');
        Route::delete('/{id}',      'Api\CountryController@destroy')->name('country.delete');
    });
    Route::prefix('state')->group(function (){
        Route::get('/',             'Api\StateController@index')->name('state.index');
        Route::get('/create',       'Api\StateController@create')->name('state.create');
        Route::post('/',            'Api\StateController@store')->name('state.store');
        Route::post('/sort',        'Api\StateController@sort')->name('state.sort.index');
        Route::get('/{id}',         'Api\StateController@show')->name('state.show');
        Route::get('/{id}/edit',    'Api\StateController@edit')->name('state.edit');
        Route::put('/{id}',         'Api\StateController@update')->name('state.update');
        Route::patch('/{id}',       'Api\StateController@update')->name('state.update');
        Route::delete('/{id}',      'Api\StateController@destroy')->name('state.delete');
    });
    Route::prefix('city')->group(function (){
        Route::get('/',             'Api\CityController@index')->name('city.index');
        Route::get('/create',       'Api\CityController@create')->name('city.create');
        Route::post('/',            'Api\CityController@store')->name('city.store');
        Route::post('/sort',        'Api\CityController@sort')->name('city.sort.index');
        Route::get('/{id}',         'Api\CityController@show')->name('city.show');
        Route::get('/{id}/edit',    'Api\CityController@edit')->name('city.edit');
        Route::put('/{id}',         'Api\CityController@update')->name('city.update');
        Route::patch('/{id}',       'Api\CityController@update')->name('city.update');
        Route::delete('/{id}',      'Api\CityController@destroy')->name('city.delete');
    });

    Route::prefix('charge')->group(function (){
        Route::get('/',             'Api\ChargeController@index')->name('charge.index');
        Route::get('/create',       'Api\ChargeController@create')->name('charge.create');
        Route::post('/',            'Api\ChargeController@store')->name('charge.store');
        Route::post('/sort',        'Api\ChargeController@sort')->name('charge.sort.index');
        Route::get('/{id}/edit',    'Api\ChargeController@edit')->name('charge.edit');
        Route::put('/{id}',         'Api\ChargeController@update')->name('charge.update');
        Route::patch('/{id}',       'Api\ChargeController@update')->name('charge.update');
        Route::delete('/{id}',      'Api\ChargeController@destroy')->name('charge.delete');

        Route::prefix('map')->group(function (){
            Route::get('/',             'Api\MappingChargeController@index')->name('mapping_charge.index');
            Route::get('/create',       'Api\MappingChargeController@create')->name('mapping_charge.create');
            Route::post('/',            'Api\MappingChargeController@store')->name('mapping_charge.store');
            Route::post('/sort',        'Api\MappingChargeController@sort')->name('mapping_charge.sort.index');
            Route::get('/{id}/edit',    'Api\MappingChargeController@edit')->name('mapping_charge.edit');
            Route::put('/{id}',         'Api\MappingChargeController@update')->name('mapping_charge.update');
            Route::patch('/{id}',       'Api\MappingChargeController@update')->name('mapping_charge.update');
            Route::delete('/{id}',      'Api\MappingChargeController@destroy')->name('mapping_charge.delete');
            
            Route::get('/fees',                                 'Api\MappingFeeController@all')->name('mapping_fee.all');
            Route::get('/{mapping_charge_id}/fees',             'Api\MappingFeeController@index')->name('mapping_fee.index');
            Route::get('/{mapping_charge_id}/fees/create',      'Api\MappingFeeController@create')->name('mapping_fee.create');
            Route::get('/{mapping_charge_id}/fees/{id}/edit',   'Api\MappingFeeController@edit')->name('mapping_fee.edit');
            Route::post('/fees',                                'Api\MappingFeeController@store')->name('mapping_fee.store');
            Route::post('/fees/sort',                           'Api\MappingFeeController@sortAll')->name('mapping_fee.sort.all');
            Route::put('/fees/{id}',                            'Api\MappingFeeController@update')->name('mapping_fee.update');
            Route::delete('/fees/{id}',                         'Api\MappingFeeController@destroy')->name('mapping_fee.delete');
        });
    });


    Route::prefix('report')->group(function (){
        Route::get('/general/ledger',   'Api\GeneralPassbookController@index')->name('general.ledger.index');
        
        Route::get('/company',          'Api\CompanyController@report')->name('report.company.index');
        Route::get('/merchant',         'Api\MerchantController@report')->name('report.merchant.index');
        Route::get('/account',          'Api\AccountController@report')->name('report.account.index');
        Route::get('/service',          'Api\ServiceController@report')->name('report.service.index');
        Route::get('/product',          'Api\ProductController@report')->name('report.product.index');
        Route::get('/tracing',          'Api\TransactionController@report')->name('report.tracing.index');

        Route::post('/company',         'Api\CompanyController@reportShow')->name('report.company.show');
        Route::post('/merchant',        'Api\MerchantController@reportShow')->name('report.merchant.show');
        Route::post('/account',         'Api\AccountController@reportShow')->name('report.account.show');
        Route::post('/service',         'Api\ServiceController@reportShow')->name('report.service.show');
        Route::post('/product',         'Api\ProductController@reportShow')->name('report.product.show');
        Route::post('/tracing',         'Api\TransactionController@reportShow')->name('report.tracing.show');

        Route::post('/company/print',   'Api\CompanyController@reportPrint')->name('report.company.print');
        // Route::post('/merchant/print',   'Api\MerchantController@reportPrint')->name('report.merchant.show');
        // Route::post('/account/print',    'Api\AccountController@reportPrint')->name('report.account.show');
        // Route::post('/service/print',    'Api\ServiceController@reportPrint')->name('report.service.show');
        // Route::post('/product/print',    'Api\ProductController@reportPrint')->name('report.product.show');
        // Route::post('/tracing/print',    'Api\TransactionController@reportPrint')->name('report.tracing.show');
    });
});