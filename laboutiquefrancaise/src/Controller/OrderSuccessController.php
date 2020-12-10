<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderSuccessController extends AbstractController
{
    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index(Cart $cart, $stripeSessionId, EntityManagerInterface $entityManager): Response
    {

        $order = $entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

     

        if (!$order->getIsPaid()) {
            
            // vider la session cart

            $cart->remove();


            // modifier le statut is paid a 1

            $order->setIsPaid(1);
            $entityManager->flush();

             // envoyer un email à notr client 
        }

       
        
        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}
