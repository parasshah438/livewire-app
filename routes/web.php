<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\ContactUs;
use App\Livewire\EmployeeRegistration;
use App\Livewire\ProductList;
use App\Livewire\Cart;

Route::get('/', function () {
    return view('welcome');
});

Route::get('lifecycle-docs', function () {
    return view('lifecycle-documentation');
})->name('lifecycle');

//Livewire Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

//User Dashboard and Profile
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', App\Livewire\UserProfile::class)->name('user-profile');

    //Users listing
    Route::get('/users', App\Livewire\UserListing::class)->name('users.index');
    //Todo List
    Route::get('/todos', App\Livewire\TodoList::class)->name('todos.index');
    //Logout route    
    Route::post('/logout', function () {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

//Livewire Learning Routes
Route::get('counter', function () {
    return view('livewire-demo', ['component' => 'counter']);
})->name('counter');

//Contact Us
Route::get('contact-us', ContactUs::class)->name('contact');

//Multistep Form Example
Route::get('employee-registration', EmployeeRegistration::class)->name('employee-registration');

//eCommerce Routes
Route::get('/products', ProductList::class)->name('products');
Route::get('/cart', Cart::class)->name('cart');

//Static Pages
Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('dependent-dropdowns', function () {
    return view('dependent-dropdowns');
})->name('dependent-dropdowns');

//Image Upload
Route::get('/image-upload', App\Livewire\ImageUpload::class)->name('image-upload');
Route::get('/optimized-image-upload', App\Livewire\OptimizedImageUpload::class)->name('optimized-image-upload');
Route::get('/sample-file-upload',App\Livewire\SampleFileUpload::class)->name('sample-file-upload');
Route::get('/image-gallery', App\Livewire\ImageGallery::class)->name('image-gallery');


//Test Mail Route (for debugging)
Route::get('/test-mail', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('This is a test email from Laravel!', function ($message) {
            $message->to('parasshah438@gmail.com')
                    ->subject('Test Email from Laravel');
        });
        return 'Test email sent successfully! Check your inbox.';
    } catch (\Exception $e) {
        return 'Mail Error: ' . $e->getMessage();
    }
});
