<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static NA()
 * @method static static SOFTWARE_DEVELOPMENT()
 * @method static static MARKETING()
 * @method static static RESEARCH()
 * @method static static OPERATIONS()
 */
final class Categories extends Enum
{
    const NA = 1;
    const SOFTWARE_DEVELOPMENT = 2;
    const MARKETING = 3;
    const RESEARCH = 4;
    const OPERATIONS = 5;
}
