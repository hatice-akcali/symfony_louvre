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

        $commande = new Commande();

            $formCommande = $this->createForm(CommandeType::class, $commande);
        dump($request);

            $formCommande->handleRequest($request);

            if ($formCommande->isSubmitted() && $formCommande->isValid()) {
                //$test = $billet->getName();
                $em = $this->getDoctrine()->getManager();

                $serviceBillet = $this->get("lo_platform.calculBillet");
                $prixCommande = 0;
                foreach($commande->getBillets() as $billet){
                    $prixBillet = $serviceBillet->calculerBillet($billet);
                    $prixCommande += $prixBillet;
                    $billet->setCommande($commande);
                }
                $commande->setAmountPaid( $prixCommande);

                $em->persist($commande);
                $em->flush();

                // Récupération de la session
                $session = $request->getSession();
                // On définit une nouvelle valeur pour cette variable command_id (toujours 2 arguments)
                $session->set('command_id', $commande->getId() );

                return $this->redirectToRoute("lo_platform_recapitulatif");

            }

            return $this->render('LOPlatformBundle:Billet:index.html.twig', array(
                'formCommande' => $formCommande->createView()));

        }



        public function recapitulatifAction(Request $request)
        {
            // Récupération de la session
            $session = $request->getSession();
            // On récupère le contenu de la variable commandId
            $commandId = $session->get('command_id');

            // Recherche la commande en base de donnée
            $em = $this->getDoctrine()->getManager();
            $commande = $em->getRepository(Commande::class)->find( $commandId);


            return $this->render('LOPlatformBundle:Billet:recapitulatif.html.twig', array('commande' => $commande));
        }


        public function paiementAction(Request $request)
        {
            $session = $request->getSession();
            $commandId = $session->get('command_id');
            $em = $this->getDoctrine()->getManager();
            $commande = $em->getRepository(Commande::class)->find($commandId);
            $montantTotal = $commande->getAmountPaid()* 100;
            $numeroUnique = $commande->getCodeCommande();

            // Token renvoyé par Stripe
            $stripeToken = $request->request->get("stripeToken") ;
            \Stripe\Stripe::setApiKey("sk_test_eDiNn8uEe14zJ81NIAVOsE0h");
            \Stripe\Charge::create(array(
                "amount" => $montantTotal,
                "currency" => "EUR",
                "source" => $stripeToken, // obtained with Stripe.js
                "description" => $numeroUnique
            ));


            return $this->render('LOPlatformBundle:Billet:confirmationPaiement.html.twig', array('stripeToken' => $stripeToken, 'commande' => $commande));
        }


    }



