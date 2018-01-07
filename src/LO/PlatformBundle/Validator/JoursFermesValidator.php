<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 07/01/2018
 * Time: 14:34
 */

namespace LO\PlatformBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;


class JoursFermesValidator extends ConstraintValidator
{

    private $joursFeries;

    public function __construct( $joursFeries){
        $this->joursFeries = $joursFeries;


    }


    public function validate($valueDate, Constraint $constraint){
        // S'il s'agit d'un jour férié, violation
        $nouvelleValeurDate = $valueDate->format("d/m");
        if(in_array($nouvelleValeurDate, $this->joursFeries )){
            $this->context->addViolation($constraint->messageJourFerie);
        }

        // Si le jour de la semaine esr un mardi, on lance une violation.
        $numeroJourSemaine = $valueDate->format("w");
        if($numeroJourSemaine == 2){
            $this->context->addViolation(($constraint->messageMardi));
        }


        // Si la date est antérieure à la date du jour, violation.
        $today = new \DateTime();

        if($valueDate < $today){
            $this->context->addViolation(($constraint->messageJourPrecedent));

        }
    }
}