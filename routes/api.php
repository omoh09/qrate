<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Api" middleware group. Enjoy building your API!
|
*/

//Route::post('cryptopay', 'Api\CryptoController@allAdress');

//Test mail service
Route::post('/sendmail',[RegisterController::class, 'subscribe']);
Route::get('/',[RegisterController::class, 'test']);

//payment
Route::get('/pay','Api\PaymentController@pay');
Route::get('exhibitions/pay','Api\ExhibitionController@pay'); //get single exhibition
Route::get('callback/','Api\PaymentController@callback')->name('payment.callback');
Route::get('/rave/callback/','Api\PaymentController@callback')->name('rave.callback');
Route::get('callback/exhibition/{checkout}','Api\ExhibitionController@paymentCallback')->name('payment.exhibition.callback');
Route::get('/rave/callback/exhibition/{checkout}','Api\ExhibitionController@paymentCallback');
Route::post('/payment/webhook','Api\PaymentController@webhook')->name('payment.webhook');
//-- New Route --//
Route::group(['middleware' => ['cors', 'json.response']], function () {
    // Public Routes
    Route::post('/login','Auth\LoginController@login')->name('login.api');
    Route::post('/admin/login','Admin\Auth\LoginController@login');
    Route::post('/admin/register','Admin\Auth\RegisterController@register');
    Route::post('/register','Auth\RegisterController@register')->name('register.api');
    Route::post('/password/reset','Auth\ResetPasswordController@reset')->name('password.reset');
    Route::post('/password/email','Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('/verify/email/{id}','Auth\VerificationController@verify2')->name('verification.verify');
    Route::post('/verify/email/re-send', 'Auth\VerificationController@resend2')->name('verification.resend');
});

//,'verified' TODO add this back to middleware
Route::middleware(['auth:api','cors' ,'json.response','scope:customer','verified','user.active'] )->group(function () {

    // our routes to be protected will go in here
    //payment

    //2fa
    Route::post('2fa/on','Api\TwoFactorAuthController@on');
    Route::post('2fa/off','Api\TwoFactorAuthController@off');

    Route::get('/user', function (Request $request) {
        return UserResource::make($request->user());
    });
    Route::post('/user/categories','Api\CategoriesController@addUserCategory');

    //Profile
    Route::get('profile','Api\ProfileController@index');
    Route::post('profile/edit','Api\ProfileController@update');

    //User notification settings
    Route::get('notification-settings','Api\NotificationController@getNotificationSettings');
    Route::post('notification-settings','Api\NotificationController@updateSettings');
    //Artists pages
    Route::get('artists','Api\ArtistController@index');
    Route::get('artists/{id}','Api\ArtistController@show');
    Route::post('artists/search','Api\ArtistController@search');

    //ArtGalleries
    Route::get('art-galleries' ,'Api\ArtGalleryController@index');
    Route::get('art-galleries/{id}' ,'Api\ArtGalleryController@show');
    Route::post('art-galleries/search' ,'Api\ArtGalleryController@search');

    // art gallery photo
    Route::apiResource('art-gallery/photos','Api\PhotosController')->except(['show','update'])->middleware('art.gallery');


    // Art Gallery Artist
    Route::post('art-gallery/artists','Api\ArtGalleryController@addArtistToGallery');
    Route::post('art-gallery/artists/delete','Api\ArtGalleryController@removeArtistFromGallery');

    //Art Gallery Collections
    Route::group(['prefix' => 'art-gallery'] , function () {
        Route::get('collections/{collection}', 'Api\CollectionController@show');
        Route::apiResource('collections', 'Api\CollectionController')->except(['show'])->middleware('art.gallery');
        Route::post('collections/{collection}/artworks', 'Api\CollectionController@addToCollection')->middleware('art.gallery');
        Route::delete('collections/{collection}/artworks', 'Api\CollectionController@removeFromCollection')->middleware('art.gallery');
    });

    //ArtSupplies
    Route::get('art-supplies','Api\ArtSupplyController@index');
    Route::get('art-supplies/{art_supply}','Api\ArtSupplyController@show');
    Route::post('art-supplies/{art_supply}/cart','Api\ArtSupplyController@addtoCart');
    Route::Post('art-supplies/category','Api\ArtSupplyController@categoryFilter');
    Route::apiResource('art-supplies','Api\ArtSupplyController')->except(['index','show'])->middleware('art.supplier');

    //PAYMENT

//    Route::apiResource('art-supplies','Api\PaymentController')->middleware('art.supplier');



    // Addresses for Delivery

    Route::get('delivery-address','Api\DeliveryAddressController@index');
    Route::get('delivery-address/{id}','Api\DeliveryAddressController@show');
    Route::delete('delivery-address/{id}','Api\DeliveryAddressController@destroy');
    //artist
    Route::get('artists','Api\ArtistController@index'); //get all artist
    Route::get('artists/{artist}','Api\ArtistController@show'); //get one artist
    Route::post('artists/search','Api\ArtistController@search'); // search for an artist
    Route::get('artists/{artist}/artworks' , 'Api\ArtworksController@artistArtworks'); //get all artworks by a artist

    //artist artworks  routes for artist to make view and edit there artworks
    // TODO change edit path from patch to post
    Route::apiResource('artist/artworks','Api\ArtistArtworksController')->middleware('role.auth')->except(['update']);
    Route::post('artist/artworks/{artwork}/update','Api\ArtistArtworksController@update')->middleware('role.auth');
    //Explore - preferred categories
    Route::get('explore' , 'Api\ExploreController@index'); //user preferred category
//    Route::get('explore/single/{id}' , 'Api\ExploreController@singleCategory'); //each preferred category
    Route::get('trending' , 'Api\ExploreController@trend'); //artwork trending

    //Artwork Categories

    Route::get('categories/art', function (){
       return \App\Helpers\Helper::response('success','art catgories', 200, \App\Categories::all());
    });
     Route::get('categories/art-supply', function (){
           return \App\Helpers\Helper::response('success','art catgories', 200, \App\SuppliesCategory::all());
        });


    //Categories Page
    Route::get('category' , 'Api\CategoriesController@index'); //get all categories
    Route::get('category/single/{category}' , 'Api\CategoriesController@singleCategory'); //get single category

    //Exhibition
    Route::post('exhibitions','Api\ArtGalleryController@createExhibition')->middleware('art.gallery');
    Route::post('exhibitions/{id}/edit','Api\ArtGalleryController@editExhibition')->middleware('art.gallery');
    Route::get('exhibitions','Api\ExhibitionController@index'); //get all exhibition
    Route::get('exhibitions/all','Api\ExhibitionController@all'); //get all exhibition
    Route::get('exhibitions/ongoing','Api\ExhibitionController@ongoing'); //get all exhibition
    Route::get('exhibitions/upcoming','Api\ExhibitionController@upcoming'); //get all exhibition
    Route::get('exhibitions/past','Api\ExhibitionController@past'); //get all exhibition
    Route::get('exhibitions/{id}','Api\ExhibitionController@show'); //get single exhibition
    Route::post('exhibitions/{id}/register','Api\ExhibitionController@register'); //get single exhibition
    Route::post('exhibitions/{id}/toggle-like','Api\ExhibitionController@togglelike'); //get single exhibition

     //Auction
     Route::get('auction','Api\AuctionController@index'); //get all auctions
     Route::get('auction/live','Api\AuctionController@live'); //get all live auctions
     Route::get('auction/upcoming','Api\AuctionController@upcoming'); //get all upcoming auctions
     Route::get('auction/past','Api\AuctionController@past_auction'); //get a past auctions
     Route::get('auction/{id}','Api\AuctionController@show'); //get one auction
     Route::post('auction/{id}/bid','Api\AuctionController@bid'); // bid for an auction
     Route::post('auction/search','Api\ArtistController@search'); // search for an auction

    //Artworks
    Route::get('artworks', 'Api\ArtworksController@index'); //get all artist artworks
    Route::get('artworks/{artwork}','Api\ArtworksController@show'); //get a single artwork
    Route::post('artworks/{artwork}/toggle-like','Api\ArtworksController@toggleLike');
    Route::post('artworks/{artwork}/comment','Api\ArtworksController@comment');
    Route::post('artworks/{id}/cart','Api\ArtworksController@addToCart');


    //notification
    Route::get('notifications','Api\NotificationController@index');
    Route::get('notifications/count','Api\NotificationController@counts');
    //catalogue

    Route::apiResource('catalogue','Api\CatalogueController');
    Route::Post('catalogue/{folder}/artwork/{artwork}','Api\CatalogueController@addToFolder');
    Route::delete('catalogue/{folder}/artwork/{artwork}','Api\CatalogueController@removeFromFolder');

    //cart
    Route::apiResource('cart','Api\CartController')->except(['store']);

    //timeline
    Route::get('timeline' , 'Api\TimelineController@timeline' );
    Route::get('top-picks' , 'Api\TimelineController@topPicks' );
    //Post Routes
    Route::apiResource('user/posts','Api\PostController')->except(['update','show']);
    Route::post('posts/{post}/edit','Api\PostController@update');
    Route::get('posts/{post}','Api\PostController@show');
    Route::delete('posts/{post}','Api\PostController@destroy');
    Route::post('posts/{post}/toggle-like','Api\PostController@toggleLike');
    Route::post('posts/{post}/comment','Api\PostController@comment');

    /// routes for follow feature
    Route::post('/follow-toggle/{id}','Api\FollowingController@toggleFollow');
    Route::group(['prefix' =>'/following'],function(){
        Route::get('/','Api\FollowingController@following');
        Route::get('/{id}','Api\FollowingController@showFollowing');
    });
    Route::group(['prefix' =>'/followers', 'middleware' => 'role.auth'],function(){
        Route::get('/','Api\FollowingController@followers');
        Route::get('/{id}','Api\FollowingController@showFollower');
    });
    Route::post('/logout' , 'Auth\LoginController@logout');

    //deleting any file
    Route::delete('/file/{file}','Api\FileController@destroy');
    // Search

    //checkout
    Route::apiResource('checkouts','Api\CheckoutsController')->except(['destroy']);

    Route::get('/search','Api\SearchController@index');
});


Route::group(['middleware'=> ['auth:api','scope:admin'],'prefix' => 'admin'], function (){
    Route::get('user', function (){
        return \request()->user();
    });
    Route::get('dashboard','Api\AdminController@index');
    Route::get('/users','Api\AdminController@users');
    Route::get('/qraters','Api\AdminController@qraters');
    Route::get('/artists','Api\AdminController@artists');
    Route::get('/art-galleries','Api\AdminController@artGallery');
    Route::get('/art-suppliers','Api\AdminController@artSuppliers');
    Route::post('/logout' , 'Auth\LoginController@logout');
    Route::post('/deactivate/user/{user}','Api\AdminController@deactivateUser');
    Route::post('/activate/user/{user}','Api\AdminController@activateUser');

    Route::post('/artworks/create' ,'Api\AdminController@createArtwork');
    
    //TO DO failed Transaction 
    Route::get('/checkouts/all' ,'Api\AdminController@checkouts');
    Route::get('/checkouts/completed' ,'Api\AdminController@paidCheckouts');
    Route::get('/checkouts/pending' ,'Api\AdminController@pendingCheckouts');
    Route::get('/checkouts/{id}' ,'Api\AdminController@singleCheckout');

    //Artwork suggestion for Auction
    Route::get('/auctions/suggest' ,'Api\AdminController@suggestAuction');
    Route::post('/auctions/create/{artworkId}', 'Api\AdminController@createAuction');
    Route::get('/auctions/all','Api\AdminController@allAuction');
    Route::get('/auctions/requests','Api\AdminController@auctionRequest');
    Route::get('/auctionApproved/{id}','Api\AdminController@auctionApproved');
    Route::get('/auctions/live','Api\AdminController@auctionLive');
    Route::get('/auctions/upcoming','Api\AdminController@auctionUpcoming');
    Route::get('/auctions/past','Api\AdminController@auctionPast');
    Route::get('/auctionDestroy/{auctionId}','Api\AdminController@auctionDestroy');
    Route::get('/endAuction','Api\AdminController@endAuction');

    Route::post('/exhibitions/create','Api\AdminController@createExhibition');
    Route::get('/exhibitions/request','Api\AdminController@exhibitionRequest'); //get all exhibition
    Route::get('/exhibitions/ongoing','Api\AdminController@exhibitionOngoing'); //get live exhibition
    Route::get('/exhibitions/upcoming','Api\AdminController@exhibitionUpcoming'); //get upcoming exhibition
    Route::get('/exhibitions/past','Api\AdminController@exhibitionPast'); //get past exhibition
    Route::get('/exhibitions/{id}','Api\AdminController@showExhibition'); //get single exhibition by id

    //Advert
    Route::get('/advert','Api\AdminController@showAdverts');
    Route::get('/advert/{advert}','Api\AdminController@showSingleAdvert');
    Route::post('/advert/create','Api\AdminController@createAdvert');
});

