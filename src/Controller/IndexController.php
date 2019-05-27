<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Service\AppService;

class IndexController extends AbstractController
{
	protected $service;

	public function __construct(AppService $service) {
		$this->service = $service;
	}

    public function index(Request $request) {
		// Result must be cached
		// URL should be out into ENV at some point
		$categories = $this->service->endpointRequest('http://api.icndb.com/categories');

	    $form = $this->createFormBuilder()
			->setAction($this->generateUrl('index'))
			->setMethod('GET')
        	->add('email', EmailType::class)
			->add('category', ChoiceType::class, [
				'choices' => array_combine($categories,$categories)
			])
	        ->add('send', SubmitType::class, ['label' => 'Send Email'])
    	    ->getForm();

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();
			// URL should be out into ENV at some point
			$response = $this->service->endpointRequest('http://api.icndb.com/jokes/random?limitTo=['.$data['category'].']');
			$this->service->sendJoke(
				$data['email'],
				$data['category'],
				$response->joke
			);
			$this->service->updateLog(
				$data['email'],
				$data['category'],
				$response->joke
			);
	        return $this->redirectToRoute('index');
		}

		return $this->render('index.html.twig', [
    	    'form' => $form->createView(),
	    ]);
    }
}
