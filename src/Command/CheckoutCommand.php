<?php

namespace App\Command;

use App\Form\Goods;
use App\Service\CalculatableItemsDtoFactory;
use App\Service\CheckoutHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(name: 'app:checkout')]
class CheckoutCommand extends Command
{
    private ValidatorInterface $validator;
    private CalculatableItemsDtoFactory $calculatableItemsDtoFactory;
    private CheckoutHandler $checkoutHandler;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ValidatorInterface $validator,
        CalculatableItemsDtoFactory $calculatableItemsDtoFactory,
        CheckoutHandler $checkoutHandler,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct();

        $this->validator = $validator;
        $this->calculatableItemsDtoFactory = $calculatableItemsDtoFactory;
        $this->checkoutHandler = $checkoutHandler;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you checkout provided groceries');

        $this->addArgument('list', InputArgument::REQUIRED, 'List of groceries');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $groceriesList = $input->getArgument('list');

        $goods = new Goods();
        $goods->setGoods($groceriesList);

        $errors = $this->validator->validate($goods);

        if (count($errors) > 0) {
            for ($i = 0; $i < $errors->count(); $i++) {
                $violation = $errors->get($i);
                $output->writeln($violation->getMessage());
            }
            return Command::FAILURE;
        }

        $calculatableItemsDto = $this->calculatableItemsDtoFactory->build($goods->getGoodsAsArray());
        $receipt = $this->checkoutHandler->handlePurchase($calculatableItemsDto);

        $this->entityManager->persist($receipt);
        $this->entityManager->flush();

        $output->writeln(sprintf('Total: %s', $receipt->getTotal()));

        return Command::SUCCESS;
    }
}
