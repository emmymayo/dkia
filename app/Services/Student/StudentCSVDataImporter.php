<?php
namespace App\Services\Student;

use App\Services\DataManager\AbstractCSVToArrayExtractor;

class StudentCSVDataImporter extends AbstractCSVToArrayExtractor
{
    
    private function __construct () {

    }

    public static function import(string $file, bool $hasHeader = true)
    {
        $importManager = new StudentCSVDataImporter();
        // extract array from csv
        $studentData = $importManager->extractDataFromCSVAsArray($file, $hasHeader);

        // create user

        // create student
        return $studentData;
    }


    public function getDataImportMapping(): array
    {
        return [
            'name',
            'email',
            'gender'
        ];
    }
}