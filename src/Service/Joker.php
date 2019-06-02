<?php

namespace App\Service;

/**
 * This class is a joke, since this is just a joke we
 * won't let it has repository or/and ORM of any kind
 * So we keep it simple and natural. We just don't
 * know yet what could it become either interface or
 * a factory class. So let it just be this simple way
 * So far so good
**/

class Joker
{
    private $mailer;
    private $caller;
    private $storage;

    public function __construct(
        SwiftMailer $mailer,
        GuzzleExternalCaller $caller,
        FileJokerStorage $storage
    ) {
        $this->mailer = $mailer;
        $this->caller = $caller;
        $this->storage = $storage;
    }

    /**
     * Get array of related categories
     *
     * @return array
    */
    public function getCategories() : array
    {
        $response = $this->caller->endpointGetRequest('http://api.icndb.com/categories');
        return (array) $this->caller->parseResponse($response);
    }

    /**
     * Get a joke from a specific category
     *
     * @param string $category
     * @return string
    */
    public function getJoke(string $category) : string
    {
        $response = $this->caller->endpointGetRequest('http://api.icndb.com/jokes/random?limitTo=['.$category.']');
        $item = $this->caller->parseResponse($response);
        return $item->joke;
    }

    /**
     * Send email with joke
     *
     * @param string $to
     * @param string $category
     * @param string $joke
     * @return void
    */
    public function sendJoke(string $to, string $category, string $joke) : void
    {
        $this->mailer->send([
            'to' => $to,
            'subject' => $category,
            'body' => $joke
        ]);
    }

    /**
     * Save joke
     *
     * @param string $to
     * @param string $category
     * @param string $joke
     * @return void
    */
    public function saveJoke(string $to, string $category, string $joke) : void
    {
        $this->storage->save(implode(
            [
                date('Y-m-d h:i:s', time()),
                $category,
                $to,
                '"'.$joke.'"'
            ],
            ','
        ));
    }
}
