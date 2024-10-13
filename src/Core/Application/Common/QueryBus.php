<?php

declare(strict_types=1);

namespace App\Core\Application\Common;

use App\Core\Domain\Common\CollectionResponse;

interface QueryBus
{
    public function query(Query $query): CollectionResponse;
}