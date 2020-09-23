<?php

declare(strict_types=1);

namespace App\People\Http\Controllers\Api\V1\People;

use App\Http\Controllers\Controller as BaseController;
use App\People\Gender\Repository as GenderRepository;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    /**
     * Get all people grouped by gender.
     *
     * @param GenderRepository $genderRepository A GenderRepository instance.
     *
     * @return JsonResponse
     */
    public function importedPeople(GenderRepository $genderRepository): JsonResponse
    {
        $genders = $genderRepository->getGendersWithPeople();

        return new JsonResponse($genders);
    }
}
