<?php

Route::get('/', function () {
    return redirect()->route('filament.app.pages.dashboard');
});