<?php
namespace App\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppExtension extends AbstractExtension
{
    private $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('getRegion', [$this, 'getRegion']),
            new TwigFilter('showExp', [$this, 'showExp']),
        ];
    }

    public function getRegion(int $region)
    {
        $path = $this->parameterBag->get('kernel.project_dir');
        $result  = [];
        if (($handle = fopen($path . '/public/csv/departements-region.csv', 'r')) !== FALSE) {
            
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if($region == $data[0]){
                    return $data[2];
                }
            }
            fclose($handle);
            return false;
        }
    }

    public function showExp(int $exp){
        if($exp == '1'){
            return 'moins d\'un 1 an';
        }elseif($exp == 2){
            return 'entre 2 & 5 ans';
        }else{
            return 'plus de 5 ans';
        }
    }
}