<?php

namespace App\Controller;

use App\Form\OrderType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @Route("/commande", name="order")
     */
    public function index(): Response
    {
        // verifie si l'utilisateur a deja une adresse engeristrer sinon redirige
        if (!$this->getUser()->getAddresses()->getValues()) {
            
            return  $this->redirectToRoute( 'account_address_add');
        }

        // 'user' => $this->getUser() passe l'utilisateur en session au form 

        $form = $this->createForm( OrderType::class, null, [
            'user' => $this->getUser()
        ]);
    
        return $this->render('order/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
