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

            // On récupère le service session.commande...
            $sessionService = $this->get('lo_platform.session.commande');

            // ... On vérifie s'il y a bien une commande en session...
            if ($sessionService->verifierSession()){
                //... S'il y en a une, on la récupère...
                $commande = $sessionService->recupererSession();
            }
            else{
                $commande = new Commande();     //...Sinon, on crée une nouvelle Commande.
            }
            // .On crée le formulaire, et on lui renseigne la commande...
            $formCommande = $this->createForm(CommandeType::class, $commande);

            //On lui demande de gérer la requête au serveur.
            $formCommande->handleRequest($request);

            // ...On vérifie, si le formulaire est soumis, et s'il est valide, si c'est le cas...
            if ($formCommande->isSubmitted() && $formCommande->isValid()) {
                // ...On récupère le service calculBillet (calculer le prix du billet en fonction de l'age, et vréduction )
                $serviceBillet = $this->get("lo_platform.calculBillet");

                // On initialise le prix de la commande à 0
                $prixCommande = 0;

                //.Pour chaque billet de la commande...
                foreach($commande->getBillets() as $billet){
                    // ...On calcule le prix individuel du billet...
                    $prixBillet = $serviceBillet->calculerBillet($billet);
                    //.. On additionne le prix du billet, au prix  de la commande...
                    $prixCommande += $prixBillet;

                    // On renseigne la commande du billet.
                    $billet->setCommande($commande);
                }

                // On renseigne le prix de la commande
                $commande->setAmountPaid( $prixCommande);
                // On récupère le service lo_platform.session.commande
                $sessionCommande = $this->get("lo_platform.session.commande");

                //.On enregistre la commande dans la cession.
                $sessionCommande->enregistrerSession($commande);

                // .On redirige l'utilisateur vers la page lo_platform_recapitulatif (le controleur recapitulatifAction)
                return $this->redirectToRoute("lo_platform_recapitulatif");

            }

            // Sinon on renvoie la page du formulaire, composé du template index.html.twig, et de la variable $formCommande
            return $this->render('LOPlatformBundle:Billet:index.html.twig', array(
                'formCommande' => $formCommande->createView()));

        }



        public function recapitulatifAction(Request $request)
        {
            // .On stocke le service lo_platform.session.service, dans la variable $sessionService
            $sessionService = $this->get('lo_platform.session.commande');
            // ...S'il n'y a pas de commande d'enregistrer en session...
            if ($sessionService->verifierSession()==false) {
                // On récupère la session
                $session = $request->getSession();
                // On crée un message flashBag (est ce qui contient les messages flash  dans la session).
                $session->getFlashBag()->add('erreur', 'Pas si vite, vous devez déjà remplir le formulaire !');

                // ...Puis on redirige l'utilidsateur vers la page d'accueil, avec un messafe d'erreur.
                return $this->redirectToRoute("lo_platform_homepage");
            }


            //.S'il y en a une, on réupère la commande dans la cession...
            $commande = $sessionService->recupererSession();
            // ...On retourne le template récapitulatif. (les variables 'commande' sont récupérés dans le template twig)
            //...L'utilisateur a ce stage a effectué son paiement.
            return $this->render('LOPlatformBundle:Billet:recapitulatif.html.twig', array('commande' => $commande));
        }




        public function paiementAction(Request $request)
        {
            //.On récupère le service sessioncommande...
            $sessionService = $this->get('lo_platform.session.commande');
            //...S'il n'y a pas de commande en session...
            if ($sessionService->verifierSession()==false) {

                // On récupère la session
                $session = $request->getSession();
                // On crée un message flashBag (est ce qui contient les messages flash  dans la session).
                $session->getFlashBag()->add('erreur', 'Pas si vite, vous devez déjà remplir le formulaire !');

                //.On redirige vers la page d'accueil, avec un message d'erreur
                return $this->redirectToRoute("lo_platform_homepage");
            }

            //.Et s'il y a une commande en cession, on la récupère...
            $commande = $sessionService->recupererSession();
            // Le prix de la commande
            $montantTotal = $commande->getAmountPaid()* 100;
            $numeroUnique = $commande->getCodeCommande();

            // .On appelle Stripe, puis on tente d'effectuer le paiement.
            $stripeToken = $request->request->get("stripeToken") ;
            \Stripe\Stripe::setApiKey("sk_test_eDiNn8uEe14zJ81NIAVOsE0h");
            try {
                \Stripe\Charge::create(array(
                    "amount" => $montantTotal,
                    "currency" => "EUR",
                    "source" => $stripeToken,
                    "description" => $numeroUnique  // Numéro unique
                ));
            }catch(\Exception $exception){  // .Si le paiement ne passe pas..
                // On récupère la session
                $session = $request->getSession();
                // Le flashBag est ce qui contient les messages flash  dans la session.
                $session->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors du paiement veuillez réessayer !');

                //.On redirige vers la page lo_platform_recapitulatif...
                return $this->redirectToRoute("lo_platform_recapitulatif");

            }

            // .Puis on enregistrer la commande en base de donnée.
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            // .Ensuite on détruit la commande en session.
            $sessionService->detruireSession();


            //.On récupère le service mailer.... :
            $mailer = $this->get('mailer');
            // ...On crée le mail (définit le sujet, l'adresse d'envoi, de destinataire, et le corps du mail)
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
            // ...Et puis on envoie le mail...
            $mailer->send($message);

            //... Et on retourne le template confirmationPaiement.html.twig.(le processus est terminé)
            return $this->render('LOPlatformBundle:Billet:confirmationPaiement.html.twig', array('stripeToken' => $stripeToken, 'commande' => $commande));
        }



        // Ensuite on redirige vers la page d'accueil, en rajoutant la langue.
        public function redirigerAccueilAction(){
            return $this->redirectToRoute("lo_platform_homepage");
        }








}



