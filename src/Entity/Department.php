<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Department extends BaseEntity
{
    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Employee::class)]
    private Collection $employee;

    #[ORM\ManyToMany(targetEntity: Employee::class)]
    #[ORM\JoinTable(name: 'department_managers')]
    private Collection $manager;

    public function __construct()
    {
        $this->employee = new ArrayCollection();
        $this->manager = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployee(): Collection
    {
        return $this->employee;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employee->contains($employee)) {
            $this->employee->add($employee);
            $employee->setDepartment($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employee->removeElement($employee)) {
            if ($employee->getDepartment() === $this) {
                $employee->setDepartment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getManager(): Collection
    {
        return $this->manager;
    }

    public function addManager(Employee $manager): self
    {
        if (!$this->manager->contains($manager)) {
            $this->manager->add($manager);
        }

        return $this;
    }

    public function removeManager(Employee $manager): self
    {
        $this->manager->removeElement($manager);

        return $this;
    }
}
