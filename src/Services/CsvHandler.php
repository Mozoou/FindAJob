<?php
namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CsvHandler
{
    protected $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }
    public function getRegionFromCsv()
    {
        $path = $this->parameterBag->get('kernel.project_dir');
        $regions = [];
        $row = 1;
        if (($handle = fopen($path . '/public/csv/departements-region.csv', 'r')) !== FALSE) {
            fgetcsv($handle, 10000, ",");
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $row++;
                array_pop($data);

                $regions[$data[0].' - '.$data[1]] = $data[0];
            }
            fclose($handle);
            return ($regions);
        }
    }
}