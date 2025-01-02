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
final class ProjectStatus extends Enum
{
    const Pending = 1;
    const InProgress = 2;
    const Completed = 3;
    const OnHold = 4;
    const Cancelled = 5;
}
