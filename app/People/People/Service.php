<?php

declare(strict_types=1);

namespace App\People\People;

use App\People\People;
use App\People\People\Repository as PeopleRepository;
use App\People\Gender\Repository as GenderRepository;
use Carbon\Carbon;

class Service
{
    /**
     * A PeopleRepository instance.
     */
    private PeopleRepository $peopleRepository;

    /**
     * A GenderRepository instance.
     */
    private GenderRepository $genderRepository;

    /**
     * @param PeopleRepository $peopleRepository A PeopleRepository instance.
     * @param GenderRepository $genderRepository A GenderRepository instance.
     */
    public function __construct(PeopleRepository $peopleRepository, GenderRepository $genderRepository)
    {
        $this->peopleRepository = $peopleRepository;
        $this->genderRepository = $genderRepository;
    }

    /**
     * Import single people.
     *
     * @param string $firstName   The first name.
     * @param string $lastName    The last name.
     * @param Carbon $birthday    The birthday.
     * @param string $genderTitle The gender title.
     *
     * @return People|null
     */
    public function importSinglePeople(string $firstName, string $lastName, Carbon $birthday, string $genderTitle): ?People
    {
        $gender = $this->genderRepository->getGenderByTitle($genderTitle);

        if (!$gender) {
            return null;
        }

        $inputData = [
            'first_name' => trim($firstName),
            'last_name' => trim($lastName),
            'birthday' => $birthday->format('Y-m-d'),
            'gender_id' => $gender->id,
        ];

        return $this->peopleRepository->create($inputData);
    }
}
