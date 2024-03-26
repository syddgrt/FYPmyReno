<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;

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
    Route::get('/designers/{designer}', [DashboardController::class, 'showPortfolio'])->name('designers.portfolio');



    



});

Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');

require __DIR__.'/auth.php';


