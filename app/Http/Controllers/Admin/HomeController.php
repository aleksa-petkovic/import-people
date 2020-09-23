<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\People\People;
use App\People\People\Repository as PeopleRepository;
use Illuminate\View\View;

class HomeController extends BaseController
{
    /**
     * Gets the admin panel homepage.
     *
     * @param PeopleRepository $peopleRepository A PeopleRepository instance.
     *
     * @return View
     */
    public function index(PeopleRepository $peopleRepository): View
    {
        $people = $peopleRepository->getAll();

        return view('admin.home', [
            'people' => $people,
        ]);
    }
}
