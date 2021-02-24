<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Employ;

final class  EmployCreated
{
    private Employ $employ;

    public function __construct(Employ $employ)
    {
        $this->employ = $employ;
    }

    public function getEmploy(): Employ
    {
        return $this->employ;
    }
}
