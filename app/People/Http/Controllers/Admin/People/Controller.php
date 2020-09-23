<?php

declare(strict_types=1);

namespace App\People\Http\Controllers\Admin\People;

use App\Http\Controllers\Controller as BaseController;
use App\People\Http\Requests\Admin\People\ImportRequest;
use App\People\Import\CsvImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Controller extends BaseController
{
    /**
     * Import people from uploaded file.
     *
     * @param ImportRequest $request   A Request instance.
     * @param CsvImport     $csvImport A CsvImport service instance.
     *
     * @return RedirectResponse
     */
    public function importPeople(ImportRequest $request, CsvImport $csvImport): RedirectResponse
    {
        $importFile = $request->file('import_file');

        switch ($importFile->getClientMimeType()) {
            case "text/csv":
                $csvImport->importFile($importFile);
                break;
            default:
                throw new BadRequestHttpException('Unknown mime type.');
        }

        return Redirect::action('App\Http\Controllers\Admin\HomeController@index');
    }
}
