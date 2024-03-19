<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    public function reboot(Request $request)
    {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        return "Cache cleared successfully";
    }
}
