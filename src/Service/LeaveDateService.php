<?php

namespace App\Service;
use App\Entity\LeaveDate;
use App\Entity\Status;
use App\Repository\EmployeeRepository;
use App\Repository\LeaveDateRepository;
use App\Repository\StatusRepository;
use App\Request\BaseLeaveDateRequest;
use App\Request\LeaveDateRequest;
use DateTime;

class LeaveDateService
{
    private LeaveDateRepository $leaveDateRepository;
    private StatusRepository $statusRepository;
    private EmployeeRepository $employeeRepository;

    public function __construct(
        LeaveDateRepository $leaveDateRepository,
        StatusRepository    $statusRepository,
        EmployeeRepository  $employeeRepository
    ) {
        $this->leaveDateRepository = $leaveDateRepository;
        $this->statusRepository = $statusRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function createLeaveDate(BaseLeaveDateRequest $request): LeaveDate
    {
        $leaveDate = new LeaveDate();

        $leaveDate->setStatus($this->statusRepository->findOneBy(['name' => Status::STATUS_APPROVED]));

        return $this->saveLeaveDate($request, $leaveDate);
    }

    public function editLeaveDate(LeaveDate $leaveDate, LeaveDateRequest $request): LeaveDate
    {
        $leaveDate->setStatus($this->statusRepository->findOneBy(['id' => $request->statusId]));

        return $this->saveLeaveDate($request, $leaveDate);
    }

    public function saveLeaveDate(BaseLeaveDateRequest $request, LeaveDate $leaveDate): LeaveDate
    {
        $leaveDate->setStartDate(new DateTime($request->startDate));
        $leaveDate->setEndDate(new DateTime($request->endDate));
        $leaveDate->setEmployee($this->employeeRepository->findOneBy(['id' => $request->employeeId]));

        $this->leaveDateRepository->save($leaveDate, true);

        return $leaveDate;
    }

    public function deleteLeaveDate(LeaveDate $leaveDate): LeaveDate
    {
        $leaveDate->setDeletedAt(new DateTime());

        $this->leaveDateRepository->save($leaveDate, true);

        return $leaveDate;
    }
}