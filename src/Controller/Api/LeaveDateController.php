<?php

namespace App\Controller\Api;

use App\Entity\LeaveDate;
use App\Request\BaseLeaveDateRequest;
use App\Request\LeaveDateRequest;
use App\Service\LeaveDateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Throwable;

#[Route('/admin/leave-date', name: 'leave_date')]
#[IsGranted('ROLE_ADMINISTRATION')]
class LeaveDateController extends AbstractController
{
    #[Route('/new', name: '_new', methods: ['POST'])]
    public function new(BaseLeaveDateRequest $request, LeaveDateService $leaveDateService): JsonResponse
    {
        try {
            $leaveDate = $leaveDateService->createLeaveDate($request);
        } catch (Throwable $exception) {
            return $this->json(
                [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode()
                ]
            );
        }

        return $this->json(
            ['payload' => $leaveDate->serialize(), 'code' => Response::HTTP_CREATED],
            Response::HTTP_CREATED,
        );
    }

    #[Route('/{id}/edit', name: '_edit', methods: ['PUT'])]
    public function edit(LeaveDateRequest $request, LeaveDate $leaveDate, LeaveDateService $leaveDateService): Response
    {
        try {
            $leaveDate = $leaveDateService->editLeaveDate($leaveDate, $request);
        } catch (Throwable $exception) {
            return $this->json(
                [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode()
                ]
            );
        }

        return $this->json(
            ['payload' => $leaveDate->serialize(), 'code' => Response::HTTP_OK],
            Response::HTTP_OK,
        );
    }

    #[Route('/{id}', name: '_delete', methods: ['DELETE'])]
    public function delete(LeaveDate $leaveDate, LeaveDateService $leaveDateService): Response
    {
        try {
            $leaveDate = $leaveDateService->deleteLeaveDate($leaveDate);
        } catch (Throwable $exception) {
            return $this->json(
                [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode()
                ]
            );
        }

        return $this->json(
            ['payload' => $leaveDate->serialize(), 'code' => Response::HTTP_OK],
            Response::HTTP_OK,
        );
    }
}