<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 03/01/2018
 * Time: 12:34
 */

namespace LO\PlatformBundle\Services;


use LO\PlatformBundle\Entity\Billet;
use LO\PlatformBundle\Entity\Commande;
use Symfony\Component\HttpFoundation\RequestStack;


class SessionCommande
{
    private $session;

    public function __construct(RequestStack $request){
        $this->session = $request->getCurrentRequest()->getSession();
    }



    public function enregistrerSession(Commande $commande ){
        $commandeArray = array();
        $commandeArray['dateVisited'] = $commande->getDateVisited()->format('d/m/Y');
        $commandeArray['amountPaid'] = $commande->getAmountPaid();
        $commandeArray['email'] = $commande->getEmail();
        $commandeArray['isDay'] = $commande->getIsDay();

        $commandeArray['billets'] = array();
        foreach( $commande->getBillets() as $billet){
            $billetArray = array();
            $billetArray['name'] = $billet->getName();
            $billetArray['firstname'] = $billet->getFirstname();
            $billetArray['birthdate'] = $billet->getBirthdate()->format('d/m/Y');
            $billetArray['reducedPrice'] = $billet->getReducedPrice();
            $billetArray['country'] = $billet->getCountry();

            $commandeArray['billets'][] = $billetArray;


        }

        $this->session->set('commande', $commandeArray);
    }


    public function recupererSession(){
        $commandeArray = $this->session->get('commande');

        $commande = new Commande();

        $dtVisited = \DateTime::createFromFormat('d/m/Y',  $commandeArray['dateVisited']);
        $commande->setDateVisited($dtVisited);

        $commande->setAmountPaid($commandeArray['amountPaid']);
        $commande->setEmail($commandeArray['email']);
        $commande->setIsDay($commandeArray['isDay']);

        foreach($commandeArray['billets'] as $billetArray){
            $billet = new Billet();

            $billet->setName($billetArray['name']);
            $billet->setFirstName($billetArray['firstname']);

            $birthdate = \DateTime::createFromFormat('d/m/Y',  $billetArray['birthdate']);
            $billet->setBirthdate($birthdate);

            $billet->setReducedPrice($billetArray['reducedPrice']);
            $billet->setCountry($billetArray['country']);

            $billet->setCommande($commande);
            $commande->addBillet($billet);
        }

        return $commande;

    }

    public function verifierSession(){
        if($this->session->has('commande')){
            return true;
        }
        else{
            return false;
        }
    }


    public function detruireSession(){
        $this->session->remove('commande');
    }







}