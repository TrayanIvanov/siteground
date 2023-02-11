<?php

namespace App\Controller;

use App\Form\Goods;
use App\Form\Type\GoodsType;
use App\Repository\ProductRepository;
use App\Repository\PromotionRepository;
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
    private ProductRepository $productRepository;
    private PromotionRepository $promotionRepository;
    private CalculatableItemsDtoFactory $calculatableItemsDtoFactory;
    private CheckoutHandler $checkoutHandler;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository,
        PromotionRepository $promotionRepository,
        CalculatableItemsDtoFactory $calculatableItemsDtoFactory,
        CheckoutHandler $checkoutHandler
    ) {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
        $this->promotionRepository = $promotionRepository;
        $this->calculatableItemsDtoFactory = $calculatableItemsDtoFactory;
        $this->checkoutHandler = $checkoutHandler;
    }

    #[Route('/', name: 'index')]
    public function show(Request $request): Response
    {
        $receipt = '';
        $products = $this->productRepository->findAll();
        $promotions = $this->promotionRepository->findAll();

        $form = $this->createForm(GoodsType::class, new Goods);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calculatableItemsDto = $this->calculatableItemsDtoFactory->build($form->getData()->getGoodsAsArray());
            $receipt = $this->checkoutHandler->handlePurchase($calculatableItemsDto);

            $this->entityManager->persist($receipt);
            $this->entityManager->flush();
        }

        return $this->render('checkout.html.twig', [
            'availableProducts' => $products,
            'availablePromotions' => $promotions,
            'form' => $form,
            'receipt' => $receipt,
        ]);
    }
}
