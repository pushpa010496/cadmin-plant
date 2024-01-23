<?php
use App\User;
use Illuminate\Support\Facades\Input;
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

Route::get('/', 'HomeController@main');

 Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/import_excel', 'ImportExcelController@index');
Route::post('/import_excel/import', 'ImportExcelController@import');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/*Company Management*/
Route::resource('/categories', 'CategoryController');
Route::get('select-ajax','CompanyCatalogController@selectAjax');

Route::group(['middleware' => ['permission:company']], function() {
	Route::resource('/companies', 'CompanyController'); });
Route::get('companies/reactivate/{id}','CompanyController@reactivate');
Route::post('companies/metatag/{id}','CompanyController@metatag')->name('companies.meta');

Route::group(['middleware' => ['permission:company']], function() {
	Route::resource('/companyprofile', 'CompanyProfileController'); });
Route::get('companyprofile/reactivate/{id}','CompanyProfileController@reactivate');
Route::post('companyprofile/metatag/{id}','CompanyProfileController@metatag')->name('profile.meta');

Route::group(['middleware' => ['permission:company']], function() {
	Route::resource('/companycatalogs', 'CompanyCatalogController'); });
Route::get('companycatalogs/reactivate/{id}','CompanyCatalogController@reactivate');
Route::post('companycatalogs/metatag/{id}','CompanyCatalogController@metatag')->name('catalog.meta');

Route::group(['middleware' => ['permission:company']], function() {
	Route::resource('/companypressrealeses', 'CompanyPressrealeseController'); });
Route::get('companypressrealeses/reactivate/{id}','CompanyPressrealeseController@reactivate');
Route::post('companypressrealeses/metatag/{id}','CompanyPressrealeseController@metatag')->name('pressreleases.meta');

Route::group(['middleware' => ['permission:company']], function() {
	Route::resource('/companywhitepapers', 'CompanyWhitePaperController'); });
Route::get('companywhitepapers/reactivate/{id}','CompanyWhitePaperController@reactivate');
Route::post('companywhitepapers/metatag/{id}','CompanyWhitePaperController@metatag')->name('whitepaper.meta');

Route::group(['middleware' => ['permission:company']], function() {

	Route::post('companyvideos', 'CompanyVideoController@store')->name('companyvideos.store'); 
	Route::resource('companyvideos', 'CompanyVideoController'); 
});
Route::get('companyvideos/reactivate/{id}','CompanyVideoController@reactivate');
Route::post('companyvideos/metatag/{id}','CompanyVideoController@metatag')->name('video.meta');

Route::group(['middleware' => ['permission:company']], function() {
	Route::resource('/companyprojects', 'CompanyProjectController'); });
Route::get('companyprojects/reactivate/{id}','CompanyProjectController@reactivate');
Route::post('companyprojects/metatag/{id}','CompanyProjectController@metatag')->name('project.meta');

Route::group(['middleware' => ['permission:products']], function() {
	Route::resource('/products', 'ProductController'); 
	Route::get('/product-keywords', 'ProductController@keywords'); 
	Route::get('/product-keywords-status', 'ProductController@statusKeywords'); 
	Route::get('/non-product-keywords', 'ProductController@noKeywords'); 
	Route::resource('/testproducts', 'TestProductController'); 
});
Route::get('products/reactivate/{id}','ProductController@reactivate');

Route::get('product-keyword/reactivate/{id}','ProductController@keywordReactivate');

Route::get('product-keyword/redeactive/{id}','ProductController@keywordRedeactive');

Route::post('product-keyword/delete','ProductController@keywordDelete');

Route::post('products/metatag/{id}','ProductController@metatag');
Route::post('products/keywordmetatag/{id}','ProductController@keywordmetatag');

Route::get('/product_landingpages', 'ProductController@LandingPage')->name('product_landingpages'); 
Route::get('/product_landingpages/create', 'ProductController@createLandingPage')->name('create_product_landingpages'); 
Route::post('/product_landingpages/store', 'ProductController@storeLandingPage')->name('store_product_landingpages'); 
Route::get('/product_landingpages/edit/{id}', 'ProductController@editLandingPage')->name('edit_product_landingpages'); 
Route::put('/product_landingpages/update/{id}', 'ProductController@updateLandingPage')->name('update_product_landingpages'); 
Route::post('product_landingpages/metatag/{id}','ProductController@metatagLandingPage');
Route::delete('/product_landingpages/delete/{id}','ProductController@destroyLandingpage')->name('destroy_product_landingpages');
Route::get('product_landingpages/reactivate/{id}','ProductController@reactivateLandingpage');



/*Company Management*/

/*Users Roles Permissions*/
Route::resource("/users","UserController");
Route::group(['middleware' => ['permission:settings']], function() { Route::resource("/permissions", "PermissionController"); });
Route::group(['middleware' => ['permission:settings']], function() { Route::resource("/roles", "RoleController"); });
/*Users Roles Permissions*/

/*Knowledge bank section*/
Route::group(['middleware' => ['permission:articles']], function() { 
	Route::resource("/articles", "ArticlesController");
	 });
Route::get('articles/reactivate/{id}','ArticlesController@reactivate');
Route::post('articles/metatag/{id}','ArticlesController@metatag');
Route::post('news/metatag/{id}','NewsController@metatag');
Route::post('pressreleases/metatag/{id}','PressreleaseController@metatag');
Route::post('projects/metatag/{id}','ProjectController@metatag');
Route::post('whitepapers/metatag/{id}','WhitepaperController@metatag');
Route::post('reports/metatag/{id}','ReportController@metatag');


Route::group(['middleware' => ['permission:interviews']], function() { 
	Route::resource("/interviews", "InterviewController"); });
Route::get('interviews/reactivate/{id}','InterviewController@reactivate');
Route::post('interviews/metatag/{id}','InterviewController@metatag')->name('interviews.meta');
/*Knowledge bank section end here */


/*eNewsletters section*/
Route::group(['middleware' => ['permission:enewsletters']], function() { 
	Route::resource("/e-newsletters", "NewslatterController");
	 });
Route::get('e-newsletters/reactivate/{id}','NewslatterController@reactivate');


Route::group(['middleware' => ['permission:enewsletters']], function() { 
	Route::resource("/eventnewsletters", "EventNewslatterController");
	 });
Route::get('eventnewsletters/reactivate/{id}','EventNewslatterController@reactivate');

Route::group(['middleware' => ['permission:enewsletters']], function() { 
	Route::resource("/clientemailblast", "ClientemailblastController");
	 });
Route::get('clientemailblast/reactivate/{id}','ClientemailblastController@reactivate');
Route::group(['middleware' => ['permission:enewsletters']], function() { 
	Route::resource("/mediapack", "MediapackController");
	 });
Route::get('mediapack/reactivate/{id}','MediapackController@reactivate');

Route::group(['middleware' => ['permission:partners']], function() { 
	Route::resource("/partners", "PartnerController");
	 });
Route::get('partners/reactivate/{id}','PartnerController@reactivate');

Route::group(['middleware' => ['permission:testimonials']], function() { 
	Route::resource("/testimonials", "TestimonialController");
	 });
Route::get('testimonials/reactivate/{id}','TestimonialController@reactivate');

Route::group(['middleware' => ['permission:projects']], function() { 
	Route::resource("/projects", "ProjectController");
	 });
Route::get('projects/reactivate/{id}','ProjectController@reactivate');

Route::group(['middleware' => ['permission:tender']], function() { 
	Route::resource("/tenders", "TenderController");
	 });
Route::get('tenders/reactivate/{id}','TenderController@reactivate');
Route::post('tender/metatag/{id}','TenderController@metatag');



Route::group(['middleware' => ['permission:cmspages']], function() { 
	Route::resource("/cmspages", "CmspageController");
	 });
Route::get('cmspages/reactivate/{id}','CmspageController@reactivate');

Route::group(['middleware' => ['permission:sliders']], function() { 
	Route::resource("/sliders", "SliderController");
	 });
Route::get('sliders/reactivate/{id}','SliderController@reactivate');

Route::group(['middleware' => ['permission:banners']], function() { 
	Route::resource("/banners", "BannerController");
	 });
Route::get('banners/reactivate/{id}','BannerController@reactivate');

Route::group(['middleware' => ['permission:sliders']], function() { 
	Route::resource("/pages", "PageController");
	 });
Route::get('pages/reactivate/{id}','PageController@reactivate');

Route::resource('webinars','WebinarController');	
	Route::get('webinars/reactivate/{webinar}','WebinarController@reactivate');

/*Events Module*/

	Route::resource("/event-categories", "EventCategoryController");
	Route::post('event-categories/metatag/{id}','EventCategoryController@metatag')->name('event-categories.meta');

Route::group(['middleware' => ['permission:events']], function() { 
	Route::resource("/events", "EventController");
	 });
Route::get('events/reactivate/{id}','EventController@reactivate');
Route::post('events/metatag/{id}','EventController@metatag')->name('events.meta');


Route::group(['middleware' => ['permission:events']], function() { 
	Route::resource("eventprofiles", "EventprofileController");
	 });
Route::get('eventprofiles/reactivate/{id}','EventprofileController@reactivate');
Route::post('eventprofiles/metatag/{id}','EventprofileController@metatag')->name('eventprofile.meta');

Route::group(['middleware' => ['permission:events']], function() { 
	Route::resource("/eventgallery", "EventgalleryController");
	 });
Route::get('eventgallery/reactivate/{id}','EventgalleryController@reactivate');
Route::post('eventgallery/metatag/{id}','EventgalleryController@metatag')->name('eventgallery.meta');

Route::group(['middleware' => ['permission:events']], function() { 
	Route::resource("/eventspeakers", "EventSpeakerController");
	 });
Route::get('eventspeakers/reactivate/{id}','EventSpeakerController@reactivate');
Route::post('eventspeakers/metatag/{id}','EventSpeakerController@metatag')->name('eventspeakers.meta');


Route::group(['middleware' => ['permission:events']], function() { 
	Route::resource("/eventpressrealese", "EventPressrealeseController");
	 });
Route::get('eventpressrealese/reactivate/{id}','EventPressrealeseController@reactivate');
Route::post('eventpressrealese/metatag/{id}','EventPressrealeseController@metatag')->name('eventpressrealese.meta');


Route::group(['middleware' => ['permission:events']], function() { 
	Route::resource("/eventbrochures", "EventBrochureController");
	 });
Route::get('eventbrochures/reactivate/{id}','EventBrochureController@reactivate');
Route::post('eventbrochures/metatag/{id}','EventBrochureController@metatag')->name('eventbrochures.meta');

Route::group(['middleware' => ['permission:events']], function() { 
	Route::resource("/eventpartners", "EventPartnerController");
	 });
Route::get('eventpartners/reactivate/{id}','EventPartnerController@reactivate');
Route::post('eventpartners/metatag/{id}','EventPartnerController@metatag')->name('eventpartners.meta');

/*Events Module End Here*/

/*News / Pressreleases / Reports start*/
Route::group(['middleware' => ['permission:news']], function() { 
	Route::resource("news", "NewsController");
	 });
Route::get('news/reactivate/{id}','NewsController@reactivate');


Route::group(['middleware' => ['permission:pressreleases']], function() { 
	Route::resource("pressreleases", "PressreleaseController");
	 });
Route::get('pressreleases/reactivate/{id}','PressreleaseController@reactivate');

Route::group(['middleware' => ['permission:reports']], function() { 
	Route::resource("reports", "ReportController");
	 });
Route::get('reports/reactivate/{id}','ReportController@reactivate');

Route::group(['middleware' => ['permission:whitepapers']], function() { 
	Route::resource("whitepapers", "WhitepaperController");
	 });
Route::get('whitepapers/reactivate/{id}','WhitepaperController@reactivate');



/*Event organiser*/
Route::group(['middleware' => ['permission:eventorg']], function() { 
	Route::resource("eventorganisers", "EventOrgController");
	 });
Route::get('eventorganisers/reactivate/{id}','EventOrgController@reactivate');
Route::post('eventorganisers/metatag/{id}','EventOrgController@metatag')->name('eventorg.meta');


Route::group(['middleware' => ['permission:eventorg']], function() { 
	Route::resource("eventorgbrochures", "EventOrgBrochureController");
	 });
Route::get('eventorgbrochures/reactivate/{id}','EventOrgBrochureController@reactivate');
Route::post('eventorgbrochures/metatag/{id}','EventOrgBrochureController@metatag')->name('eventorgbroucher.meta');


Route::group(['middleware' => ['permission:eventorg']], function() { 
	Route::resource("eventorgpressrealese", "EventOrgPressrealeseController");
	 });
Route::get('eventorgpressrealese/reactivate/{id}','EventOrgPressrealeseController@reactivate');
Route::post('eventorgpressrealese/metatag/{id}','EventOrgPressrealeseController@metatag')->name('eventorgpress.meta');


Route::group(['middleware' => ['permission:eventorg']], function() { 
	Route::resource("eventorginterviews", "EventOrgInterviewController");
	 });
Route::get('eventorginterviews/reactivate/{id}','EventOrgInterviewController@reactivate');
Route::post('eventorginterviews/metatag/{id}','EventOrgInterviewController@metatag')->name('eventorginterviews.meta');


Route::group(['middleware' => ['permission:eventorg']], function() { 
	Route::resource("eventorgarticles", "EventOrgArticleController");
	 });
Route::get('eventorgarticles/reactivate/{id}','EventOrgArticleController@reactivate');
Route::post('eventorgarticles/metatag/{id}','EventOrgArticleController@metatag')->name('eventorgarticles.meta');


Route::group(['middleware' => ['permission:eventorg']], function() { 
	Route::resource("eventorggallery", "EventOrgGalleryController");
	 });
Route::get('eventorggallery/reactivate/{id}','EventOrgGalleryController@reactivate');
Route::post('eventorggallery/metatag/{id}','EventOrgGalleryController@metatag')->name('eventorggallery.meta');
/*News / Pressreleases / Reports End*/

/*category*/
Route::post('category/metatag/{id}','CategoryController@metatag');


Route::group(['middleware' => ['permission:seocompany']], function() { 
	Route::resource("seocompanies", "SeoCompanyController");
	 });
Route::get('seocompanies/reactivate/{id}','SeoCompanyController@reactivate');

Route::group(['middleware' => ['permission:seopage']], function() { 
	Route::resource("seopage", "SeopageController");
	 });
Route::post('seopage/metatag/{id}','SeopageController@metatag')->name('seopage.meta');
Route::group(['middleware' => ['permission:seoeventorganizer']], function() { 
	Route::resource("seoeventorg", "SeoEventOrgController");
	 });
Route::group(['middleware' => ['permission:seoevent']], function() { 
	Route::resource("seoevents", "SeoEventController");
	 });

/*Inactive Profile Routes*/
Route::get('inactive','InactiveProfilesController@InactivePages');
Route::get('inactive-company','InactiveProfilesController@InactiveCompanies');
Route::get('inactive-profiles','InactiveProfilesController@InactiveProfiles');
Route::get('inactive-products','InactiveProfilesController@InactiveProducts');
Route::get('inactive-pressrelease','InactiveProfilesController@InactivePressreleases');
Route::get('inactive-catalog','InactiveProfilesController@InactiveCatlogs');
Route::get('inactive-whitepaper','InactiveProfilesController@InactiveWhitepapers');
Route::get('inactive-video','InactiveProfilesController@InactiveVideos');
Route::get('/ajax-cate/{id}','CategoryController@getajaxcat');
Route::get('interview-position','InterviewController@InterviewPositions')->name('interview.position');
Route::post('interview-position-pudate','InterviewController@InterviewPositionsUpdate')->name('position.update');

Route::resource("dataexport", "DataexportController");

Route::post('/exportdata', 'DataexportController@exportdata')->name('exportdata');


Route::post('export-file', 'ExcelController@exportFile')->name('export.file');

Route::group(['middleware' => ['permission:settings']], function() { Route::resource("fileupload","FileuploadController"); });

Route::group(['middleware' => ['permission:fileupload']], function() { 
	Route::resource("fileupload","FileuploadController");


});
//Company bulk upload
Route::group(['middleware' => ['permission:bulkupload']], function() { 	
	Route::get('bulkupload','bulkCompanyController@index');
	Route::post('bulkupload','bulkCompanyController@bulkData');

	Route::get('company-enquiries','EnquiryController@index');
	Route::get('company-enquiries/{company}/show','EnquiryController@show')->name('company.enquiry.show');
	Route::get('company-enquiries/{company}/export','EnquiryController@exportdata')->name('company.exportdata');

	Route::get('company-enquiries/exportall','EnquiryController@exportAllCompanyEnquiries')->name('company.exportalldata');
	
	Route::get('company-reports','EnquiryController@newReports');
	
    Route::get('category-reports','EnquiryController@catReports');

	Route::get('enquiries-mapping','EnquiryController@mapping');
	Route::post('enquiries-mapping/{enquiry}','EnquiryController@postMapping');

	//Admin move data
	Route::get('movedata','MoveDataController@index')->name('movedata');
	Route::get('movedata/{company}','MoveDataController@moveData');

	/* Profile Live */
	Route::get("profilelive","MoveDataController@profileliveview");
	Route::post('moveprofile','MoveDataController@profilelive')->name('moveprofile');
	Route::post('profiletype','MoveDataController@profiletyp')->name('profiletype');

	Route::resource('move-file', 'FilemoveController');

	Route::get('testtolive', 'MovetestController@testToLive');
	Route::post('testtolive', 'MovetestController@testToLive')->name('testtolive');
	Route::get('livetotest', 'MovetestController@liveToTest');
	Route::post('livetotest', 'MovetestController@liveToTest')->name('livetotest');

	/*send enquiries*/
	Route::get('enquiries','EnquiryController@enquiryList');
	Route::get('enquiries-view/{enquiry}','EnquiryController@enquiryShow')->name('enquiry-view');
	Route::post('enquiries-send','EnquiryController@enquirySend')->name('enquiry-send');
	Route::get('enquiries-edit/{enquiry}','EnquiryController@enquiryEdit')->name('enquiry-edit');
	Route::post('enquiries-update','EnquiryController@enquiryUpdate')->name('enquiry-update');
});

/*create Tags*/

Route::resource('/tags', 'TagsController');
Route::resource('/subtags', 'SubTagsController');
/*Route::get("/ajax-category/{id}",'SubTagsController@ajaxcategory');*/
Route::get("/ajax-category/{product_id}",'SubTagsController@ajaxcategory');


/*company history*/
Route::group(['middleware' => ['permission:crm']], function() { 	
Route::get('company-history','CompanyhistoryController@index');
Route::get('company-history/{company}/show','CompanyhistoryController@show')->name('company.history.show');
Route::get('history-view/{history}','CompanyhistoryController@historyShow')->name('history-views');
Route::get('billing-view/{billing}','CompanyhistoryController@billinghistoryShow')->name('billing-views');
Route::get('profilestage/{stage}','CompanyhistoryController@profilestage');
Route::get('profileexpire','CompanyhistoryController@expire');
Route::get('company-history/{status}','CompanyhistoryController@profilestatus');

Route::resource('crmsupport','SupportController');
Route::get('crmsupportit/{company}','SupportController@support');
Route::post('crmreport','SupportController@crmreport')->name('crmreport');
Route::get('getsupportit/{company}','SupportController@getsupport');
});

Route::get('companyinactivelist','InactiveProfilesController@companyInactive');
/*Password Gen*/
Route::get('passwordgen','UserController@passwordgen');
Route::get("/usersinfo","UserController@usertoken")->name('usersinfo');

/* Parsing */
 // Route::resource('newswire','NewswireController');
  Route::get('prnews','XmlpharseController@prnews');
  Route::get('businesswire','XmlpharseController@businesswire');
  Route::get('globalnews','XmlpharseController@globalnews');
  Route::get('indbwwires','XmlpharseController@indbwwires');
  Route::get('prnewsreport','XmlpharseController@prnewsreport');
  Route::get('businessreport','XmlpharseController@businesreport');
  Route::get('globalreport','XmlpharseController@globalreport');

  
/* End Parsing */

/* Client Token */

 Route::get('passwordgen','UserController@passwordgen');
 Route::get("/usersinfo","UserController@usertoken")->name('usersinfo');


Route::group(['middleware' => ['permission:leads']], function() { 	

  Route::get('/promotionleads','DataexportController@promotionLeads');
  Route::get('/product-enquires','DataexportController@productEnquires');
  Route::get('/product-enquires/{id}','DataexportController@productEnquiresView')->name('product-enquires.view');

  Route::get('/leads/{promotion}','DataexportController@promotionleadslist');
  Route::get('/leads/forms/{promotion}','DataexportController@promotionformleadslist');
  Route::get('/leads/forms/get-listed/{promotion}','DataexportController@promotiongetlistleadslist');
  Route::get('/leads/get-listed-new/{promotion}','DataexportController@promotiongetlistleadslistnew');
  
});


Route::get('banenrnotify','BannerNotifyController@index');
Route::get('slidernotify','BannerNotifyController@slider');
Route::get('profilenotify','BannerNotifyController@profile');

 Route::resource('productlaunch','ProductlaunchController');
  Route::get('productlaunch/reactivate/{id}','ProductlaunchController@reactivate');
  /*Google analytics for banners,edm,enewsletters*/

Route::resource("productnewsletter","ProductNewsletter");
 Route::get('/trackbanner', 'GoogletrackreportsController@trackreport')->name('trackbanner');
Route::resource('analyticaltrackreports','GoogletrackreportsController');

Route::get('/trackedm', 'GoogleEdmreportsController@edmTrackreport')->name('edm');
Route::resource('analyticaledmreports','GoogleEdmreportsController');
Route::get("/ajax-edm/{titleid}",'GoogleEdmreportsController@ajaxedm');

Route::get('/trackenewsletter', 'GoogleEnewsletterreportsController@enewsTrackreport')->name('enewsletters');
Route::resource('analyticalenewsreports','GoogleEnewsletterreportsController');
//Route::get("/ajax-edm/{titleid}",'GoogleEnewsletterreportsController@ajaxedm');

//Demo profiles

Route::get('demoproducts/{companyurl}','DemocompanyController@product');

Route::get('demoproducts/{companyurl}/{producturl}','DemocompanyController@productview');
Route::get('demopressrelease/{companyurl}','DemocompanyController@pressrelease');
Route::get('democatalogue/{companyurl}','DemocompanyController@catalogue');
Route::get('demowhitepaper/{companyurl}','DemocompanyController@whitepaper');
Route::get('demovideo/{companyurl}','DemocompanyController@video');
Route::get('demosuppliers/{companyurl}','DemocompanyController@profile')->name('demosuppliers');
Route::get('democompanieslist','DemocompanyController@index');



/*Track link generation*/

Route::get('newlinkviews/{ttid}','TracklinkController@getview')->name('newlinkview');

Route::post('newlink','TracklinkController@Addnewlink')->name('newlinkss');

Route::resource('/tracklinkgen', 'TracklinkController');

// Route::get('/companytracker', 'TracklinkController@companyUrl');
// Route::get('/companytrackerupdate', 'TracklinkController@companyUrlUpdate');


Route::get('/trackreport', 'TracklinkController@trackreport');


//Route::get('/gettitleinfo', 'TracklinkController@gettitleinfo');

Route::get('excel', 'TrackreportExportController@downloadExcel',function(){



});
Route::get('excel/{short_urlid}','TrackreportExportController@reportbyip',function ($short_urlid) {
 
});

Route::get('excelclientip/{short_urlid}','TrackreportExportController@reportbyclientip',function ($short_urlid) {
 
});

Route::get('title/{title_id}','TrackreportExportController@titlereport',function ($title_id) {
 
});


Route::get('excelbytitle/{titleid}','TrackreportExportController@reportbytitle',function ($titleid) {
 
});

Route::get('{short_urlid}','TracklinkController@geturlinfo',function ($short_urlid) {
 
});

Route::get('titlesinfo/{ttid}','TracklinkController@gettitleinfo');

Route::post('sub-regions','GoogletrackreportsController@getSubRegions')->name('get.sub-regions');

Route::post('region-country','GoogletrackreportsController@getRegionCountry')->name('get.region-country');


