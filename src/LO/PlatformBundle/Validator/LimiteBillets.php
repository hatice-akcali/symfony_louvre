<?php

namespace LO\PlatformBundle\Validator;

use Symfony\Component\Validator\Constraint ;

/**
 * @Annotation
 */
class LimiteBillets extends Constraint
{
    public $message = " Il ne reste plus que %nbBilletsRestants% billet(s).";

    public function validatedBy()
    {
        return "limiteBillet_validator";
    }
}

