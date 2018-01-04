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
        // Pour obtenir l'age, on calcule, la différence entre la date d'anniversaire...
        $birthdate = $billet->getBirthdate();
        // ... et la date du jour....
        $today = new \DateTime("now");
        // ... pour obtenir l'age.
        $age = $today->diff($birthdate)->y;

        // Déterminer le prix en fonction de l'age
        $prix = 0;
        // Pour chacun tranche d'age,  on récupère l'age, et le prix
        foreach($this->tableauTrancheAge as $recupAge => $prixAge){
            // A chaque itération, on vérifie que l'age est supérieur ou égal à l'age de la tranche d'age en cours
            if ($age >= $recupAge){
                // Le prix est alors égale, au prix de la tranche d'age en cours
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