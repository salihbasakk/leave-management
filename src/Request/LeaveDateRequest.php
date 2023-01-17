<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class LeaveDateRequest extends BaseLeaveDateRequest
{
    #[Assert\Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    #[Assert\NotBlank]
    public int $statusId;
}