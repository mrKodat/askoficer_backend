<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['middleware' => 'auth:sanctum'], function () {

Route::apiResource('categories', 'App\Http\Controllers\Api\CategoryController');
Route::get('categories/search/{name}', 'App\Http\Controllers\Api\CategoryController@search');
Route::post('followCategory', 'App\Http\Controllers\Api\CategoryController@followCategory');
Route::get('getFollows/{id}', 'App\Http\Controllers\Api\CategoryController@getFollows');

Route::apiResource('tags', 'App\Http\Controllers\Api\TagController');

Route::apiResource('badges', 'App\Http\Controllers\Api\BadgeController');

Route::apiResource('points', 'App\Http\Controllers\Api\PointController');

Route::post('addQuestion', 'App\Http\Controllers\Api\QuestionController@addQuestion');
Route::post('updateQuestion/{id}', 'App\Http\Controllers\Api\QuestionController@updateQuestion');
Route::get('getQuestion/{id}/{userId}', 'App\Http\Controllers\Api\QuestionController@getQuestion');
Route::post('addQuestionOptions', 'App\Http\Controllers\Api\QuestionController@addQuestionOptions');
Route::post('updateQuestionOptions', 'App\Http\Controllers\Api\QuestionController@updateQuestionOptions');
Route::get('recentQuestions/{userId}/{offset}', 'App\Http\Controllers\Api\QuestionController@recentQuestions');
Route::get('mostAnsweredQuestions/{userId}/{offset}', 'App\Http\Controllers\Api\QuestionController@mostAnsweredQuestions');
Route::get('mostVisitedQuestions/{userId}/{offset}', 'App\Http\Controllers\Api\QuestionController@mostVisitedQuestions');
Route::get('noAnsweredQuestions/{userId}/{offset}', 'App\Http\Controllers\Api\QuestionController@noAnsweredQuestions');
Route::get('mostVotedQuestions/{userId}/{offset}', 'App\Http\Controllers\Api\QuestionController@mostVotedQuestions');
Route::get('getQuestionByCategory/{id}/{userId}/{offset}', 'App\Http\Controllers\Api\QuestionController@getQuestionByCategory');
Route::get('getQuestionByTag/{tag}/{userId}/{offset}', 'App\Http\Controllers\Api\QuestionController@getQuestionByTag');
Route::put('updateQuestionViews/{id}', 'App\Http\Controllers\Api\QuestionController@updateQuestionViews');
Route::get('question/search/{userId}/{title}', 'App\Http\Controllers\Api\QuestionController@search');
Route::get('question/categorysearch/{userId}/{title}', 'App\Http\Controllers\Api\QuestionController@categorysearch');
Route::get('question/tagsearch/{userId}/{title}', 'App\Http\Controllers\Api\QuestionController@tagsearch');
Route::post('voteQuestion', 'App\Http\Controllers\Api\QuestionController@voteQuestion');
Route::post('addToFavorites', 'App\Http\Controllers\Api\QuestionController@addToFavorites');
Route::get('getQuestionVotes/{id}', 'App\Http\Controllers\Api\QuestionController@getQuestionVotes');
Route::get('getUserFavorites/{userId}/{offset}', 'App\Http\Controllers\Api\QuestionController@getUserFavorites');
Route::get('checkIfIsFavorite/{userId}/{questionId}', 'App\Http\Controllers\Api\QuestionController@checkIfIsFavorite');
Route::post('setAsBestAnswer', 'App\Http\Controllers\Api\QuestionController@setAsBestAnswer');
Route::post('submitOption', 'App\Http\Controllers\Api\QuestionController@submitOption');
Route::post('checkIfOptionSelected', 'App\Http\Controllers\Api\QuestionController@checkIfOptionSelected');
Route::post('displayVoteResult', 'App\Http\Controllers\Api\QuestionController@displayVoteResult');
Route::post('removeFeaturedImage/{id}', 'App\Http\Controllers\Api\QuestionController@removeFeaturedImage');
Route::post('deleteQuestion/{id}', 'App\Http\Controllers\Api\QuestionController@deleteQuestion');
Route::post('deleteComment/{id}', 'App\Http\Controllers\Api\CommentController@deleteComment');

Route::apiResource('reports', 'App\Http\Controllers\Api\ReportController');

Route::apiResource('messages', 'App\Http\Controllers\Api\ContactController');

Route::apiResource('comments', 'App\Http\Controllers\Api\CommentController');
Route::post('addComment', 'App\Http\Controllers\Api\CommentController@addComment');
Route::get('getCommentVotes/{id}', 'App\Http\Controllers\Api\CommentController@getCommentVotes');
Route::post('voteComment', 'App\Http\Controllers\Api\CommentController@voteComment');

Route::apiResource('recipes', 'App\Http\Controllers\Api\RecipeController');

Route::apiResource('settings', 'App\Http\Controllers\Api\SettingsController');

Route::apiResource('users', 'App\Http\Controllers\Api\UserController');
Route::post('registerSocialUser', 'App\Http\Controllers\Api\UserController@registerSocialUser');
Route::get('getUserInfo/{id}', 'App\Http\Controllers\Api\UserController@getUserInfo');
Route::get('getUserProfile/{id}', 'App\Http\Controllers\Api\UserController@getUserProfile');
Route::get('users/search/{name}/{id}', 'App\Http\Controllers\Api\UserController@search');
Route::delete('deleteImage/{id}', 'App\Http\Controllers\Api\UserController@deleteImage');
Route::put('changePassword/{id}', 'App\Http\Controllers\Api\UserController@changePassword');
Route::post('addUserFollow/{id}/{followerId}', 'App\Http\Controllers\Api\UserController@addUserFollow');
Route::get('getUserFollowing/{id}', 'App\Http\Controllers\Api\UserController@getUserFollowing');
Route::get('getUserFollowers/{id}', 'App\Http\Controllers\Api\UserController@getUserFollowers');
Route::get('checkIfUserIsFollowing/{id}/{followerId}', 'App\Http\Controllers\Api\UserController@checkIfUserIsFollowing');
Route::post('setDeviceToken', 'App\Http\Controllers\Api\UserController@setDeviceToken');
Route::post('forgotPassword', 'App\Http\Controllers\Api\UserController@forgotPassword');
Route::get('checkAccountStatus/{id}', 'App\Http\Controllers\Api\UserController@checkAccountStatus');
Route::get('getUserQuestions/{id}', 'App\Http\Controllers\Api\UserController@getUserQuestions');
Route::get('getUserPollQuestions/{id}', 'App\Http\Controllers\Api\UserController@getUserPollQuestions');
Route::get('getUserFavQuestions/{id}', 'App\Http\Controllers\Api\UserController@getUserFavQuestions');
Route::get('getUserAskedQuestions/{id}', 'App\Http\Controllers\Api\UserController@getUserAskedQuestions');
Route::get('getUserWaitingQuestions/{id}', 'App\Http\Controllers\Api\UserController@getUserWaitingQuestions');
Route::get('getUserNotifications/{id}', 'App\Http\Controllers\Api\UserController@getUserNotifications');
Route::post('deleteUserNotification/{id}', 'App\Http\Controllers\Api\UserController@deleteUserNotification');
Route::post('deleteAccount/{id}', 'App\Http\Controllers\Api\UserController@deleteAccount');
// });

Route::post("login", 'App\Http\Controllers\Api\UserController@index');

Route::post('addDeviceToken/{token}', 'App\Http\Controllers\Api\UserController@addDeviceToken');

Route::get('/email/verify/{id}/{hash}', 'App\Http\Controllers\Api\VerifyEmailController@__invoke')
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::get('getConversation/{userId}', 'App\Http\Controllers\Api\ConversationController@getConversation');
Route::post('conversations', 'App\Http\Controllers\Api\ConversationController@store');
Route::post('conversations/read', 'App\Http\Controllers\Api\ConversationController@makConversationAsReaded');
Route::post('messages', 'App\Http\Controllers\Api\MessageController@store');
Route::post('deleteConversation', 'App\Http\Controllers\Api\ConversationController@deleteConversation');
