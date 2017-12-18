<?php

namespace LO\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="LO\PlatformBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateVisited", type="date")
	 *
	 * @Assert\DateTime()
     */
    private $dateVisited;



    /**
     * @var string
     *
     * @ORM\Column(name="amountPaid", type="decimal", precision=10, scale=2, nullable=true)
	 *
	 * @Assert\GreaterThan(value = 0, message ="Le prix doit être supérieur à 0")
	 *
	 * @Assert\Currency
     */
    private $amountPaid;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     *
     * @Assert\Email
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="codeCommande", type="string", length=255, unique=true, nullable=true)
     */
    private $codeCommande;

    /**
     * @var bool
     *
     * @ORM\Column(name="isDay", type="boolean")
     */
    private $isDay;

    /**
     * @ORM\OneToMany(targetEntity="LO\PlatformBundle\Entity\Billet" , mappedBy="commande", cascade={"persist"})
     */
    private $billets;


    public function __construct()
    {
        // Par défaut, la date de l'annonce est la date d'aujourd'hui
        $this->dateReservation = new \Datetime();
        $this->billets = new ArrayCollection();
    }

    public function addBillet(Billet $billet)
    {
        dump($billet);
        $this->billets->add($billet);
    }


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateReservation", type="datetime")
     */
    private $dateReservation;


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
     * @return mixed
     */
    public function getBillets()
    {
        return $this->billets;
    }

    /**
     * @param mixed $billets
     * @return Commande
     */
    public function setBillets($billets)
    {
        $this->billets = $billets;
        return $this;
    }



    /**
     * Set dateVisited
     *
     * @param \DateTime $dateVisited
     *
     * @return Commande
     */
    public function setDateVisited($dateVisited)
    {
        $this->dateVisited = $dateVisited;

        return $this;
    }

    /**
     * Get dateVisited
     *
     * @return \DateTime
     */
    public function getDateVisited()
    {
        return $this->dateVisited;
    }


    /**
     * Set amountPaid
     *
     * @param string $amountPaid
     *
     * @return Commande
     */
    public function setAmountPaid($amountPaid)
    {
        $this->amountPaid = $amountPaid;

        return $this;
    }

    /**
     * Get amountPaid
     *
     * @return string
     */
    public function getAmountPaid()
    {
        return $this->amountPaid;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Commande
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set codeCommande
     *
     * @param string $codeCommande
     *
     * @return Commande
     */
    public function setCodeCommande()
    {
        $codeCommandeUnique = uniquid();
        $this->codeCommande = $codeCommandeUnique;

        return $this;
    }

    /**
     * Get codeCommande
     *
     * @return string
     */
    public function getCodeCommande()
    {
        return $this->codeCommande;
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

    /**
     * Set dateReservation
     *
     * @param \DateTime $dateReservation
     *
     * @return Commande
     */
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    /**
     * Get dateReservation
     *
     * @return \DateTime
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }
}

