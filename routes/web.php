<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReizenOverzichtController;
use App\Http\Controllers\DepartureController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


Route::get('/', function () {
    $departureController = new \App\Http\Controllers\DepartureController();
    $departures = $departureController->getDepartures();
    $destinations = $departureController->getDestinations();
    return view('welcome', compact('departures', 'destinations'));
})->name('welcome');

Route::get('/destinations', function () {
    return view('destinations');
})->name('destinations');

Route::get('/packages', function () {
    return view('packages');
})->name('packages');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function () {
    // Handle form submission
    return redirect()->route('contact')->with('success', 'Your message has been sent!');
})->name('contact.submit');

Route::get('/chat', [ChatbotController::class, 'showChatForm'])->name('chat');
Route::post('/huggingface/generate', [ChatbotController::class, 'generate'])->name('huggingface.generate');

Route::get('/dashboard', function () {
    $bookingController = new \App\Http\Controllers\BookingController();
    $bookingStats = $bookingController->getBookingStats();
    return view('dashboard', compact('bookingStats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/underdevelopment', function () {
    return view('underdevelopment');
})->name('underdevelopment');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // accounts
    Route::resource('account', AccountController::class);
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/account/create', [AccountController::class, 'create'])->name('account.create');
    Route::get('/account/{customer}', [AccountController::class, 'show'])->name('account.show');
    Route::post('/account', [AccountController::class, 'store'])->name('account.store');
    Route::get('/account/{id}/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/account/{id}', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/{customer}', [AccountController::class, 'destroy'])->name('account.destroy');

    // customers
    Route::resource('customers', CustomerController::class);
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::get('/customers/{customers}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customers}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::delete('/customers/{customers}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // invoices
    Route::resource('invoice', InvoiceController::class);
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::get('/invoice/{invoice}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/invoice/{id}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('/invoice/{id}', [InvoiceController::class, 'update'])->name('invoice.update');
    Route::delete('/invoice/{invoice}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::get('/invoice/latest-number', [InvoiceController::class, 'latestNumber'])->name('invoice.latestNumber');

    // Departures
    Route::get('/departures', [DepartureController::class, 'index'])->name('departure.index');

    // Bookings
    Route::resource('bookings', BookingController::class);

    // Messages
    Route::resource('messages', MessageController::class)->only(['index', 'create', 'store', 'update', 'destroy']);

// Delete conversation (should already exist)
Route::delete('/messages/{conversation}', [MessageController::class, 'destroy'])
    ->name('messages.destroy');

// Delete last message - NEW ROUTE DEFINITION
Route::delete('/messages/{conversation}/last-message', [MessageController::class, 'deleteLastMessage'])
    ->name('messages.deleteLastMessage');

    // Custom routes
    Route::post('/conversations/{conversation}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::put('/messages/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');
    Route::post('/conversations', [MessageController::class, 'createConversation'])->name('messages.createConversation');
    Route::delete('/conversations/{conversation}/last-message', [MessageController::class, 'deleteLastMessage'])->name('messages.deleteLastMessage');

    // ReisOverzicht 
    Route::get('/reisoverzicht', [ReizenOverzichtController::class, 'index'])->name('reisoverzicht.index');
    Route::get('/reisoverzicht/create', [ReizenOverzichtController::class, 'create'])->name('reisoverzicht.create');
    Route::post('/reisoverzicht', [ReizenOverzichtController::class, 'store'])->name('reisoverzicht.store');
    Route::get('/reisoverzicht/{id}', [ReizenOverzichtController::class, 'show'])->name('reisoverzicht.show');
    Route::get('/reisoverzicht/{id}/edit', [ReizenOverzichtController::class, 'edit'])->name('reisoverzicht.edit');
    Route::put('/reisoverzicht/{id}', [ReizenOverzichtController::class, 'update'])->name('reisoverzicht.update');
    Route::delete('/reisoverzicht/{id}', [ReizenOverzichtController::class, 'destroy'])->name('reisoverzicht.destroy');
});

require __DIR__ . '/auth.php';
