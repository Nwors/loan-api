<?php

declare(strict_types=1);

namespace App\Core\Application\Common;

interface CommandBus
{
    public function execute(Command $command): void;
}