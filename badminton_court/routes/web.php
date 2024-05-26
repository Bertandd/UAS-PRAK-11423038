<?php

use App\Http\Controllers\Admin\FieldLocationController;
use App\Http\Controllers\Admin\OperatorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Operator\FieldController;
use App\Http\Controllers\Operator\MemberController;
use App\Http\Controllers\OperatorController as ControllersOperatorController;
use App\Http\Controllers\UserController;
use Faker\Core\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
//generate password
Route::get('/generate-password', function () {
    return Hash::make('password');
});


//register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

//register post
Route::post('/register', [GuestController::class, 'register'])->name('register.post');

//route group public
Route::get('/',[GuestController::class,'field'])->name('home');

Route::prefix('guest')->group(function () {
    Route::get('/field', [GuestController::class, 'field'])->name('guest.field');
    //category filter
    Route::post('/field/location/', [GuestController::class, 'fieldByLocation'])->name('guest.field.location');
});

Route::get('/dashboard', function () {
    //alihkan sesuai role
    if (Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role == 'user') {
        return redirect()->route('user.dashboard');
    } elseif (Auth::user()->role == 'operator') {
        return redirect()->route('operator.dashboard');
    } else {
        return redirect()->route('login');
    }
})->middleware(['auth'])->name('dashboard');

Route::get('/checkRole', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    if (Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role == 'user') {
        return redirect()->route('user.dashboard');
    } elseif (Auth::user()->role == 'operator') {
        return redirect()->route('operator.dashboard');
    } else {
        return redirect()->route('login');
    }
})->name('checkRole');

Route::middleware('checkRole:admin')->group(function () {
    //dashboard dari dashboard controller
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    //masukkan ke dalam group route prefix admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('field-locations', FieldLocationController::class);
        //operator
        Route::resource('operator', OperatorController::class);
        Route::get('report', [AdminController::class, 'report'])->name('report.index');
        //report filter date
        Route::post('report/filter', [AdminController::class, 'reportFilter'])->name('report.filter');
        //export
        Route::post('report/export', [AdminController::class, 'reportExport'])->name('report.export');
    });

});
Route::middleware('checkRole:operator')->group(function () {
    //dashboard dari dashboard controller
    Route::get('/operator/dashboard', [ControllersOperatorController::class, 'index'])->name('operator.dashboard');
    //masukkan ke dalam group route prefix admin
    Route::prefix('operator')->name('operator.')->group(function () {
        //fields
        Route::resource('field', FieldController::class);
        //operator
        Route::resource('member', MemberController::class);
        Route::get('booking', [ControllersOperatorController::class, 'booking'])->name('booking.index');
        //confirm
        Route::get('booking/confirm/{id}', [ControllersOperatorController::class, 'confirm'])->name('booking.confirm');
        //reject
        Route::get('booking/reject/{id}', [ControllersOperatorController::class, 'reject'])->name('booking.reject');
        //report filter date
        Route::get('booking/filter/{start}/{end}', [ControllersOperatorController::class, 'bookingFilter'])->name('booking.filter');
    });

});
Route::middleware('checkRole:user')->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    //masukkan ke dalam group route prefix admin
    Route::prefix('user')->name('user.')->group(function () {
        //booking
        Route::get('booking/{id}/{date}/{start}/{end}', [UserController::class, 'booking'])->name('booking');
        Route::get('booking/edit/{id}}', [UserController::class, 'edit'])->name('booking.edit');
        Route::put('booking/edit/store/{id}}', [UserController::class, 'edit_store'])->name('booking.edit.store');
        //post
        Route::post('booking/{id}', [UserController::class, 'storeBooking'])->name('booking.store');
        Route::get('booking-history', [UserController::class, 'bookingHistory'])->name('booking-history');

    });

});
//route profile user dan admin
Route::middleware('auth')->group(function () {
    Route::get('/profile/update', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});


//buat akun kasir, manager dan owner
Route::get('/buat', function () {
    $data = [
        [
            'name' => 'Pengelola Lapangan',
            'email' => 'pengeloladefault@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'operator',
        ]
    ];
    //insert bulk menggunakan eloquent
    \App\Models\User::insert($data);
    return 'berhasil';

})->name('buat');

//storage link
Route::get('/link', function () {
    //hapus folder storage
    \Illuminate\Support\Facades\File::deleteDirectory(public_path('storage'));
    return Artisan::call('storage:link');
});

require __DIR__ . '/auth.php';
