<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Permissions extends Enum
{
    const PROJECT_WILDCARD = 1;
    const PROJECT_READ = 2;
    const PROJECT_UPDATE = 3;
    const PROJECT_DELETE = 4;

    const PROJECT_TASKS_WILDCARD = 5;
    const PROJECT_TASKS_READ = 6;
    const PROJECT_TASKS_CREATE = 7;
    const PROJECT_TASKS_UPDATE = 8;
    const PROJECT_TASKS_DELETE = 9;

    const PROJECT_ROLES_WILDCARD = 10;
    const PROJECT_ROLES_READ = 11;
    const PROJECT_ROLES_CREATE = 12;
    const PROJECT_ROLES_UPDATE = 13;
    const PROJECT_ROLES_DELETE = 14;

    const PROJECT_MEMBERS_WILDCARD = 15;
    const PROJECT_MEMBERS_READ = 16;
    const PROJECT_MEMBERS_CREATE = 17;
    const PROJECT_MEMBERS_UPDATE = 18;
    const PROJECT_MEMBERS_DELETE = 19;
    
    const PROJECT_INVITATIONS_WILDCARD = 20;
    const PROJECT_INVITATIONS_READ = 21;
    const PROJECT_INVITATIONS_CREATE = 22;
    const PROJECT_INVITATIONS_UPDATE = 23;
    const PROJECT_INVITATIONS_DELETE = 24;
}

