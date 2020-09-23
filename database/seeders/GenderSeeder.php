<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\People\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $maleGender = new Gender();
        $maleGender->title = 'male';
        $maleGender->save();

        $femaleGeneder = new Gender();
        $femaleGeneder->title = 'female';
        $femaleGeneder->save();
    }
}
