<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

class EmployeeRequest extends BaseEmployeeRequest
{
    #[Assert\Length(
        min: 6,
        max: 4096,
        minMessage: 'Your password must be at least {{ limit }} characters long',
        maxMessage: 'Your password cannot be longer than {{ limit }} characters',
    )]
    #[NotBlank]
    public string $password;
}