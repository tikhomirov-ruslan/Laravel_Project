<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/login-form', function () {
    return <<<HTML
    <form method="POST" action="/api/login">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input name="email" placeholder="Email">
        <input name="password" type="password">
        <button>Login</button>
    </form>
    HTML;
});

require __DIR__.'/auth.php';
