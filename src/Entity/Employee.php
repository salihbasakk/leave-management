<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTimeInterface;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ORM\Index(columns: ['name', 'surname'], name: 'name_idx', flags: ['fulltext'])]
#[ORM\Index(columns: ['department_id'], name: 'department_idx')]
class Employee extends BaseEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 150, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 150)]
    private string $name;

    #[ORM\Column(length: 150)]
    private string $surname;

    #[ORM\Column(type: Types::BIGINT)]
    private string $identityNumber;

    #[ORM\Column(type: Types::BIGINT)]
    private string $insuranceNumber;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected DateTimeInterface $startDate;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected ?DateTimeInterface $dismissalDate = null;

    #[ORM\ManyToOne(inversedBy: 'employee')]
    #[ORM\JoinColumn(name: 'department_id')]
    private ?Department $department = null;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: LeaveDate::class, orphanRemoval: true)]
    private Collection $leaveDates;

    public function __construct()
    {
        $this->leaveDates = new ArrayCollection();
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_EMPLOYEE';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Employee
     */
    public function setEmail(?string $email): Employee
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Employee
     */
    public function setName(string $name): Employee
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return Employee
     */
    public function setSurname(string $surname): Employee
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentityNumber(): string
    {
        return $this->identityNumber;
    }

    /**
     * @param string $identityNumber
     * @return Employee
     */
    public function setIdentityNumber(string $identityNumber): Employee
    {
        $this->identityNumber = $identityNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsuranceNumber(): string
    {
        return $this->insuranceNumber;
    }

    /**
     * @param string $insuranceNumber
     * @return Employee
     */
    public function setInsuranceNumber(string $insuranceNumber): Employee
    {
        $this->insuranceNumber = $insuranceNumber;
        return $this;
    }

    /**
     * @return Department|null
     */
    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    /**
     * @param Department|null $department
     * @return Employee
     */
    public function setDepartment(?Department $department): Employee
    {
        $this->department = $department;
        return $this;
    }

    /**
     * @return Collection<int, LeaveDate>
     */
    public function getLeaveDates(): Collection
    {
        return $this->leaveDates;
    }

    public function addLeaveDate(LeaveDate $leaveDate): self
    {
        if (!$this->leaveDates->contains($leaveDate)) {
            $this->leaveDates->add($leaveDate);
            $leaveDate->setEmployee($this);
        }

        return $this;
    }

    public function removeLeaveDate(LeaveDate $leaveDate): self
    {
        if ($this->leaveDates->removeElement($leaveDate)) {
            // set the owning side to null (unless already changed)
            if ($leaveDate->getEmployee() === $this) {
                $leaveDate->setEmployee(null);
            }
        }

        return $this;
    }
}
