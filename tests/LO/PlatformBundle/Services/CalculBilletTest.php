<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 05/01/2018
 * Time: 11:35
 */

namespace Tests\LO\PlatformBundle\Services;


use LO\PlatformBundle\Entity\Billet;
use LO\PlatformBundle\Services\CalculBillet;
use PHPUnit\Framework\TestCase;

class CalculBilletTest extends TestCase
{
    /**
     * @dataProvider pricesBirthdateReduction
     */
    public function testCalculerBillet($birthdate, $reduction, $priceExpected){
        $trancheAge = array(
            "0" => 0,
            "4" => 8,
            "12" => 16,
            "60" => 12);

        $reducBillet = 10;

        $calculBillet = new CalculBillet($trancheAge, $reducBillet);

        $billet = new Billet();
        $billet->setReducedPrice($reduction);
        $dateNaissanceObjet =\DateTime::createFromFormat("d/m/Y", $birthdate);
        $billet->setBirthdate($dateNaissanceObjet);

        // Prix du billet, sera stocké dans la variable $prixBillet
        $prixBillet = $calculBillet->calculerBillet($billet);
        //Comparé le prix attendu, par rapport au prix calculculé
        $this->assertSame($priceExpected,$prixBillet);

    }

    public function pricesBirthdateReduction(){
        //date de naissance, reduction, prix attendu
        $birthdateReduction = [
            ["09/10/1999", true, 10],
            ["09/10/2016", false, 0],
            ["09/10/1930", false, 12],
            ["09/10/2012", false, 8],
            ["09/10/1984", false, 16]
        ];

        return $birthdateReduction;
    }
}