<?php 

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;
//use App\Service\Joker;

class SendJokeEvent extends Event 
{
    protected $data;

    public function __construct($formData)
    {
		$this->data = $formData;
    }

    public function getData(): ? array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;
        return $this;
    }
}
