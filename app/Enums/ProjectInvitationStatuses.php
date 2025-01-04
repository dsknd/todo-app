<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ProjectInvitationStatuses extends Enum
{
    const PENDING = 1;
    const ACCEPTED = 2;
    const DECLINED = 3;
}
