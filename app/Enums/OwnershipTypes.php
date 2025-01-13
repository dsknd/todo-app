<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PERSONAL()
 * @method static static PROJECT()
 */
final class OwnershipTypes extends Enum
{
    const PERSONAL = 1;
    const PROJECT = 2;
}
