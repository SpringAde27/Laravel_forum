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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [
    'as' => 'root',
    'uses' => 'WelcomeController@index',
]);

Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();


/* 언어 선택 */
Route::get('locale', [
  'as' => 'locale',
  'uses' => 'WelcomeController@locale',
]);


/* Article RESTful Resource Controller */
Route::resource('articles','ArticlesController');

Route::get('tags/{slug}/articles', [
  'as' => 'tags.articles.index',
  'uses' => 'ArticlesController@index'
]);


/* 첨부 파일 */
Route::resource('attachments', 'AttachmentsController', ['only' => ['store', 'destroy']]);
Route::get('attachments/{file}', 'AttachmentsController@show');


/* 댓글 */
Route::resource('comments', 'CommentsController', ['only' => ['update', 'destroy']]);
Route::resource('articles.comments', 'CommentsController', ['only' => 'store']);


/* 투표 */
Route::post('comments/{comment}/votes', [
  'as' => 'comments.vote',
  'uses' => 'CommentsController@vote',
]);


/* 사용자 등록 */
Route::get('auth/register', [
  'as' => 'users.create',
  'uses' => 'UsersController@create',
]);

Route::post('auth/register', [
  'as' => 'users.store',
  'uses' => 'UsersController@store',
]);

Route::get('auth/confirm/{code}', [
  'as' => 'users.confirm',
  'uses' => 'UsersController@confirm',
])->where('code', '[0-9a-zA-Z]{60}');


/* 사용자 인증 */
Route::get('auth/login', [
  'as' => 'sessions.create',
  'uses' => 'SessionsController@create',
]);

Route::post('auth/login', [
  'as' => 'sessions.store',
  'uses' => 'SessionsController@store',
]);

Route::get('auth/logout', [
  'as' => 'sessions.destroy',
  'uses' => 'SessionsController@destroy',
]);


/* 비밀번호 초기화 */
Route::get('auth/remind', [
  'as' => 'remind.create',
  'uses' => 'PasswordsController@getRemind',
]);

Route::post('auth/remind', [
  'as' => 'remind.store',
  'uses' => 'PasswordsController@postRemind',
]);

Route::get('auth/reset/{token}', [
  'as' => 'reset.create',
  'uses' => 'PasswordsController@getReset',
]);

Route::post('auth/reset', [
  'as' => 'reset.store',
  'uses' => 'PasswordsController@postReset',
]);


/* 소셜 로그인 */
Route::get('social/{provider}', [
  'as' => 'social.login',
  'uses' => 'SocialController@execute',
]);