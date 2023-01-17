<?php

namespace App\Service;

use App\Entity\Department;
use App\Entity\Employee;
use App\Request\BaseRequest;
use App\Request\EditEmployeeRequest;
use App\Request\EmployeeRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use DateTime;

class EmployeeService
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function createEmployee(EmployeeRequest $request): Employee
    {
        $employee = new Employee();

        $employee->setPassword($this->userPasswordHasher->hashPassword($employee, $request->password));

        return $this->saveEmployee($request, $employee);
    }

    public function editEmployee(Employee $employee, EditEmployeeRequest $request): Employee
    {
        return $this->saveEmployee($request, $employee);
    }

    public function saveEmployee(BaseRequest $request, Employee $employee): Employee
    {
        $employee->setName($request->name);
        $employee->setSurname($request->surname);
        $employee->setEmail($request->email);
        $employee->setStartDate(new DateTime($request->startDate));
        $employee->setIdentityNumber($request->identityNumber);
        $employee->setInsuranceNumber($request->insuranceNumber);
        $employee->setDepartment($this->entityManager->getRepository(Department::class)->find($request->departmentId));
        $employee->setRoles($request->roles ?: Employee::ROLE_EMPLOYEE);

        $this->entityManager->persist($employee);
        $this->entityManager->flush();

        return $employee;
    }

    public function deleteEmployee(Employee $employee): Employee
    {
        $employee->setDeletedAt(new DateTime());

        $this->entityManager->persist($employee);
        $this->entityManager->flush();

        return $employee;
    }
}