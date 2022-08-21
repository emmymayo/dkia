<?php 

namespace App\Services\DataManager;

abstract class AbstractCSVToArrayExtractor
{
    protected function extractDataFromCSVAsArray(string $file, bool $hasHeader = true): array
    {
        $row = 1;
        $extractedDataArray = [];
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if( $hasHeader && $row == 1) { // skip heading
                    $row++; 
                    continue; 
                }
    
                $dataMapping = $this->getDataImportMapping();
                $rowData = [];
                foreach ($dataMapping as $col => $field) {
                    $rowData[$field] = $data[$col];
                }

                $extractedDataArray[] = $rowData;
                $row++;
    
            }
            fclose($handle);
        }

        return $extractedDataArray;
    }

    abstract protected function getDataImportMapping(): array;


}
