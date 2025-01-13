<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pending()
 * @method static static InProgress()
 * @method static static Completed()
 * @method static static OnHold()
 * @method static static Cancelled()
 */
final class ProjectStatuses extends Enum
{
    const PENDING = 1;
    const IN_PROGRESS = 2;
    const COMPLETED = 3;
    const ON_HOLD = 4;
    const CANCELLED = 5;
}

