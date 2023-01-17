<?php

namespace App\Entity;

use App\Repository\LeaveDateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

#[ORM\Entity(repositoryClass: LeaveDateRepository::class)]
#[ORM\Index(columns: ['start_date', 'end_date'], name: 'range_idx')]
#[ORM\HasLifecycleCallbacks]
class LeaveDate extends BaseEntity
{
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $startDate;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $endDate;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Status $status;

    #[ORM\ManyToOne(inversedBy: 'leaveDates')]
    #[ORM\JoinColumn(nullable: false)]
    private Employee $employee;

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return LeaveDate
     */
    public function setDescription(?string $description): LeaveDate
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getStartDate(): DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param DateTimeInterface $startDate
     * @return LeaveDate
     */
    public function setStartDate(DateTimeInterface $startDate): LeaveDate
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getEndDate(): DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @param DateTimeInterface $endDate
     * @return LeaveDate
     */
    public function setEndDate(DateTimeInterface $endDate): LeaveDate
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @param Status $status
     * @return LeaveDate
     */
    public function setStatus(Status $status): LeaveDate
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Employee
     */
    public function getEmployee(): Employee
    {
        return $this->employee;
    }

    /**
     * @param Employee $employee
     * @return LeaveDate
     */
    public function setEmployee(Employee $employee): LeaveDate
    {
        $this->employee = $employee;
        return $this;
    }
}
