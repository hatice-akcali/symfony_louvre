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
        $billet = new Billet;
        $commande = new Commande;

        $form = $this->get('form.factory')->create(BilletType::class, $billet);
        $formCommande = $this->get('form.factory')->create(CommandeType::class, $commande);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($billet);
            $em->persist($commande);
            $em->flush();
        }

        return $this->render('LOPlatformBundle:Billet:index.html.twig', array
                                  ('form' => $form->createView(),
                                   'formCommande' => $formCommande->createView()));

    }

    public function layoutAction()
    {
        return $this->render('LOPlatformBundle::layout.html.twig');
    }

    public function recapitulatifAction()
    {
        return $this->render('LOPlatformBundle:Billet:recapitulatif.html.twig');
    }


}


