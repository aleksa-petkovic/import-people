<?php

declare(strict_types=1);

namespace App\People\Import;

use App\People\People\Service as PeopleService;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use League\Csv\Reader;

class CsvImport
{
    /**
     * A PeopleService instance.
     */
    private PeopleService $peopleService;

    /**
     * @param PeopleService $peopleService A PeopleService instance.
     */
    public function __construct(PeopleService $peopleService)
    {
        $this->peopleService = $peopleService;
    }

    /**
     * Import file.
     *
     * @param UploadedFile $importFile The uploaded file.
     *
     * @return bool
     */
    public function importFile($importFile): bool
    {
        $csvFile = Reader::createFromFileObject($importFile->openFile());
        // We had to change default delimiter char.
        $csvFile->setDelimiter(';');

        $csvFile->setHeaderOffset(0);

        $results = $csvFile->getRecords();

        foreach ($results as $result) {
            $this->peopleService->importSinglePeople(
                $result['First name:'],
                $result['Last name:'],
                Carbon::createFromFormat('d/m/Y', $result['Date of birth:']),
                $result['Gender:'],
            );
        }

        return true;
    }
}
