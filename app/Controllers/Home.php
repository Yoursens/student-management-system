<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function landing()
    {
        return view('landing');  // points to app/Views/landing.php
    }
}