<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;
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

Route::get('/', WelcomeController::class)->name('home');

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::controller(ContactController::class)->group(function () {
        Route::get('/contacts', 'index')->name('contacts.index');
        Route::post('/contacts', 'store')->name('contacts.store');
        Route::get('/contacts/create', 'create')->name('contacts.create');
        Route::get('/contacts/{id}', 'show')->name('contacts.show')->whereNumber('id');
        Route::get('/contacts/{id}/edit', 'edit')->name('contacts.edit');
        Route::put('/contacts/{id}', 'update')->name('contacts.update');
        Route::delete('/contacts/{id}', 'destroy')->name('contacts.destroy');
    });
    Route::resource('/companies', CompanyController::class);
    Route::resources([
        '/tags' => TagController::class,
        '/tasks' => TaskController::class
    ]);
    Route::resource('/activities', ActivityController::class)->except([
        'index', 'show'
    ]);
//    Route::resource('activities', ActivityController::class)->names([
//       'index' => 'activities.all',
//       'show' => 'activities.view'
//    ]);
//    Route::resource('/contacts.notes', ContactNoteController::class)->shallow();
});



Route::get('/companies/{name?}', function ($name = null) {
    if ($name) {
        return "Company " . $name;
    } else {
        return "All companies";
    }
})->whereAlphaNumeric('name');

Route::fallback(function() {
   return "<h1>Sorry, the page does not exist</h1>";
});
