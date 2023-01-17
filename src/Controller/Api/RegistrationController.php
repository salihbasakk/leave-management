<?php

namespace App\Controller\Api;

use App\Request\EmployeeRequest;
use App\Service\EmployeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(EmployeeRequest $request, EmployeeService $employeeService): JsonResponse
    {
        try {
            $employee = $employeeService->createEmployee($request);
        } catch (Throwable $exception) {
            return $this->json(
                [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode()
                ]
            );
        }

        return $this->json(
            ['payload' => $employee->serialize(), 'code' => Response::HTTP_CREATED],
            Response::HTTP_CREATED,
        );
    }
}
