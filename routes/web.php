<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CollaborationsController;
use App\Http\Controllers\FinancesController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ReviewsController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\PDFController;

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
})->name('home');

Route::get('/about', function () {
    return view('about');
});

Route::get('/services', function () {
    return view('services');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/projects/{project}/reviews/create', [ReviewsController::class, 'create'])->name('reviews.create');
    Route::post('/projects/{project}/reviews', [ReviewsController::class, 'store'])->name('reviews.store');

    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', ProjectsController::class);
    Route::get('/projects/create', [ProjectsController::class, 'create'])->name('projects.create');
    Route::get('/projects/client', [ProjectsController::class, 'clientProjects'])->name('projects.client');
    Route::get('/projects/{project}', [CollaborationsController::class, 'show'])->name('projects.show');
    Route::delete('/projects/{project}', [ProjectsController::class, 'destroy'])->name('projects.destroy');
    Route::get('/projects/{project}/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
    // Route::put('/projects/{project}', [ProjectsController::class, 'update'])->name('projects.update');


    Route::get('/portfolio/show/{id}', [PortfolioController::class, 'show'])->name('portfolios.show');
    Route::get('/portfolio/index', [PortfolioController::class, 'index'])->name('portfolios.index');
    Route::get('/portfolio/modify', [PortfolioController::class, 'modify'])->name('portfolios.modify');
    Route::post('/portfolio', [PortfolioController::class, 'storeOrUpdate'])->name('portfolios.store');
    Route::delete('/portfolio/items/{item}', [PortfolioController::class, 'deleteItem'])->name('portfolio.items.delete');

    Route::get('/designers', [DashboardController::class, 'showDesigners'])->name('designers.index');
    Route::get('/designers/{id}', [DashboardController::class, 'showDesignerProfile'])->name('designers.profile');
    Route::get('/designers/{designer}', [DashboardController::class, 'showPortfolio'])->name('designers.portfolio');
    Route::get('/profile/{userId}', [ProfileController::class, 'showProfile'])->name('profile.show');

    Route::post('/conversations/start/{designer}', [ConversationController::class, 'startConversation'])->name('conversations.start');

    Route::get('/chat/{id}', function ($id) {
        // Render the chat view with the given ID
        return view('chat', ['id' => $id]);
    })->name('chat');

    // Route::get('/conversations/{recipientId?}', [MessageController::class, 'showConversations'])->name('conversations.index');
    // Route::post('/conversations/start/{recipientId}', [MessageController::class, 'startConversation'])->name('conversations.start');
    Route::post('/collaborations', [CollaborationsController::class, 'store'])->name('collaborations.store');
    // Route::get('/collaborations/{id}/edit', [CollaborationsController::class, 'edit'])->name('collaborations.edit');
    // Route::put('/collaborations/destroy}', [CollaborationsController::class, 'destroy'])->name('collaborations.destroy');

    Route::get('/collaboration-requests', [CollaborationsController::class, 'index'])->name('collaborations.index');
    Route::put('/collaborations/{collaboration}', [CollaborationsController::class, 'update'])->name('collaborations.update');

    Route::resource('finances', FinancesController::class);
    Route::get('/finances', [FinancesController::class, 'index'])->name('finances.index');
    Route::get('/finances/create', [FinancesController::class, 'create'])->name('finances.create');
    // Route::get('/finances/{projectId}', [FinancesController::class, 'show'])->name('finances.show');
    // Route::get('/finances/{id}/edit', [FinancesController::class, 'edit'])->name('finances.edit');
    // Route::put('/finances/{id}', [FinancesController::class, 'update'])->name('finances.update');
    Route::post('/finances', [FinancesController::class, 'store'])->name('finances.store');
    Route::get('/generate-pdf/{projectId}', [PDFController::class, 'generatePDF'])->name('generate.pdf');

    // Route::delete('/finances/{id}', [FinancesController::class, 'destroy'])->name('finances.destroy');


    Route::get('/appointments', [SchedulesController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [SchedulesController::class, 'store'])->name('schedules.store');
    Route::get('/appointments/{id}', [SchedulesController::class, 'show'])->name('appointments.show');

    
    // Define other routes for reviews

    // Route::get('/designers/{designerId}', [PortfolioController::class, 'showDesignerProfile'])->name('designers.profile');
});

// Admin Login Routes
Route::get('admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

Route::post('admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');

// Protected Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');



    Route::get('/collaborations', [AdminController::class, 'collaborations'])->name('admin.collaborations');
    // In routes/web.php
    Route::delete('/admin/collaborations/{id}', [AdminController::class, 'destroyCollaboration'])->name('admin.collaborations.destroy');



    Route::get('/finances', [AdminController::class, 'finances'])->name('admin.finances');
    Route::delete('/admin/finances/{id}', [AdminController::class, 'destroyFinancialData'])->name('admin.finances.destroy');


    Route::get('/messages', [AdminController::class, 'messages'])->name('admin.messages');
    // Route::delete('/admin/messages/{id}', [AdminController::class, 'destroyFinances'])->name('admin.finances.destroy');

    Route::get('/projects', [AdminController::class, 'projects'])->name('admin.projects');
    Route::delete('/admin/projects/{project]}', [AdminController::class, 'destroyProjects'])->name('admin.projects.destroy');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUsers'])->name('admin.users.destroy');

});

// Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);

require __DIR__.'/auth.php';
