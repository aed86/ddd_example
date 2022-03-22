<?php

namespace App\Shared\Http;

use JetBrains\PhpStorm\Pure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class BaseController extends AbstractController
{
    protected function badRequest(string $message, ?ConstraintViolationListInterface $errors = null): Response
    {
        $data = [
            'success' => false,
            'error' => $message,
        ];

        if ($errors !== null) {
            $data['validationError'] = $this->getValidationErrors($errors);
        }

        return $this->json(
            $data,
            400,
        );
    }

    private function getValidationErrors(ConstraintViolationListInterface $errors): array {
        $constraints = [];
        /** @var \Symfony\Component\Validator\ConstraintViolation $error */
        foreach ($errors as $error) {
            $constraints[$error->getPropertyPath()] = $error->getMessage();
        }

        return $constraints;
    }
}
