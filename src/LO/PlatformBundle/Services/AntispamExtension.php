<?php
// src/LO/PlatformBundle/Services/AntispamExtension.php

namespace LO\PlatformBundle\Services;

use LO\PlatformBundle\Services\LOAntispam;

class AntispamExtension extends \Twig_Extension
{
    /**
     * @var LOAntispam
     */
    private $loAntispam;

    public function __construct(LOAntispam $loAntispam)
    {
        $this->LOAntispam = $loAntispam;
    }

    public function checkIfArgumentIsSpam($text)
    {
        return $this->loAntispam->isSpam($text);
    }


    // Twig va exécuter cette méthode pour savoir quelle(s) fonction(s) ajoute notre service
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('checkIfSpam', array($this, 'checkIfArgumentIsSpam')),
        );
    }


    // La méthode getName() identifie votre extension Twig, elle est obligatoire
    public function getName()
    {
        return 'LOAntispam';
    }
}