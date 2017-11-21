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
	 * @Assert\Length(min=3)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     *
     * @Assert\Length(min=3)
     */
    private $firstname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date")
	 *
	 * @Assert\Date()
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="reducedPrice", type="string", length=255)
     */
    private $reducedPrice;

    /**
     * @var bool
     *
     * @ORM\Column(name="isDay", type="boolean")
     */
    private $isDay;





    /**
     * @var Commande
     *
    * -- Contraintes de validations
    * @Assert\Valid()
    * @Assert\Type(type="LO\PlatformBundle\Entity\Commande")
    *
    * -- Liaison unidirectionnelle entre Billet et Commande
    * @ORM\OneToOne(targetEntity="LO\PlatformBundle\Entity\Commande", cascade={"persist", "remove"})
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
     * Set isDay
     *
     * @param boolean $isDay
     *
     * @return Billet
     */
    public function setIsDay($isDay)
    {
        $this->isDay = $isDay;

        return $this;
    }

    /**
     * Get isDay
     *
     * @return bool
     */
    public function getIsDay()
    {
        return $this->isDay;
    }


}

