<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CollaborationsController;
use App\Http\Controllers\FinancesController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', ProjectsController::class);
    Route::get('/projects/create', [ProjectsController::class, 'create'])->name('projects.create');
    Route::get('/projects/client', [ProjectsController::class, 'clientProjects'])->name('projects.client');
    

    Route::get('/portfolio/index', [PortfolioController::class, 'index'])->name('portfolios.index');
    Route::get('/portfolio/modify', [PortfolioController::class, 'modify'])->name('portfolios.modify');
    Route::post('/portfolio', [PortfolioController::class, 'storeOrUpdate'])->name('portfolios.store');
    Route::get('/portfolio/show', [PortfolioController::class, 'show'])->name('portfolios.show');


    Route::get('/designers', [DashboardController::class, 'showDesigners'])->name('designers.index');
    Route::get('/designers/{id}', [DashboardController::class, 'showDesignerProfile'])->name('designers.profile');
    Route::get('/designers/{designer}', [DashboardController::class, 'showPortfolio'])->name('designers.portfolio');
    Route::get('/profile/{userId}', [ProfileController::class, 'showProfile'])->name('profile.show');


    // Route::get('/conversations', [MessageController::class, 'showConversations'])->name('conversations.index');
    Route::get('/conversations/{recipientId?}', [MessageController::class, 'showConversations'])
    ->name('conversations.index');
    Route::post('/conversations/start/{recipientId}', [MessageController::class, 'startConversation'])->name('conversations.start');

    Route::post('/collaborations', [CollaborationsController::class, 'store'])->name('collaborations.store');

    // Route::post('/conversations/start/{recipientId}', [MessageController::class, 'startConversation'])->name('conversations.start');

    Route::get('/collaboration-requests', [CollaborationsController::class, 'index'])->name('collaborations.index');
    Route::put('/collaborations/{collaboration}', [CollaborationsController::class, 'update'])->name('collaborations.update');

    Route::get('/finances', [FinancesController::class, 'index'])->name('finances.index');

// Show the form to create new financial data
    // Show the form to create new financial data
Route::get('/finances/create', [FinancesController::class, 'create'])->name('finances.create');

// Store new financial data
Route::post('/finances', [FinancesController::class, 'store'])->name('finances.store');

// Show the form to edit existing financial data
Route::get('/finances/{id}/edit', [FinancesController::class, 'edit'])->name('finances.edit');

// Update existing financial data
Route::put('/finances/{id}', [FinancesController::class, 'update'])->name('finances.update');



    Route::get('/designers/{designerId}', [PortfolioController::class, 'showDesignerProfile'])->name('designers.profile');


    

});

Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');

require __DIR__.'/auth.php';


