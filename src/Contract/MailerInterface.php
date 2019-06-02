<?php

namespace App\Contract;

/**
 * Interface for Mailer
 */
interface MailerInterface
{
    /**
     * Method for clients to send email
     *
     * $messageArray = array (
     *  'from' => 'email@from.com'
     *  'to' => 'email@to.com'
     *  'subject' => 'Email subject'
     *  'body' => 'Hey this is a letter'
     *  'cc' => ''
     *  ... etc
     * )
     *
     * @param array $messageArray
     * @return void
     */
    public function send(array $messageArray) : void;

    /**
     * Method to prepeare Message for a specific Mailer
     * Return specific Malier Message Object
     *
     * @param array $messageArray
     * @return object
     */
//  public function prepareMessage(array $messageArray) : object;

    /**
     * Method actually sends email
     *
     * @param object $message
     * @return void
     * @throws \Exception
     */
//  public function sendEmail(object $message) : void;
}
