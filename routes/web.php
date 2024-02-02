<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [QuestionnaireController::class, 'index'])->name('index');
Route::get('/questionnaires/create', [QuestionnaireController::class, 'create'])->middleware(['auth', 'verified'])->name('questionnaires.create');
//Route::get('/questionnaires/{id}', [QuestionnaireController::class, 'show'])->name('questionnaires.show');
Route::get('/questionnaires/{questionnaireId}', [QuestionnaireController::class, 'show'])->where('id', '[0-9]+')->name('questionnaires.show');
Route::post('/questionnaires/{questionnaireId}', [VoteController::class, 'vote'])->middleware('ajax.auth')->where('questionnaireId', '[0-9]+')->name('questionnaires.vote');
Route::post('/questionnaires', [QuestionnaireController::class, 'store'])->middleware(['auth', 'verified'])->name('questionnaires.store');





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
