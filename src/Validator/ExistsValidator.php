<?php

namespace App\Validator;

use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ExistsValidator extends ConstraintValidator
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof Exists) {
            throw new UnexpectedTypeException($constraint, Exists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $chars = array_unique(str_split($value));

        $missingProducts = [];
        foreach ($chars as $char) {
            $product = $this->productRepository->findOneBy(['sku' => $char]);
            if ($product === null) {
                $missingProducts[] = $char;
            }
        }

        if (count($missingProducts) > 0) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', implode(', ', $missingProducts))
                ->addViolation();
        }
    }
}
