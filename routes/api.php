<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\studentController;

Route::get('/students', [studentController::class, 'index']);

// Create

Route::post('/students', [studentController::class, 'store']);

// Read

Route::get('/students/{id}', [studentController::class, 'show']);

// Update

Route::put('/students/{id}', [studentController::class, 'update']);


// Delete
Route::delete('/students/{id}', [studentController::class, 'destroy']);

