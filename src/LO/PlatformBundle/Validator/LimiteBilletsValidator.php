<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 02/01/2018
 * Time: 12:23
 */

namespace LO\PlatformBundle\Validator;

use LO\PlatformBundle\Entity\Commande;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;

class LimiteBilletsValidator extends ConstraintValidator
{
    private $em ;


    public function __construct(EntityManager $entityManager){
        $this->em = $entityManager;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($valueDate, Constraint $constraint)
    {
        $commandes = $this->em->getRepository(Commande::class)->findByDateVisited($valueDate);

        $compteur = 1000;

        foreach($commandes as $commande){
            $compteur -= count($commande->getBillets());


        }

        $commandeEnCours = $this->context->getRoot()->getData();
        $nbBilletsEnCours = count($commandeEnCours->getBillets());

        if($compteur < $nbBilletsEnCours){
            $this->context
                ->buildViolation($constraint->message)
                ->setParameters(array('%nbBilletsRestants%' => $compteur))
                ->addViolation();

        }


    }






}

