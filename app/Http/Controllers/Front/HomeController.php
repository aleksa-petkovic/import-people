<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Auth\Http\Controllers\Front\Controller;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class HomeController extends BaseController
{
    /**
     * Displays the website home page.
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return Redirect::action(Controller::class . '@index');
    }
}
