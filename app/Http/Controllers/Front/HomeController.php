<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\View\View;

class HomeController extends BaseController
{
    /**
     * Displays the website home page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('welcome');
    }
}
