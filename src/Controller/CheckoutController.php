<?php

namespace App\Controller;

use App\Form\Goods;
use App\Form\Type\GoodsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'checkout')]
    public function show(Request $request): Response
    {
        $form = $this->createForm(GoodsType::class, new Goods);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }

        return $this->render('checkout.html.twig', [
            'form' => $form,
        ]);
    }
}