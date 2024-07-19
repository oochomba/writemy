<?php

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
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

Route::get('/clear-cache', function () {
   Artisan::call('cache:clear');
   Artisan::call('route:clear');
   Artisan::call('view:clear');
//   Artisan::call('optimize:clear');

   return "Cache cleared successfully";
});


Route::get('/refresh-csrf', function() {
    return response()->json(['csrf_token' => csrf_token()]);
});



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('order','FrontController@bigFormorder');
Route::post('/preorder-form','FrontController@createUser');
Route::post('/post-homework','FrontController@postHomework');

Route::get('financials','ChartController@makeChart');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/load-wallet', 'HomeController@loadWallet');
Route::post('/order/checkout', 'HomeController@checkoutSuccess');
Route::get('/checkout-successful', 'HomeController@paymentSuccess');
Route::get('/settings', 'HomeController@settingsPage');
Route::post('/adjust-budget', 'HomeController@adjustBudget');
Route::post('/create-budget', 'HomeController@createBudget');
Route::post('/delete-budget', 'HomeController@deleteBudget');
Route::post('/update-subject', 'HomeController@updateSubject');
Route::post('/create-subject', 'HomeController@createSubject');
Route::post('/delete-subject', 'HomeController@deleteSubject');
Route::post('/update-type', 'HomeController@updateType');
Route::post('/delete-type', 'HomeController@deleteType');
Route::post('/create-type', 'HomeController@createType');
Route::post('/update-level', 'HomeController@updateLevel');
Route::post('/create-level', 'HomeController@createLevel');
Route::post('/delete-level', 'HomeController@deleteLevel');
Route::post('/update-language', 'HomeController@updateLanguage');
Route::post('/create-language', 'HomeController@createLanguage');
Route::post('/delete-language', 'HomeController@deleteLanguage');
Route::post('/update-style', 'HomeController@updateStyle');
Route::post('/create-style', 'HomeController@createStyle');
Route::post('/delete-style', 'HomeController@deleteStyle');
Route::post('/set-pg', 'HomeController@setPG');
Route::post('/create-articlestypes', 'HomeController@createTypeArticle');
Route::post('/create-article-levels', 'HomeController@articlesLevels');
Route::post('/update-pg', 'HomeController@updatePg');
Route::get('/edit-gateway/{id}', 'HomeController@editGateway');
Route::get('/delete-gateway/{id}', 'HomeController@deletePg');
Route::get('/activate-gateway/{id}', 'HomeController@activatePg');

Route::get('/contacts', 'ContactsController@get');
Route::get('/conversation/{id}', 'ContactsController@getMessagesFor');
Route::post('/conversation/send', 'ContactsController@send');

//academic writing 

Route::get('/new-order','AcademicordersController@newOrder');
Route::post('/create-project', 'AcademicordersController@createOrder');
Route::get('/order/{id}', 'AcademicordersController@viewOrder');
Route::post('/upload-order-file', 'AcademicordersController@uploadFile');
Route::post('/upload-solution-file', 'AcademicordersController@uploadSolution');
Route::get('/edit/{id}', 'AcademicordersController@editOrder');
Route::post('/updated-project', 'AcademicordersController@updateProject');

//articles
Route::get('/article-order','ArticlesController@newOrder');
Route::post('/create-article-order','ArticlesController@createArticleorder');

//profile
Route::get('/view/profile', 'ProfileController@viewProfile');
Route::get('/edit/profile', 'ProfileController@editProfile');
Route::get('/profile/{id}', 'ProfileController@getProfile');
Route::post('/reviewtutor', 'ProfileController@reviewScholar');
Route::post('/upload-photo', 'ProfileController@uploadPhoto');
Route::post('/update-specialization', 'ProfileController@updateSpecialization');
Route::post('/update-profile', 'ProfileController@updateProfile');
Route::post('/edit-profile', 'ProfileController@admineditProfile');
Route::post('/add-reviews', 'ProfileController@adminReview');

//transactions

Route::get('/financial-transactions', 'TransactionsController@allTransactions');
Route::post('/make-withdrawal', 'TransactionsController@makeWithdrawal');
Route::post('/confirm-transaction', 'TransactionsController@confirmTransaction');
Route::post('/decline-transaction', 'TransactionsController@declineTransaction');
Route::post('/send-invoice', 'TransactionsController@sendInvoice');
Route::get('/financial-analysis', 'TransactionsController@financialAnalysis');
Route::get('/client-analysis', 'TransactionsController@clientAnalysis');
Route::get('/withdrawal-transactions', 'TransactionsController@withdrawalTransactions');

Route::get('/send-message', 'MessagesController@createMessage');
Route::get('/received-messages', 'MessagesController@receivedMessages');
Route::get('/sent-messages', 'MessagesController@sentMessages');
Route::post('/post-send-message', 'MessagesController@sendMessage');
Route::post('/post-compose-message', 'MessagesController@directMessage');
Route::post('/delete-message', 'MessagesController@deleteMessage');
Route::get('/message-file/{id}', 'MessagesController@messageFile');
Route::get('/clear-messages/{id}', 'MessagesController@clearMessages');
Route::get('/email-all-clients', 'MessagesController@emailAllClients');
Route::get('/email-all-writers', 'MessagesController@emailWriters');
Route::post('/post-all-clients', 'MessagesController@postSendEmails');
Route::post('/post-all-writers', 'MessagesController@postSendEmailswriters');
Route::get('/reply-message/{id}', 'MessagesController@replyMessage');
//posts

Route::get('/posts','PostsController@getPosts');
Route::get('/create-post','PostsController@createPost');
Route::get('/create-category','PostsController@createCategory');
Route::get('/edit-category/{id}','PostsController@editCategory');
Route::get('/view-posts','PostsController@viewPosts');
Route::get('/view-post/{id}','PostsController@getPost');
Route::get('/edit-post/{id}','PostsController@editPost');
Route::get('/delete-post/{id}','PostsController@deletePost');
Route::get('/toggle-status/{id}','PostsController@toggleStatus');
Route::post('/update-post','PostsController@updatePost');
Route::post('/post-create-post','PostsController@postCreatepost');
Route::post('/post-create-cat','PostsController@postcreateCategory');
Route::post('/update-cat','PostsController@postupdateCategory');
Route::get('/delete-category/{id}','PostsController@deleteCat');

//pages

Route::get('/create-page','PagesController@newPage');
Route::get('/view-pages','PagesController@getPages');
Route::post('/post-create-page','PagesController@createPage');
Route::get('/seo','PagesController@makeSEO');
Route::get('/seo-edit/{id}','PagesController@editSeo');
Route::post('/update-seopost','PagesController@updateSeopost');

Route::get('/menu','MenuController@index');
Route::post('/add-menu-page','MenuController@addMenupage');
Route::post('/add-granchild-menu','MenuController@addGrandChildMenu');

//projects controller

Route::get('/current-orders', 'ProjectsController@currentOrders');
Route::get('/assigned-orders', 'ProjectsController@assignedOrders');
Route::get('/pending-orders', 'ProjectsController@myunpaidOrders');
Route::get('/completed-orders', 'ProjectsController@completedOrders');
Route::get('/orders-in-editing', 'ProjectsController@ordersInEditing');
Route::get('/my-orders', 'ProjectsController@myorders');
Route::get('/available-orders', 'ProjectsController@availableOrders');
Route::get('/my-bids', 'ProjectsController@myBids');
Route::get('/my-revisions', 'ProjectsController@myRevisions');
Route::post('/mark-paid', 'ProjectsController@markPaid');
Route::post('/adjust-pay', 'ProjectsController@adjustPay');
Route::post('/assign-tutor', 'ProjectsController@assignOrder');
Route::post('/change-status', 'ProjectsController@changeStatus');
Route::post('/release-funds', 'ProjectsController@releaseFunds');
Route::post('/delete-order', 'ProjectsController@deleteOrder');
Route::post('/request-revision', 'ProjectsController@requestRevision');
Route::get('/revision-file/{id}', 'ProjectsController@revisionFiles');
Route::post('/delete-revision-file', 'ProjectsController@deleteRevisionfile');

Route::get('/users', 'UseraccountsController@usersPage');
Route::get('/impersonate/{id}', 'UseraccountsController@impersonate');
Route::get('/stop', 'UseraccountsController@stopImpersonate');
Route::get('/add-user', 'UseraccountsController@addUser');
Route::get('/staff', 'UseraccountsController@staff');
Route::get('/all-active-clients', 'UseraccountsController@viewClients');
Route::get('/all-active-writers', 'UseraccountsController@viewWriters');
Route::get('/deactivated-users', 'UseraccountsController@deactivatedAccounts');
Route::post('/post-add-user', 'UseraccountsController@postUser');
Route::post('/change-password', 'UseraccountsController@changePassword');

Route::get('/order-file/{id}', 'OrdersController@orderFile');
Route::post('/delete-order-file', 'OrdersController@deleteOrderfile');
Route::post('/upload-solution-file', 'OrdersController@uploadSolution');
Route::post('/delete-solution-file', 'OrdersController@deleteSolutionfile');
Route::get('/solution-file/{id}', 'OrdersController@downloadSolution');
Route::get('/order-file/{id}', 'OrdersController@orderFile');
Route::post('/upload-order-file', 'OrdersController@uploadFile');
Route::get('/download-zip/{id}', 'OrdersController@downloadZip');
Route::get('/download-zip-solution/{id}', 'OrdersController@downloadSolutionZip');
Route::get('/send-emails', 'SendemailsController@sendEmails');
Route::get('/send-email', 'SendemailsController@sendQueue');
Route::get('/invoice-checkout/{id}', 'SendemailsController@getInvoicehceckout');
Route::get('/payment-successful', 'SendemailsController@paymentSuccess');

Route::post('/place-bid', 'BidsController@createBid');
Route::post('/edit-bid', 'BidsController@editBid');
Route::post('/delete-bid', 'BidsController@deleteBid');
Route::get('/checkout-invoice/{id}', 'BidsController@checkoutInvoice');

Route::post('/pay-invoice', 'InvoiceController@payInvoice');
Route::get('complete-invoice-payment', array('as' => 'complete-invoice-payment','uses' => 'InvoiceController@getPaymentStatus'));
Route::get('cancel-invoice', array('as' => 'cancel-invoice','uses' => 'InvoiceController@getCancel'));

Route::post('/credit-account', 'AccounttransactionsController@creditAccount');
Route::post('/debit-account', 'AccounttransactionsController@debitAccount');
Route::post('/verify-account', 'AccounttransactionsController@verifyAccount');
Route::post('/unverify-account', 'AccounttransactionsController@unverifyAccount');
Route::post('/deactivateaccount', 'AccounttransactionsController@disableAccount');
//load funds via pp
Route::post('/load-funds-viapaypal', 'LoadfundsController@loadfunds');
Route::get('/complete-load-funds', array('as' => 'complete-load-funds','uses' => 'LoadfundsController@getPaymentStatus'));
Route::get('cancel-load', array('as' => 'cancel-load','uses' => 'LoadfundsController@getCancel'));
//load funds via pesapal
Route::get('/pesapal_callback','PesapalController@callBack');
Route::get('/checkout-pesapal/{id}','PesapalController@checkOutPesapal');
Route::post('/load-pesapal','PesapalController@loadPesa');

Route::get('/payment-successful/{id}/{rand}','PesapalController@paymentSuccess');
Route::get('/load-successful/{id}/{rand}','PesapalController@loadSuccess');

Route::post('/pesapal-invoice','PesaInvoice@checkOutPesapal');
Route::get('/pay-incoice-successful/{id}/{rand}','PesaInvoice@loadSuccess');

//invoice paid

Route::get('/invoice-paid-success/{id}','FlutterInvoice@payInvoice');


//load funds via Flutter
Route::post('/load-with-flutter','FlutterWaveController@loadWalletFlutter');
Route::get('/load-success/{id}','FlutterWaveController@walletLoadVerify');
Route::get('/order-paid-success/{id}','FlutterWaveController@orderPaidSuccess');

//order checkout
Route::post('pay-order-paypal','AwardController@assignScholar');
Route::post('pay-order-wallet','AwardController@payOrderWallet');
Route::get('/complete-order-pay', array('as' => 'complete-order-pay','uses' => 'AwardController@getPaymentStatus'));
Route::get('cancel-order-pay', array('as' => 'cancel-order-pay','uses' => 'AwardController@getCancel'));

Route::get('/faqs','BlogController@getFaqs');
Route::get('/blog','BlogController@getBlogs');
Route::get('/pages','BlogController@getPages');
Route::get('/urls','BlogController@getUrls');
Route::get('/{any}','BlogController@findBySlug');