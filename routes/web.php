<?php

use Illuminate\Http\instance;
use App\Mail\MailtrapExample;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewUserNotification;


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

Route::get('/', 'HomeController@index');

Auth::routes();

//Le route interagiscono con il middleware auth
Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'ProfileController@profile')->name('profile');
    Route::post('profile/imageupload', 'ProfileController@CropperUpload');
    Route::delete('profile/destroyImage/{id}', 'ProfileController@destroyImage')->name('profile.destroyImage');
    Route::delete('profile/deleteProfile/{id}', 'ProfileController@deleteProfile')->name('profile.deleteProfile');
    Route::put('profile/updateProfile', 'ProfileController@updateProfile')->name('profile.update');
    Route::get('/calendar', 'HomeController@calendar')->name('calendar');
    Route::get('/emails', 'EmailController@index')->name('emails');
    Route::get('/agencies', 'Agency@index')->name('agencies');
    Route::resource('debts', 'DebtController');
    Route::resource('users', 'UserController');
    Route::resource('leads', 'LeadController');
    Route::get('/archived_leads', 'LeadController@index_archived')->name('archived_leads');
    Route::get('/clients', 'LeadController@index_clients')->name('clients');
    Route::resource('instances', 'InstanceController');
    Route::get('/instances/create/{id?}', 'InstanceController@create');
    Route::resource('practices', 'PracticeController');
    Route::get('/practices/create/{id?}', 'PracticeController@create');
    Route::get('/modules/create', 'ModuleController@create')->name('create_module');
    Route::get('/modules/download', 'ModuleController@download')->name('download_module');
    Route::resource('products', 'ProductController');
    Route::resource('notes', 'NoteController');
    Route::resource('commitments', 'CommitmentController');
    Route::resource('annotations', 'AnnotationController');
    Route::resource('dealers', 'DealerController');
    Route::resource('companies', 'CompanyController');
    Route::resource('agents', 'AgentController');
    Route::resource('prenotations', 'PrenotationController');
    Route::resource('spots', 'SpotController');
    Route::resource('assignments', 'AssignmentController');
    Route::resource('messages', 'MessageController');
    Route::post('file-upload', 'FileController@fileUpload')->name('file.upload');
    Route::post('file-download', 'FileController@fileDownload')->name('file.download');


});
