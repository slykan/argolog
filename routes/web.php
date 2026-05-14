<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/politika-privatnosti', function () {
    return view('privacy');
})->name('privacy');

Route::get('/o-nama', function () {
    return view('about');
})->name('about');

Route::get('/kontakt', function () {
    return view('contact');
})->name('contact');

Route::get('/upute', function () {
    return view('docs');
})->name('docs');

Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => route('home'),    'priority' => '1.0', 'changefreq' => 'weekly'],
        ['loc' => route('about'),   'priority' => '0.7', 'changefreq' => 'monthly'],
        ['loc' => route('contact'), 'priority' => '0.6', 'changefreq' => 'monthly'],
        ['loc' => route('docs'),    'priority' => '0.8', 'changefreq' => 'monthly'],
        ['loc' => route('privacy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
    ];
    return response()->view('sitemap', compact('urls'))
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/parcele', fn() => view('parcele'))->name('parcele');
    Route::get('/gnojidba', fn() => view('gnojidba'))->name('gnojidba');
    Route::get('/prskanje', fn() => view('prskanje'))->name('prskanje');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
