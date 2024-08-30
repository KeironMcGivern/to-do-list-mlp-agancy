<?php

declare(strict_types=1);

use App\Models\ListItem;
use App\Models\ToDoList;
use Illuminate\Support\Facades\Route;

Route::bind('list', static function (string $id) {
    return ToDoList::whereUuid($id)->first() ?? abort(404);
});

Route::bind('listItem', static function (string $id) {
    return ListItem::whereUuid($id)->first() ?? abort(404);
});
