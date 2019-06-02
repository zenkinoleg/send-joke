<?php

namespace App\Entity;

use App\Contract\MailerInterface;

class Mailer implements MailerInterface
{

    /**
     * Must be init by implementing class via constructor
    */
    protected $mailer;

    /**
     * Client method
     * Not supposed to be overriden
     *
     * @param array $messageArray
     * @return void
    */
    public function send(array $messageArray) : void
    {
        $this->sendEmail(
            $this->prepareMessage($messageArray)
        );
    }

    /**
     * Prepare a message for sending
     * Supposed to be overriden by implementing class
     *
     * @param array $messageArray
     * @return object
    */
    public function prepareMessage(array $messageArray) : object
    {
        return (object) $messageArray;
    }

    /**
     * Actual email sending
     *
     * @param object $message
     * @return void
    */
    private function sendEmail(object $message) : void
    {
        try {
            $this->mailer->send($message);
        } catch (\ Exception $e) {
            throw new \Exception('Email sending problem: ' . $e->getMessage());
        }
    }
}
