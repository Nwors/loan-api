<?php

declare(strict_types=1);

namespace App\Core\Domain\Common;

class DomainException extends \DomainException
{
    protected $message = 'exception.domain.entity_not_found';

    protected $code = 400;
}