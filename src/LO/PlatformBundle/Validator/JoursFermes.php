<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 07/01/2018
 * Time: 14:23
 */

namespace LO\PlatformBundle\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class JoursFermes extends Constraint
{

    public $messageJourFerie = "Le musée est fermé ce-jour-ci";
    public $messageMardi = "Le musée est fermé le mardi";
    public $messageJourPrecedent = "Vous ne pouvez pas réserver pour une date antérieure";


    public function validatedBy()
    {
        return "joursFeries_validator";
    }
}