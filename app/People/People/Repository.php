<?php

declare(strict_types=1);

namespace App\People\People;

use App\People\Gender;
use App\People\People;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class Repository
{
    /**
     * A People instance.
     */
    private People $people;

    /**
     * @param People $people A People instance.
     */
    public function __construct(People $people)
    {
        $this->people = $people;
    }

    /**
     * Get all people.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->people->with('gender')->get();
    }

    /**
     * Create new people.
     *
     * @param array $inputData The input data.
     *
     * @return People
     */
    public function create(array $inputData): People
    {
        $people = $this->people->newInstance();
        $people->first_name = Arr::get($inputData, 'first_name', '');
        $people->last_name = Arr::get($inputData, 'last_name', '');
        $people->birthday = Arr::get($inputData, 'birthday', '');
        $people->gender_id = (int) Arr::get($inputData, 'gender_id', 0);

        $people->save();

        return $people;
    }
}
