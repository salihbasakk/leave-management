<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

class BaseLeaveDateRequest extends BaseRequest
{
    #[Assert\Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    public ?int $employeeId;

    /**
     * @var string A "Y-m-d H:i:s" formatted value
     */
    #[Assert\DateTime]
    #[NotBlank]
    public string $startDate;

    /**
     * @var string "Y-m-d H:i:s" formatted value
     */
    #[Assert\DateTime]
    #[Assert\GreaterThan(propertyPath: 'startDate')]
    #[NotBlank]
    public string $endDate;

    #[Assert\Type(
        type: 'string',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    public ?string $description;
}