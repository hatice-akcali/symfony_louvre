<?php

namespace LO\PlatformBundle\Entity;

use LO\PlatformBundle\Entity\Commande;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Billet
 *
 * @ORM\Table(name="billet")
 * @ORM\Entity(repositoryClass="LO\PlatformBundle\Repository\BilletRepository")
 */
class Billet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
	 *
	 * @Assert\Length(
     *              min=3,
     *              max = 50,
     *              minMessage = "Votre nom ne peut faire moins de {{ limit }} caractères.",
     *              maxMessage = "Votre nom ne peut faire plus de {{ limit }} caractères.")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     *
     * @Assert\Length(
     *              min=3,
     *              max = 50,
     *              minMessage = "Votre nom ne peut faire moins de {{ limit }} caractères.",
     *              maxMessage = "Votre nom ne peut faire plus de {{ limit }} caractères.")
     */
    private $firstname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date")
	 *
	 * @Assert\LessThan("today", message = "merci de vérifier la date de naissance")
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="reducedPrice", type="boolean", options={"default":false})
     *
     */
    private $reducedPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;







    /**
     * @var Commande
     *
     * -- Contraintes de validations
     * @Assert\Valid()
     * @Assert\Type(type="LO\PlatformBundle\Entity\Commande")
     *
     * -- Liaison unidirectionnelle entre Billet et Commande
     * @ORM\ManyToOne(targetEntity="LO\PlatformBundle\Entity\Commande", inversedBy="billets", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable = false)
     *
     */
    private $commande;

    /**
     * @return Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param Commande $commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Billet
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Billet
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Billet
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set reducedPrice
     *
     * @param string $reducedPrice
     *
     * @return Billet
     */
    public function setReducedPrice($reducedPrice)
    {
        $this->reducedPrice = $reducedPrice;

        return $this;
    }

    /**
     * Get reducedPrice
     *
     * @return string
     */
    public function getReducedPrice()
    {
        return $this->reducedPrice;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Commande
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }






}

