<?php

namespace App\Controller;

use App\Form\Goods;
use App\Form\Type\GoodsType;
use App\Service\CalculatableItemsDtoFactory;
use App\Service\CheckoutHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private CalculatableItemsDtoFactory $calculatableItemsDtoFactory;
    private CheckoutHandler $checkoutHandler;

    public function __construct(
        EntityManagerInterface $entityManager,
        CalculatableItemsDtoFactory $calculatableItemsDtoFactory,
        CheckoutHandler $checkoutHandler
    ) {
        $this->entityManager = $entityManager;
        $this->calculatableItemsDtoFactory = $calculatableItemsDtoFactory;
        $this->checkoutHandler = $checkoutHandler;
    }

    #[Route('/', name: 'index')]
    public function show(Request $request): Response
    {
        $receipt = '';
        $form = $this->createForm(GoodsType::class, new Goods);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calculatableItemsDto = $this->calculatableItemsDtoFactory->build($form->getData()->getGoodsAsArray());
            $receipt = $this->checkoutHandler->handlePurchase($calculatableItemsDto);

            $this->entityManager->persist($receipt);
            $this->entityManager->flush();
        }


        return $this->render('checkout.html.twig', [
            'form' => $form,
            'receipt' => $receipt
        ]);
    }
}
