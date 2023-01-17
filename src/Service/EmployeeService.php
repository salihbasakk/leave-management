<?php

namespace App\Service;

use App\Entity\Employee;
use App\Repository\DepartmentRepository;
use App\Repository\EmployeeRepository;
use App\Request\BaseEmployeeRequest;
use App\Request\EmployeeRequest;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use DateTime;

class EmployeeService
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private EmployeeRepository $employeeRepository;
    private DepartmentRepository $departmentRepository;

    public function __construct(
        UserPasswordHasherInterface $userPasswordHasher,
        EmployeeRepository          $employeeRepository,
        DepartmentRepository        $departmentRepository
    ) {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->employeeRepository = $employeeRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function createEmployee(EmployeeRequest $request): Employee
    {
        $employee = new Employee();

        $employee->setPassword($this->userPasswordHasher->hashPassword($employee, $request->password));

        return $this->saveEmployee($request, $employee);
    }

    public function editEmployee(Employee $employee, BaseEmployeeRequest $request): Employee
    {
        return $this->saveEmployee($request, $employee);
    }

    public function saveEmployee(BaseEmployeeRequest $request, Employee $employee): Employee
    {
        $employee->setName($request->name);
        $employee->setSurname($request->surname);
        $employee->setEmail($request->email);
        $employee->setStartDate(new DateTime($request->startDate));
        $employee->setIdentityNumber($request->identityNumber);
        $employee->setInsuranceNumber($request->insuranceNumber);
        $employee->setDepartment($this->departmentRepository->find($request->departmentId));
        $employee->setRoles($request->roles ?: Employee::ROLE_EMPLOYEE);

        $this->employeeRepository->save($employee, true);

        return $employee;
    }

    public function deleteEmployee(Employee $employee): Employee
    {
        $employee->setDeletedAt(new DateTime());

        $this->employeeRepository->save($employee, true);

        return $employee;
    }
}