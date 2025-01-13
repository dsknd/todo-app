<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OWNER()
 * @method static static ADMIN()
 * @method static static MEMBER()
 */
final class ProjectRoles extends Enum
{
    const OWNER = 1;
    const ADMIN = 2;
    const MEMBER = 3;
}

