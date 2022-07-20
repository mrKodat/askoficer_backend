<?php

use App\Models\Category;
use App\Models\Tag;
use App\Models\Status;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
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
});

Route::get('/verified', function () {
  return view('verified');
});


Auth::routes();

// Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth', 'admin']], function () {

  Route::get('/', 'App\Http\Controllers\HomeController@index')->name('dashboard');

  Route::get('/dashboard', 'App\Http\Controllers\HomeController@index')->name('dashboard');

  Route::get('/user-add', function () {
    return view('users.user-add');
  })->name('upgrade');

  Route::get('/category-add', function () {
    return view('categories.category-add');
  })->name('upgrade');

  Route::get('/checkout-add', function () {
    return view('checkouts.checkout-add');
  })->name('checkout');

  Route::get('/tag-add', function () {
    return view('tags.tag-add');
  })->name('tag');

  Route::get('/badge-add', function () {
    return view('badges.badge-add');
  })->name('badge');

  Route::get('/point-add', function () {
    return view('points.point-add');
  })->name('point');

  Route::get('/notification-add', function () {
    return view('notifications.notification-add');
  })->name('notification');

  Route::get('/question-add', function () {
    $tags = Tag::all();
    $categories = Category::all();
    return view('questions.question-add', ['tags' => $tags, 'categories' => $categories]);
  })->name('questions');

  Route::resource('users', 'App\Http\Controllers\UserController', ['except' => ['show']]);
  Route::get('/user-edit/{id}', 'App\Http\Controllers\UserController@useredit');
  Route::get('/user-delete/{id}', 'App\Http\Controllers\UserController@userdelete');
  Route::put('/user-update/{id}', 'App\Http\Controllers\UserController@userupdate');
  Route::put('/user-add', 'App\Http\Controllers\UserController@useradd');

  Route::resource('categories', 'App\Http\Controllers\CategoryController', ['except' => ['show']]);
  Route::get('/category-edit/{id}', 'App\Http\Controllers\CategoryController@categoryedit');
  Route::get('/category-delete/{id}', 'App\Http\Controllers\CategoryController@categorydelete');
  Route::put('/category-update/{id}', 'App\Http\Controllers\CategoryController@categoryupdate');
  Route::put('/category-add', 'App\Http\Controllers\CategoryController@categoryadd');

  Route::resource('tags', 'App\Http\Controllers\TagController', ['except' => ['show']]);
  Route::get('/tag-edit/{id}', 'App\Http\Controllers\TagController@tagedit');
  Route::get('/tag-delete/{id}', 'App\Http\Controllers\TagController@tagdelete');
  Route::put('/tag-update/{id}', 'App\Http\Controllers\TagController@tagupdate');
  Route::put('/tag-add', 'App\Http\Controllers\TagController@tagadd');

  Route::resource('badges', 'App\Http\Controllers\BadgeController', ['except' => ['show']]);
  Route::get('/badge-edit/{id}', 'App\Http\Controllers\BadgeController@badgeedit');
  Route::get('/badge-delete/{id}', 'App\Http\Controllers\BadgeController@badgedelete');
  Route::put('/badge-update/{id}', 'App\Http\Controllers\BadgeController@badgeupdate');
  Route::put('/badge-add', 'App\Http\Controllers\BadgeController@badgeadd');

  Route::resource('points', 'App\Http\Controllers\PointController', ['except' => ['show']]);
  Route::get('/point-edit/{id}', 'App\Http\Controllers\PointController@pointedit');
  Route::get('/point-delete/{id}', 'App\Http\Controllers\PointController@pointdelete');
  Route::put('/point-update/{id}', 'App\Http\Controllers\PointController@pointupdate');
  Route::put('/point-add', 'App\Http\Controllers\PointController@pointadd');

  Route::resource('messages', 'App\Http\Controllers\ContactController', ['except' => ['show']]);
  Route::get('/message-delete/{id}', 'App\Http\Controllers\ContactController@messagedelete');

  Route::resource('questions', 'App\Http\Controllers\QuestionController', ['except' => ['show']]);
  Route::get('/question-edit/{id}', 'App\Http\Controllers\QuestionController@questionedit');
  Route::get('/question-delete/{id}', 'App\Http\Controllers\QuestionController@questiondelete');
  Route::put('/question-update/{id}', 'App\Http\Controllers\QuestionController@questionupdate');
  Route::put('/question-add', 'App\Http\Controllers\QuestionController@questionadd');

  Route::resource('statuses', 'App\Http\Controllers\StatusController', ['except' => ['show']]);
  Route::get('/status-edit/{id}', 'App\Http\Controllers\StatusController@statusedit');
  Route::get('/status-delete/{id}', 'App\Http\Controllers\StatusController@statusdelete');
  Route::put('/status-update/{id}', 'App\Http\Controllers\StatusController@statusupdate');
  Route::put('/status-add', 'App\Http\Controllers\StatusController@statusadd');

  Route::resource('notifications', 'App\Http\Controllers\NotificationController', ['except' => ['show']]);
  Route::get('/notification-edit/{id}', 'App\Http\Controllers\NotificationController@notificationedit');
  Route::get('/notification-delete/{id}', 'App\Http\Controllers\NotificationController@notificationdelete');
  Route::put('/notification-update/{id}', 'App\Http\Controllers\NotificationController@notificationupdate');
  Route::put('/notification-add', 'App\Http\Controllers\NotificationController@notificationadd');
  Route::post('/bulksend/{id}', 'App\Http\Controllers\NotificationController@bulksend')->name('bulksend');

  Route::get('/app-info', 'App\Http\Controllers\SettingsController@appinfo');
  Route::get('/web-info', 'App\Http\Controllers\SettingsController@webinfo');
  Route::get('/push-notifications', 'App\Http\Controllers\SettingsController@pushnotifications');
  Route::put('/app-info-save', 'App\Http\Controllers\SettingsController@saveappinfo');
  Route::put('/web-info-save', 'App\Http\Controllers\SettingsController@savewebinfo');
  Route::put('/push-notifications-info-save', 'App\Http\Controllers\SettingsController@savepushnotifications');

  Route::get('/all-reports', 'App\Http\Controllers\ReportController@allreports');
  Route::get('/answer-reports', 'App\Http\Controllers\ReportController@answerreports');
  Route::get('/question-reports', 'App\Http\Controllers\ReportController@questionreports');
  Route::get('/report-delete/{id}', 'App\Http\Controllers\ReportController@reportdelete');

  Route::get('/comments', 'App\Http\Controllers\CommentController@allcomments');
  Route::get('/answers', 'App\Http\Controllers\CommentController@answers');
  Route::get('/replies', 'App\Http\Controllers\CommentController@replies');

  Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
  Route::put('profile-update', 'App\Http\Controllers\ProfileController@updateProfile');
  Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

  Route::get('notification/update/', 'App\Http\Controllers\PanelNotificationController@changeNotificationState');
});
