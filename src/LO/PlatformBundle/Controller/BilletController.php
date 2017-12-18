<?php

namespace LO\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LO\PlatformBundle\Entity\Billet;
use LO\PlatformBundle\Form\BilletType;
use Symfony\Component\HttpFoundation\Request;

use LO\PlatformBundle\Entity\Commande;
use LO\PlatformBundle\Form\CommandeType;




class BilletController extends Controller
{

    public function indexAction(Request $request)
    {

        $commande = new Commande;

            $formCommande = $this->createForm(CommandeType::class, $commande);
        dump($request);

            $formCommande->handleRequest($request);

            if ($formCommande->isSubmitted() && $formCommande->isValid()) {
                //$test = $billet->getName();
                $em = $this->getDoctrine()->getManager();
                foreach($commande->getBillets() as $billet){
                    $billet->setCommande($commande);
                }
                $em->persist($commande);
                $em->flush();

                return $this->render('LOPlatformBundle:Billet:recapitulatif.html.twig', array('billet' => $billet));

            }

            return $this->render('LOPlatformBundle:Billet:index.html.twig', array(
                'formCommande' => $formCommande->createView()));

        }

        public
        function layoutAction()
        {
            return $this->render('LOPlatformBundle::layout.html.twig');
        }

        public
        function recapitulatifAction()
        {
            return $this->render('LOPlatformBundle:Billet:recapitulatif.html.twig');
        }
    }



