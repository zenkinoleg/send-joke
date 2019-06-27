<?php

namespace App\Event\Listener;

use Symfony\Component\EventDispatcher\Event;
use App\Service\Joker;
use App\Event\SendJokeEvent;

class SendJokeListener
{
	protected $joker;

	public function __construct(Joker $joker) {
		$this->joker = $joker;
	}

    /**
     * @param SendJokeEvent|Event $event
     * @return void
     */
    public function onSendJoke(Event $event): void
    {
		$data = (object) $event->getData();
		$joke = $this->joker->getJoke($data->category);
		$this->joker->sendJoke($data->email, $data->category, $joke);
		$this->joker->saveJoke($data->email, $data->category, $joke);
    }
}
