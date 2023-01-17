<?php

namespace App\Controller\Api;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use App\Request\BaseEmployeeRequest;
use App\Request\EmployeeRequest;
use App\Service\EmployeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Throwable;

#[Route('/admin/employee', name: 'employee')]
#[IsGranted('ROLE_ADMINISTRATION')]
class EmployeeController extends AbstractController
{
    #[Route('/', name: '_list', methods: ['GET'])]
    public function index(EmployeeRepository $employeeRepository): JsonResponse
    {
        try {
            $employees = $employeeRepository->findBy(['deletedAt' => null]);
        } catch (Throwable $exception) {
            return $this->json(
                [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode()
                ]
            );
        }

        return $this->json(
            [
                'payload' => array_map(function ($employee) {
                    return $employee->serialize();
                }, $employees),
                'code' => Response::HTTP_OK
            ],
            Response::HTTP_OK);
    }

    #[Route('/{id}', name: '_show', methods: ['GET'])]
    public function show(Employee $employee): JsonResponse
    {
        return $this->json(['payload' => $employee->serialize(), 'code' => Response::HTTP_OK]);
    }

    #[Route('/new', name: '_new', methods: ['POST'])]
    public function new(EmployeeRequest $request, EmployeeService $employeeService): JsonResponse
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

    #[Route('/{id}/edit', name: '_edit', methods: ['PUT'])]
    public function edit(BaseEmployeeRequest $request, Employee $employee, EmployeeService $employeeService): Response
    {
        try {
            $employee = $employeeService->editEmployee($employee, $request);
        } catch (Throwable $exception) {
            return $this->json(
                [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode()
                ]
            );
        }

        return $this->json(
            ['payload' => $employee->serialize(), 'code' => Response::HTTP_OK],
            Response::HTTP_OK,
        );
    }

    #[Route('/{id}', name: '_delete', methods: ['DELETE'])]
    public function delete(Employee $employee, EmployeeService $employeeService): Response
    {
        try {
            $employee = $employeeService->deleteEmployee($employee);
        } catch (Throwable $exception) {
            return $this->json(
                [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode()
                ]
            );
        }

        return $this->json(
            ['payload' => $employee->serialize(), 'code' => Response::HTTP_OK],
            Response::HTTP_OK,
        );
    }
}