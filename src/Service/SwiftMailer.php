<?php

namespace App\Service;

use App\Entity\Mailer;

class SwiftMailer extends Mailer
{

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Prepeare Message object from array
     *
     * @param array $messageArray
     * @return object
    */
    public function prepareMessage(array $messageArray) : object
    {
        $m = (object) $messageArray;
        $message = (new \Swift_Message())
            ->setSubject($m->subject)
            ->setFrom('chuck.the.great@gmail.com')
            ->setTo($m->to)
            ->setBody(
                $m->body,
                'text/html'
            );
        return $message;
    }
}
