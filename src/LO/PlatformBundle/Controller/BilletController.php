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

            // On stocke le service lo_platform.session.service, dans la variable $sessionService
            $sessionService = $this->get('lo_platform.session.commande');

            // On vérifie s'il y a quelque chose en session
            if ($sessionService->verifierSession()){
                // On stocke le resultat de la variable $session du service, dans la variable $commande
                $commande = $sessionService->recupererSession();
            }
            else{
                $commande = new Commande();     // Sinon, on crée une nouvelle Commande
            }


            $formCommande = $this->createForm(CommandeType::class, $commande);
            //Nous demandons au formulaire de vérifier la requête demandé par le visiteur, au serveur.
            $formCommande->handleRequest($request);
            //Si le formulaire est soumis, et qu'il est valide
            if ($formCommande->isSubmitted() && $formCommande->isValid()) {

                //On stocke l'entity Manager dans la variable $em
                $em = $this->getDoctrine()->getManager();
                // On stocke le service lo_platform.calculBillet, dans la variable $serviceBillet
                // Ce service se trouve dans le fichier service.yml
                $serviceBillet = $this->get("lo_platform.calculBillet");
                // On initialise le prix de la commande à 0
                $prixCommande = 0;
                // Pour chaque billet de la commande, identifié par $billet
                foreach($commande->getBillets() as $billet){
                    // On calcule le prix du billet, qu'on stocke dans la variable $prixBillet
                    $prixBillet = $serviceBillet->calculerBillet($billet);
                    // On ajoute le prix du billet, au prix de la commande
                    $prixCommande += $prixBillet;
                    // On renseigne la commande du billet par cette action.
                    $billet->setCommande($commande);
                }
                // On renseigne le prix de la commande
                $commande->setAmountPaid( $prixCommande);

                // J'ai stocké le service lo_platform.session.commande, dans la variable $sessionCommande
                $sessionCommande = $this->get("lo_platform.session.commande");
                // J'appelle la fonction enregistrerSession
                $sessionCommande->enregistrerSession($commande);

                // On redirige vers la page lo_platform_recapiyulatif.
                return $this->redirectToRoute("lo_platform_recapitulatif");

            }

            // Sinon on renvoie la page du formulaire, composé du template index.html.twig, et de la variable $formCommande
            return $this->render('LOPlatformBundle:Billet:index.html.twig', array(
                'formCommande' => $formCommande->createView()));

        }



        public function recapitulatifAction(Request $request)
        {
            // On stocke le service lo_platform.session.service, dans la variable $sessionService
            $sessionService = $this->get('lo_platform.session.commande');

            if ($sessionService->verifierSession()==false) {
                // On redirige vers la page lo_platform_homepage.
                return $this->redirectToRoute("lo_platform_homepage");
            }

            // On stocke la fonction recupererSession du service, dans la variable $commande
            $commande = $sessionService->recupererSession();
            // On retourne le template récapitulatif
            return $this->render('LOPlatformBundle:Billet:recapitulatif.html.twig', array('commande' => $commande));
        }


        public function paiementAction(Request $request)
        {
            //
            $sessionService = $this->get('lo_platform.session.commande');

            if ($sessionService->verifierSession()==false) {
                // On redirige vers la page lo_platform_homepage.
                return $this->redirectToRoute("lo_platform_homepage");
            }

            $commande = $sessionService->recupererSession();

            $montantTotal = $commande->getAmountPaid()* 100;
            $numeroUnique = $commande->getCodeCommande();

            // Token renvoyé par Stripe
            $stripeToken = $request->request->get("stripeToken") ;
            \Stripe\Stripe::setApiKey("sk_test_eDiNn8uEe14zJ81NIAVOsE0h");
            try {
                \Stripe\Charge::create(array(
                    "amount" => $montantTotal,
                    "currency" => "EUR",
                    "source" => $stripeToken, // obtained with Stripe.js
                    "description" => $numeroUnique
                ));
            }catch(\Exception $exception){
                // On redirige vers la page lo_platform_recapitulatif.
                return $this->redirectToRoute("lo_platform_recapitulatif");

            }

            // Enregistrer en base de donnée
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            // Puis on détruit la session
            $sessionService->detruireSession();

            //Et on envoie un mail,  On a donc accès au conteneur :
            $mailer = $this->container->get('mailer');

            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('contact@louvre.com')
                ->setTo($commande->getEmail())
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/emailConfirmation.html.twig
                        'Emails/emailConfirmation.html.twig',
                        array('commande' => $commande)
                    ),
                    'text/html'
                );
            // On envoie le mail
            $mailer->send($message);

            // On retourne le template confirmationPaiement.html.twig
            return $this->render('LOPlatformBundle:Billet:confirmationPaiement.html.twig', array('stripeToken' => $stripeToken, 'commande' => $commande));
        }








}



