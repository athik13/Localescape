<?php

use App\Accomodations;
use App\accommo_photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Filesystem\Filesystem;
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
    return view('main');
});

//Test Routes (start)
Route::get('/all', 'Api/ApiAccomodationsController@index');
Route::get('/all2', function () {
    $flights = App\Accomodations::all();
    return $flights;
});
Route::get('/{type}/{slug}/photo/{filename}/thumb', function ($type, $slug, $filename) {
    $fileloc = 'app/public/' . $slug . '/' . 'images/' . $filename;
    $path = storage_path($fileloc);

    $failed = "It failed";
    
    if (!File::exists($path)) {
      return $failed;
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $img = Image::cache(function($image) use ($file) {
        $image->make($file)->resize(null, 200, function ($constraint) {
            $constraint->aspectRatio();
        });
    }, 100, false);
    
    $response = Response::make($img, 200);
    $response->header("Content-Type", $type);

    return $response;
});
Route::get('/{type}/{slug}/photo/{filename}', function ($type, $slug, $filename) {
    $fileloc = 'app/public/' . $slug . '/' . 'images/' . $filename;
    $path = storage_path($fileloc);

    $failed = "It failed";
    
    if (!File::exists($path)) {
      return $failed;
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
Route::get('/photo/create', 'PhotopanelController@create');
Route::post('/photo/create/package', 'PhotopanelController@store');
Route::get('/imagetest', function(){
    $img = Image::make('https://i.ytimg.com/vi/yaqe1qesQ8c/maxresdefault.jpg')->resize(300, 200);
    return $img->response('jpg');
});
Route::get('/image/{folder}/{type}/{filename}', function ($folder, $type, $filename) {
    $fileloc = 'app/public/'.$folder.'/'.$type.'/'.$filename;
    $path = storage_path($fileloc);

    $failed = "It failed";
    
    if (!File::exists($path)) {
      return $failed;
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    /*$img = Image::cache(function($image) use ($file) {
        $image->make($file)->resize(null, 1080, function ($constraint) {
            $constraint->aspectRatio();
        });
    }, 100, false); */
    
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
Route::get('/dontdumpthis', function () {
    $stuffs = 'Shower, Bathtub, Free toiletries, Toilet, Hairdryer, Bathroom, Satellite channels, Flat-screen TV, TV, Desk, Sofa, Sitting area, Dining area, Room Service, Packed Lunches, Car Rental, Shuttle Service, Tour Desk, Ticket Service, Baggage Storage, Concierge Service, Laundry, Dry Cleaning, Safe, Non-smoking Rooms, Family Rooms, Elevator, Airport Shuttle, 24-Hour Front Desk, Soundproof Rooms, Heating, Iron';
    $array_items = explode(', ', $stuffs);
    foreach ($array_items as $name) {
        $flight = new \App\facilities;
        $flight->name = $name;
        $flight->save();
        echo 'Done';
    }
    echo 'Fully DOne';
});
Route::get('/newExtranet/login', function () {
    return view('extranet.auth.newLogin');
});
//Test Routes (end)

//Gallery (start)
Route::get('/gallery', function () {
    $gallery_images = \App\Gallery::all();
    return view('gallery.index', compact('gallery_images'));
});
//Gallery (end)

// Accommodation Routes (start)
Route::get('/hotels', 'AccomodationsController@hotel');
Route::get('/hotels/{slug}', 'AccomodationsController@hotel_detail');
Route::get('/resorts', 'AccomodationsController@resort');
Route::get('/resorts/{slug}', 'AccomodationsController@resort_detail');
Route::get('/guest-house', 'AccomodationsController@guesthouse');
Route::get('/guest-house/{slug}', 'AccomodationsController@guesthouse_detail');
//Bookings and Inquiry
Route::get('/booking/{acco_id}/{room_id}', 'BookingController@create');
Route::post('/booking/{acco_id}/{room_id}', 'BookingController@store');
Route::get('/inquery/{acco_id}/{room_id}', 'InqueryController@create');
Route::post('/inquery/{acco_id}/{room_id}', 'InqueryController@store');
// Accommodation Routes (end)

//Tour, Diving and Photo Package (start)
Route::get('/tours', function() {
    $type = 'Tours';
    $tours = \App\tour::all();
    return view('tours.all', compact('type', 'tours'));
});
Route::get('/diving-package', function() {
    $type = 'Diving Pacakages';
    $dives = \App\dive::all();
    return view('dive.all', compact('type', 'dives'));
});
Route::get('/photo-package', function() {
    $type = 'Photo Pacakages';
    $photos = \App\photopanel::all();
    return view('photo.all', compact('type', 'photos'));
});
//Tour, Diving and Photo Package (end)

//Blog (start)
Route::get('/blog', function () {
    $blogs = \App\blog::all();
    return view('blog.all', compact('blogs'));
});
//Blog (end)

//Auth Routes (start)
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'extranet'], function () {
    Route::get('/login', 'ExtranetAuth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'ExtranetAuth\LoginController@login');
    Route::post('/logout', 'ExtranetAuth\LoginController@logout')->name('logout');

    Route::get('/register', 'ExtranetAuth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'ExtranetAuth\RegisterController@register');

    Route::post('/password/email', 'ExtranetAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'ExtranetAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'ExtranetAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'ExtranetAuth\ResetPasswordController@showResetForm');
});
Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::get('/logout', 'AdminAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});
Route::group(['prefix' => 'divepackage'], function () {
    Route::get('/login', 'DivepackageAuth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'DivepackageAuth\LoginController@login');
    Route::post('/logout', 'DivepackageAuth\LoginController@logout')->name('logout');

    Route::get('/register', 'DivepackageAuth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'DivepackageAuth\RegisterController@register');

    Route::post('/password/email', 'DivepackageAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'DivepackageAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'DivepackageAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'DivepackageAuth\ResetPasswordController@showResetForm');
});
Route::group(['prefix' => 'photopackage'], function () {
    Route::get('/login', 'PhotopackageAuth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'PhotopackageAuth\LoginController@login');
    Route::post('/logout', 'PhotopackageAuth\LoginController@logout')->name('logout');

    Route::get('/register', 'PhotopackageAuth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'PhotopackageAuth\RegisterController@register');

    Route::post('/password/email', 'PhotopackageAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'PhotopackageAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'PhotopackageAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'PhotopackageAuth\ResetPasswordController@showResetForm');
});
//Auth Routes (end)