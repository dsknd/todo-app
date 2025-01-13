<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static DEFAULT()
 * @method static static CUSTOM()
 */
final class ProjectRoleTypes extends Enum
{
    const DEFAULT = 1;
    const CUSTOM = 2;
}

