<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Personal()
 * @method static static Project()
 */
final class TaskTypes extends Enum
{
    const Personal = 1;
    const Project = 2;
}
