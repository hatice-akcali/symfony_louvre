<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 01/01/2018
 * Time: 15:02
 */

namespace LO\PlatformBundle\Services;

use LO\PlatformBundle\Services\CalculBillet;

class CalculBilletTwigExtension extends \Twig_Extension
{

    private $calculBilletService;

    public function __construct(CalculBillet $calculBilletService  )
    {
        $this->calculBilletService = $calculBilletService;

    }


    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter("calculPrix", array($this, "calculPrix")),
            new \Twig_SimpleFilter("age", array($this, "calculAge"))

        );
    }

    /* exemple avec les fonctions
     * public function getFunctions(){
        return array(
            new \Twig_SimpleFunction("getPrenom", array($this, "getPrenom"))
        );
    }

    public function getPrenom($prenom){
        return $prenom;
    }
    */


    public function calculPrix($billet){
        $prixBillet = $this->calculBilletService->calculerBillet($billet);
        return $prixBillet."€";
    }


    public function calculAge($billet){

    }
}

