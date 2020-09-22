<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\View\View;

class HomeController extends BaseController
{

    /**
     * Gets the admin panel homepage.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.home');
    }
}
