<?php
// src/LO/PlatformBundle/Services/LOAntispam.php

namespace LO\PlatformBundle\Services;

class LOAntispam
{
    private $mailer;
    private $locale;
    private $minLength;

    public function __construct(\Swift_Mailer $mailer, $minLength)
    {
        $this->mailer    = $mailer;
        $this->minLength = (int) $minLength;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    // …
}