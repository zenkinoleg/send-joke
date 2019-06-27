<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Service\Joker;
use App\Event\SendJokeEvent;

class IndexController extends AbstractController
{
    public function index(Request $request, Joker $joker,EventDispatcherInterface $eventDispatcher)
    {
        $categories = $joker->getCategories();

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('index'))
            ->setMethod('GET')
            ->add('email', EmailType::class)
            ->add('category', ChoiceType::class, [
                'choices' => array_combine($categories, $categories)
            ])
            ->add('send', SubmitType::class, ['label' => 'Send Email'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
	        $eventDispatcher->dispatch(
				'send.joke',
				new SendJokeEvent($form->getData())
			);
//_prnt(2,1);
/*
            $data = (object) $form->getData();
            $joke = $joker->getJoke($data->category);
            $joker->sendJoke($data->email, $data->category, $joke);
            $joker->saveJoke($data->email, $data->category, $joke);
*/
            return $this->redirectToRoute('index');
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
