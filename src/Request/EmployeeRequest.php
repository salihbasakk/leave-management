<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

class EmployeeRequest extends BaseRequest
{
    #[Assert\Email(message: 'The email {{ value }} is not a valid email.')]
    #[NotBlank]
    public string $email;

    #[Assert\Length(
        min: 6,
        max: 4096,
        minMessage: 'Your password must be at least {{ limit }} characters long',
        maxMessage: 'Your password cannot be longer than {{ limit }} characters',
    )]
    #[NotBlank]
    public string $password;

    #[Assert\Length(
        min: 1,
        max: 150,
        minMessage: 'Your name must be at least {{ limit }} characters long',
        maxMessage: 'Your name cannot be longer than {{ limit }} characters',
    )]
    #[NotBlank]
    public string $name;

    #[Assert\Length(
        min: 1,
        max: 150,
        minMessage: 'Your surname must be at least {{ limit }} characters long',
        maxMessage: 'Your surname cannot be longer than {{ limit }} characters',
    )]
    #[NotBlank]
    public string $surname;

    #[Assert\Length(
        min: 11,
        max: 11,
        minMessage: 'Your identityNumber must be at least {{ limit }} characters long',
        maxMessage: 'Your identityNumber cannot be longer than {{ limit }} characters',
    )]
    #[NotBlank]
    public int $identityNumber;

    #[Assert\Length(
        min: 13,
        max: 13,
        minMessage: 'Your insuranceNumber must be at least {{ limit }} characters long',
        maxMessage: 'Your insuranceNumber cannot be longer than {{ limit }} characters',
    )]
    #[NotBlank]
    public int $insuranceNumber;

    /**
     * @var string A "Y-m-d H:i:s" formatted value
     */
    #[Assert\DateTime]
    #[NotBlank]
    public string $startDate;

    /**
     * @var string|null "Y-m-d H:i:s" formatted value
     */
    #[Assert\DateTime]
    public ?string $dismissalDate;

    #[Assert\Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    public ?int $departmentId;

    public ?array $roles;
}