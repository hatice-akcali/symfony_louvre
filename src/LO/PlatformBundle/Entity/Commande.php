<?php

namespace LO\PlatformBundle\Entity;

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
     * @var int
     *
     * @ORM\Column(name="numberVisitor", type="integer")
     *
     * @Assert\GreaterThan(value = 1)
     */
    private $numberVisitor;

    /**
     * @var string
     *
     * @ORM\Column(name="amountPaid", type="decimal", precision=10, scale=2)
	 *
	 * @Assert\GreaterThan(value = 0, message ="Le prix doit être supérieur à 0")
	 *
	 * @Assert\NotBlank(message="Le prix est obligatoire")
     */
    private $amountPaid;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="codeCommande", type="string", length=255, unique=true)
     */
    private $codeCommande;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

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
     * Set numberVisitor
     *
     * @param integer $numberVisitor
     *
     * @return Commande
     */
    public function setNumberVisitor($numberVisitor)
    {
        $this->numberVisitor = $numberVisitor;

        return $this;
    }

    /**
     * Get numberVisitor
     *
     * @return int
     */
    public function getNumberVisitor()
    {
        return $this->numberVisitor;
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
    public function setCodeCommande($codeCommande)
    {
        $this->codeCommande = $codeCommande;

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

