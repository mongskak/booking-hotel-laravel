<?php

use App\Http\Controllers\AmenityController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\RoomAmenityController;
use App\Http\Controllers\RoomServicesController;
use App\Http\Controllers\RoomServiceTypeController;

//route auth 
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::delete('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware('auth')->group(function () {
    //route home
    Route::get('/', [HomepageController::class, 'index'])->name('home.index');

    //route booking
    Route::get('/bookings/search', [BookingController::class, 'search'])->name('booking.search');
    Route::post('/bookings/updateStatus', [BookingController::class, 'updateStatus'])->name('booking.setStatus');
    Route::get('/bookings', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/bookings/new', [BookingController::class, 'new'])->name('booking.new');
    Route::get('/bookings/detail/{id}', [BookingController::class, 'detail'])->name('booking.detail');
    Route::post('/bookings/roomavailable', [BookingController::class, 'handleRoomBooking'])->name('booking.available');
    Route::post('/bookings/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/bookings/edit/{id}', [BookingController::class, 'edit'])->name('booking.edit');
    Route::delete('/bookings/delete/{id}', [BookingController::class, 'delete'])->name('booking.delete');

    //route room
    Route::get('/rooms/search', [RoomController::class, 'searchRoomBooking'])->name('room.searchBooking');
    Route::get('/rooms', [RoomController::class, 'index'])->name('room.index');
    Route::get('/rooms/add', [RoomController::class, 'add'])->name('room.add');
    Route::get('/rooms/detail/{id}', [RoomController::class, 'detail'])->name('room.detail');
    Route::post('/rooms/create', [RoomController::class, 'create'])->name('room.create');
    Route::delete('/rooms/delete/{id}', [RoomController::class, 'delete'])->name('room.delete');

  //route employee
    Route::get('/employees/search', [EmployeeController::class, 'search'])->name('employee.search');
    Route::post('/employees/updateStatus/{id}', [EmployeeController::class, 'status'])->name('employee.setStatus');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/employees/new', [EmployeeController::class, 'new'])->name('employee.new');
    Route::get('/employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/employees/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/employees/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/employees/delete/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');

    //route room amenity
    Route::post('/roomAmenities/create', [RoomAmenityController::class, 'create'])->name('roomAmenity.create');
    Route::delete('/roomAmenities/delete/{id}', [RoomAmenityController::class, 'delete'])->name('roomAmenity.delete');

    //Room Services
    Route::post('/roomServices/create', [RoomServicesController::class, 'create'])->name('roomService.create');

    //Room Service Type
    Route::get('/roomServiceType', [RoomServiceTypeController::class, 'index'])->name('roomServiceType.index');
    Route::post('/roomServiceType/create', [RoomServiceTypeController::class, 'create'])->name('roomServiceType.create');
    Route::post('/roomServiceType/edit/{id}', [RoomServiceTypeController::class, 'edit'])->name('roomServiceType.edit');
    Route::delete('/roomServiceType/delete/{id}', [RoomServiceTypeController::class, 'delete'])->name('roomServiceType.delete');

    //Room Amenity
    Route::get('/amenity', [AmenityController::class, 'index'])->name('amenity.index');
    Route::post('/amenity/create', [AmenityController::class, 'create'])->name('amenity.create');
    Route::post('/amenity/edit/{id}', [AmenityController::class, 'edit'])->name('amenity.edit');
    Route::delete('/amenity/delete/{id}', [AmenityController::class, 'delete'])->name('amenity.delete');

    //chart booking
    Route::get('/chart', [ChartController::class, 'chart'])->name('booking.chart');

});
