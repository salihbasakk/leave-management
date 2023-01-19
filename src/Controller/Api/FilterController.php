<?php

namespace App\Controller\Api;

use App\Helpers\TimeUrlDecoder;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Throwable;

#[Route('/admin/filter', name: 'filter')]
#[IsGranted('ROLE_ADMINISTRATION')]
class FilterController extends AbstractController
{
    #[Route('/employee/{name}/{startDate}/{endDate}/{inLeave}',
        name: '_list',
        methods: ['GET'])
    ]
    public function index(string $name, string $startDate, string $endDate, bool $inLeave, EmployeeRepository $employeeRepository): JsonResponse
    {
        try {
            $employees = $employeeRepository->filter(
                $name,
                TimeUrlDecoder::decode($startDate),
                TimeUrlDecoder::decode($endDate),
                $inLeave
            );
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
                'payload' => $employees,
                'code' => Response::HTTP_OK
            ],
            Response::HTTP_OK);
    }
}