<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 05/01/2018
 * Time: 15:26
 */

namespace Tests\LO\PlatformBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BilletControllerTest extends WebTestCase
{
    protected function appendPrototypeDom(\DOMElement $node, $currentIndex = 0, $count = 1)
    {
        $prototypeHTML = $node->getAttribute('data-prototype');

        $accumulatedHtml = '';
        for ($i = 0; $i < $count; $i++) {
            $accumulatedHtml .= str_replace('__name__', $currentIndex + $i, $prototypeHTML);
        }


        $prototypeFragment = new \DOMDocument();
        $prototypeFragment->loadHTML($accumulatedHtml);
        foreach ($prototypeFragment->getElementsByTagName('body')->item(0)->childNodes as $prototypeNode) {
            $node->appendChild($node->ownerDocument->importNode($prototypeNode, true));
        }

    }

    public function testIndexAction(){

        $client = static::createClient();
        $crawler = $client->request("GET", "/fr/");


        $tickets = $crawler->filter("#lo_platformbundle_commande_billets")->getNode(0);
        $this->appendPrototypeDom($tickets);



        $form = $crawler->filter("#lo_platformbundle_commande_save")->form();
        $form['lo_platformbundle_commande[dateVisited]'] = "2018-02-25";
        $form['lo_platformbundle_commande[email]'] = "toto@gmail.com";
        $form['lo_platformbundle_commande[isDay]'] = "1";


        $form["lo_platformbundle_commande[billets][0][name]"] = "Toto";
        $form["lo_platformbundle_commande[billets][0][firstname]"] = "SOUTENANCE";
        $form["lo_platformbundle_commande[billets][0][country]"] = "France";
        $form["lo_platformbundle_commande[billets][0][birthdate][day]"] = "4";
        $form["lo_platformbundle_commande[billets][0][birthdate][month]"] = "9";
        $form["lo_platformbundle_commande[billets][0][birthdate][year]"] = "1984";
        $form["lo_platformbundle_commande[billets][0][reducedPrice]"] = "1";

        $crawler = $client->submit($form);



        $client->followRedirect();


        echo $client->getResponse()->getContent();


        //echo $client->getRequest()->get("_route");
        // On teste si le retour est bien 200
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        // Et si la redirection pointe bien vers "lo_platform_recapitulatif"
        $this->assertSame("lo_platform_recapitulatif", $client->getRequest()->get("_route"));



    }

}