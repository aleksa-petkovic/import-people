<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller as BaseController;
use App\People\People\Repository as PeopleRepository;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\View\View;

class HomeController extends BaseController
{
    /**
     * Displays the website home page.
     *
     * @param PeopleRepository $peopleRepository A PeopleRepository instance.
     * @param Sentinel         $sentinel         A Sentinel instance.
     *
     * @return View
     */
    public function index(PeopleRepository $peopleRepository, Sentinel $sentinel): View
    {
        $user = $sentinel->getUser();
        $people = $peopleRepository->getAll();

        return view('home', [
            'people' => $people,
            'authenticatedUser' => $user,
        ]);
    }
}
