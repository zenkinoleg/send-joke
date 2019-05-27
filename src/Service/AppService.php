<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class AppService {

	protected $mailer;
	protected $fs;
	protected $logfile;

	public function __construct(\Swift_Mailer $mailer,Filesystem $fs) {
		$this->mailer = $mailer;
		$this->fs = $fs;
		// Filename should be out into ENV at some point
		$this->logfile = 'sent-jokes.csv';
	}

	public function endpointRequest($endpoint) {
		$headers = [
			'Content-Type' => 'application/json',
			'Accept' => 'application/json'
		];
		try {
			$client = new \GuzzleHttp\Client();
			$response = $client->request( 'GET', $endpoint, [ 'headers' => $headers ] );
			$content = $response->getBody()->getContents();
			$json = json_decode($response->getBody());
		} catch ( \Exception $e ) {
			throw new \Exception('External API loading problem: ' . $e->getMessage());
		}
		$data = isset($json->value) ? $json->value: [];
		return $data;
	}

	public function sendJoke($to,$category,$body) {
		$message = (new \Swift_Message('Random joke from `'.$category.'`'))
			// Sender email should be out into ENV at some point
	        ->setFrom('chuck.the.great@gmail.com')
    	    ->setTo($to)
        	->setBody(
				$body,
	            'text/html'
	        );
		try {
			$this->mailer->send($message);
		} catch (\ Exception $e) {
			throw new \Exception('Email sending problem: ' . $e->getMessage());
		}
	}

	public function updateLog($email,$category,$joke) {
		if ( !$this->fs->exists($this->logfile) ) {
			$this->fs->appendToFile($this->logfile, 'date,category,email,joke'.PHP_EOL);
		}
		$str = implode([
				date('Y-m-d h:i:s',time()),
				$category,
				$email,
				'"'.$joke.'"'
			],
			','
		);
		$this->fs->appendToFile($this->logfile, $str.PHP_EOL);
	}
}
