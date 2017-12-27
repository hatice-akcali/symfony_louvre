<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19/12/2017
 * Time: 11:08
 */

namespace LO\PlatformBundle\Services;


use LO\PlatformBundle\Entity\Billet;

class CalculBillet
{
    private $reducBillet;
    private $tableauTrancheAge;

    public function __construct($trancheAge, $reducBillet)
    {
        $this->tableauTrancheAge = $trancheAge;
        $this->reducBillet = $reducBillet;
    }


    public function calculerBillet(Billet $billet ){
        // Différence entre la date d'anniversaire, et la date du jour, pour obtenir l'age
        $birthdate = $billet->getBirthdate();
        $today = new \DateTime("now");
        $age = $today->diff($birthdate)->y;

        // Déterminer le prix en fonction de l'age
        $prix = 0;
        foreach($this->tableauTrancheAge as $recupAge => $prixAge){
            if ($age >= $recupAge){
                $prix = $prixAge;
            }
        }

        // S'il y a réduction et que l'age est au dessus de ou égal à 12
        if($billet->getReducedPrice() == true && $age >= 12){
            return $this->reducBillet ;
        }
        else{
            return $prix;
        }
    }

}