<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\ManagementWorkingHours;

final class  ManagementWorkingHoursCreated
{
    private ManagementWorkingHours $managementWorkingHours;

    public function __construct(ManagementWorkingHours $managementWorkingHours)
    {
        $this->managementWorkingHours = $managementWorkingHours;
    }

    public function getManagementWorkingHours(): ManagementWorkingHours
    {
        return $this->managementWorkingHours;
    }
}
