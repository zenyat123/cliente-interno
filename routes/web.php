<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

Route::get("/", function()
{

    return view("welcome");

});

Route::get("/dashboard", function()
{

    return view("dashboard");

})->middleware(["auth"])->name("dashboard");

require __DIR__."/auth.php";

Route::resource("categories", CategoryController::class)->middleware("auth");
Route::get("post", [PostController::class, "store"])->middleware("auth");