<?php

use App\Http\Controllers\ToDoListController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ToDoListController::class, 'index'])->name('toDoList');
Route::put('/complete/{listItem}', [ToDoListController::class, 'update'])->name('toDoList.update');
Route::post('/{list}', [ToDoListController::class, 'store'])->name('toDoList.store');
Route::delete('/{listItem}', [ToDoListController::class, 'delete'])->name('toDoList.delete');
