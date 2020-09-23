<?php

declare(strict_types=1);

namespace App\People\Gender;

use App\People\Gender;
use Illuminate\Database\Eloquent\Collection;

class Repository
{
    /**
     * A Gender instance.
     */
    private Gender $gender;

    /**
     * @param Gender $gender A Gender instance.
     */
    public function __construct(Gender $gender)
    {
        $this->gender = $gender;
    }

    /**
     * Get gender by gender title.
     *
     * @param string $genderTitle The gender title.
     *
     * @return Gender|null
     */
    public function getGenderByTitle(string $genderTitle): ?Gender
    {
        return $this->gender->where('title', $genderTitle)->first();
    }

    /**
     * Get genders with people.
     *
     * @return Collection
     */
    public function getGendersWithPeople(): Collection
    {
        return $this->gender->with('people')->get();
    }
}
