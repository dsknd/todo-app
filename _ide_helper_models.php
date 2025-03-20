<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $action
 * @property string $loggable_type
 * @property int $loggable_id
 * @property string|null $description
 * @property array<array-key, mixed>|null $details
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string $severity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $loggable
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereLoggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereLoggableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereUserId($value)
 */
	class AppLog extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property $id
 * @property string $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $childCategories
 * @property-read int|null $child_categories_count
 * @property-read Category|null $parentCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\ProjectRoleId $project_role_id
 * @property string $key
 * @property-read \App\Models\ProjectRole $projectRole
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DefaultProjectRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DefaultProjectRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DefaultProjectRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DefaultProjectRole whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DefaultProjectRole whereProjectRoleId($value)
 */
	class DefaultProjectRole extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectInvitation> $projectInvitations
 * @property-read int|null $project_invitations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationStatus whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationStatus whereUpdatedAt($value)
 */
	class InvitationStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $key システム内部キー
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectInvitation> $projectInvitations
 * @property-read int|null $project_invitations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationType whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvitationType whereUpdatedAt($value)
 */
	class InvitationType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\LocaleId $id
 * @property string $language_code 言語コード (ISO 639-1, e.g. "ja", "en")
 * @property string|null $region_code 地域コード (ISO 3166-1, e.g. "JP", "US")
 * @property string|null $script_code スクリプトコード (ISO 15924, e.g. "Latn", "Jpan")
 * @property string $format_bcp47 BCP47形式 (e.g. "ja-JP", "en-US")
 * @property string $format_cldr CLDR形式 (e.g. "ja_JP", "en_US")
 * @property string $format_posix POSIX形式 (e.g. "ja_JP.UTF-8", "en_US.UTF-8")
 * @property string $name ロケール名 (e.g. "日本語（日本）", "English (United States)")
 * @property string $native_name ネイティブ表記のロケール名 (e.g. "日本語（日本）", "English (United States)")
 * @property string $date_format_short 短い日付形式 (e.g. "Y/m/d", "n/j/Y")
 * @property string $date_format_medium 中程度の日付形式 (e.g. "Y年n月j日", "M j, Y")
 * @property string $date_format_long 長い日付形式 (e.g. "Y年n月j日(D)", "l, F j, Y")
 * @property string $time_format_short 短い時間形式 (e.g. "H:i", "g:i a")
 * @property string $time_format_medium 中程度の時間形式 (e.g. "H:i:s", "g:i:s a")
 * @property string $datetime_format_short 短い日時形式 (e.g. "Y/m/d H:i", "n/j/Y, g:i a")
 * @property string $first_day_of_week 週の最初の曜日 (e.g. "monday", "sunday")
 * @property int $is_24hour_format 24時間形式を使用するか
 * @property string $default_timezone デフォルトのタイムゾーン (e.g. "Asia/Tokyo", "America/New_York")
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaskStatus> $taskStatuses
 * @property-read int|null $task_statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereDateFormatLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereDateFormatMedium($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereDateFormatShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereDatetimeFormatShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereDefaultTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereFirstDayOfWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereFormatBcp47($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereFormatCldr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereFormatPosix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereIs24hourFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereNativeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereRegionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereScriptCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereTimeFormatMedium($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereTimeFormatShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereUpdatedAt($value)
 */
	class Locale extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\PermissionId $id
 * @property string $scope
 * @property string $resource
 * @property string $action
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permission> $ancestors
 * @property-read int|null $ancestors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permission> $descendants
 * @property-read int|null $descendants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectPermission> $projectPermissions
 * @property-read int|null $project_permissions_count
 * @method static \Database\Factories\PermissionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereResource($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $ancestor_id
 * @property int $descendant_id
 * @property int $depth
 * @property-read \App\Models\Permission $ancestor
 * @property-read \App\Models\Permission $descendant
 * @method static \Database\Factories\PermissionClosureFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionClosure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionClosure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionClosure query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionClosure whereAncestorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionClosure whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionClosure whereDescendantId($value)
 */
	class PermissionClosure extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $childTags
 * @property-read int|null $child_tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectMilestone> $milestones
 * @property-read int|null $milestones_count
 * @property-read \App\Models\Tag|null $parentTag
 * @property-read \App\Models\Project|null $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalTag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalTag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalTag withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalTag withoutTrashed()
 */
	class PersonalTag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\PriorityId $id
 * @property string $key
 * @property int $priority_value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @method static \Database\Factories\PriorityFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority wherePriorityValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Priority whereUpdatedAt($value)
 */
	class Priority extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\ProjectId $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $planned_start_date
 * @property \Illuminate\Support\Carbon|null $planned_end_date
 * @property \Illuminate\Support\Carbon|null $actual_start_date
 * @property \Illuminate\Support\Carbon|null $actual_end_date
 * @property \App\ValueObjects\ProjectStatusId $project_status_id
 * @property bool $is_private
 * @property \App\ValueObjects\UserId $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectInvitation> $invitations
 * @property-read int|null $invitations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectMilestone> $milestones
 * @property-read int|null $milestones_count
 * @property-read \App\Models\ProjectStatus $projectStatus
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectRole> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ProjectFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereActualEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereActualStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project wherePlannedEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project wherePlannedStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereProjectStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereUserId($value)
 */
	class Project extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $project_invitation_id プロジェクト招待ID
 * @property string $email メールアドレス
 * @property string $token トークン
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProjectInvitation $projectInvitation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectEmailInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectEmailInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectEmailInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectEmailInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectEmailInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectEmailInvitation whereProjectInvitationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectEmailInvitation whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectEmailInvitation whereUpdatedAt($value)
 */
	class ProjectEmailInvitation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id ID
 * @property int $project_id プロジェクトID
 * @property int $inviter_by 招待作成者（ProjectMember）
 * @property int $invitation_status_id
 * @property int $invitation_type_id
 * @property \Illuminate\Support\Carbon $expires_at 招待の有効期限
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProjectEmailInvitation|null $emailInvitation
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\InvitationStatus $status
 * @property-read \App\Models\InvitationType $type
 * @property-read \App\Models\ProjectUserInvitation|null $userInvitation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereInvitationStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereInvitationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereInviterBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereUpdatedAt($value)
 */
	class ProjectInvitation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectInvitation> $projectInvitations
 * @property-read int|null $project_invitations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationType query()
 */
	class ProjectInvitationType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\ProjectId $project_id
 * @property \App\ValueObjects\UserId $user_id
 * @property \App\ValueObjects\ProjectRoleId $role_id
 * @property \Illuminate\Support\Carbon $joined_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\ProjectRole $role
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ProjectMemberFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereUserId($value)
 */
	class ProjectMember extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProjectMilestone> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProjectMilestone> $dependencyMilestones
 * @property-read int|null $dependency_milestones_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProjectMilestone> $dependentMilestones
 * @property-read int|null $dependent_milestones_count
 * @property-read ProjectMilestone|null $parent
 * @property-read \App\Models\Project|null $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMilestone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMilestone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMilestone onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMilestone query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMilestone withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMilestone withoutTrashed()
 */
	class ProjectMilestone extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\PermissionId $permission_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Permission $permission
 * @property-read \App\Models\ProjectRolePermission|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectRole> $projectRoles
 * @property-read int|null $project_roles_count
 * @method static \Database\Factories\ProjectPermissionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPermission wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPermission whereUpdatedAt($value)
 */
	class ProjectPermission extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\ProjectRoleId $id
 * @property \App\ValueObjects\ProjectRoleTypeId $project_role_type_id
 * @property int|null $assignable_limit
 * @property int $assigned_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CustomProjectRole|null $customProjectRole
 * @property-read \App\Models\DefaultProjectRole|null $defaultProjectRole
 * @property-read \App\Models\ProjectRolePermission|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectPermission> $projectPermissions
 * @property-read int|null $project_permissions_count
 * @property-read \App\Models\ProjectRoleType $projectRoleType
 * @method static \Database\Factories\ProjectRoleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereAssignableLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereAssignedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereProjectRoleTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereUpdatedAt($value)
 */
	class ProjectRole extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\PermissionId $project_permission_id
 * @property \App\ValueObjects\ProjectRoleId $project_role_id
 * @property \Illuminate\Support\Carbon $assigned_at
 * @property-read \App\Models\ProjectPermission|null $projectPermission
 * @property-read \App\Models\ProjectRole $projectRole
 * @method static \Database\Factories\ProjectRolePermissionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRolePermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRolePermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRolePermission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRolePermission whereAssignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRolePermission whereProjectPermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRolePermission whereProjectRoleId($value)
 */
	class ProjectRolePermission extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\ProjectRoleTypeId $id
 * @property string $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ProjectRoleTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleType whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleType whereUpdatedAt($value)
 */
	class ProjectRoleType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\ProjectRoleTypeId $project_role_type_id
 * @property \App\ValueObjects\LocaleId $locale_id
 * @property string $name
 * @property string $description
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleTypeTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleTypeTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleTypeTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleTypeTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleTypeTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleTypeTranslation whereLocaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleTypeTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleTypeTranslation whereProjectRoleTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleTypeTranslation whereUpdatedAt($value)
 */
	class ProjectRoleTypeTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectScope newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectScope newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectScope query()
 */
	class ProjectScope extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\ProjectStatusId $id
 * @property string $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @method static \Database\Factories\ProjectStatusFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus whereUpdatedAt($value)
 */
	class ProjectStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Project|null $project
 * @property-read \App\Models\Task|null $task
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTask query()
 */
	class ProjectTask extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\User|null $assigner
 * @property-read \App\Models\Project|null $project
 * @property-read \App\Models\Task|null $task
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignment withoutTrashed()
 */
	class ProjectTaskAssignment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Project|null $project
 * @property-read \App\Models\Task|null $task
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskStatistic query()
 */
	class ProjectTaskStatistic extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $childTags
 * @property-read int|null $child_tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectMilestone> $milestones
 * @property-read int|null $milestones_count
 * @property-read \App\Models\Tag|null $parentTag
 * @property-read \App\Models\Project|null $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskTag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskTag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskTag withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskTag withoutTrashed()
 */
	class ProjectTaskTag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\User|null $assignedBy
 * @property-read \App\Models\ProjectTaskTag|null $tag
 * @property-read \App\Models\ProjectTask|null $task
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskTagAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskTagAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskTagAssignment query()
 */
	class ProjectTaskTagAssignment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $project_invitation_id プロジェクト招待ID
 * @property int $user_id ユーザーID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProjectInvitation $projectInvitation
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUserInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUserInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUserInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUserInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUserInvitation whereProjectInvitationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUserInvitation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUserInvitation whereUserId($value)
 */
	class ProjectUserInvitation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RecurringTaskStatus> $statuses
 * @property-read int|null $statuses_count
 * @property-read \App\Models\Task|null $task
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecurringTaskSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecurringTaskSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecurringTaskSetting query()
 */
	class RecurringTaskSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RecurringTaskSetting|null $setting
 * @property-read \App\Models\Task|null $task
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecurringTaskStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecurringTaskStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecurringTaskStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecurringTaskStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecurringTaskStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecurringTaskStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecurringTaskStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecurringTaskStatus whereUpdatedAt($value)
 */
	class RecurringTaskStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id タグID
 * @property string $name タグ名
 * @property string|null $description タグの説明
 * @property int $user_id 作成者
 * @property int $project_id プロジェクトID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Tag> $childTags
 * @property-read int|null $child_tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectMilestone> $milestones
 * @property-read int|null $milestones_count
 * @property-read Tag|null $parentTag
 * @property-read \App\Models\Project $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag withoutTrashed()
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $project_id
 * @property int $task_number
 * @property string $title
 * @property string|null $description
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $planned_start_date
 * @property \Illuminate\Support\Carbon|null $planned_end_date
 * @property \Illuminate\Support\Carbon|null $actual_start_date
 * @property \Illuminate\Support\Carbon|null $actual_end_date
 * @property int $priority_id
 * @property int $category_id
 * @property int $status_id
 * @property bool $is_recurring
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Task> $childTasks
 * @property-read int|null $child_tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaskComment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\ProjectTask|\App\Models\TaskDependency|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Task> $dependencies
 * @property-read int|null $dependencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Task> $dependents
 * @property-read int|null $dependents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RecurringTaskSetting> $recurringSettings
 * @property-read int|null $recurring_settings_count
 * @property-read \App\Models\TaskStatus $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereActualEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereActualStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereIsRecurring($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task wherePlannedEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task wherePlannedStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTaskNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUserId($value)
 */
	class Task extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory query()
 */
	class TaskCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Task|null $ancestor
 * @property-read \App\Models\Task|null $descendant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskClosure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskClosure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskClosure query()
 */
	class TaskClosure extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $project_id
 * @property int $task_number
 * @property int $user_id
 * @property string $content
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read TaskComment|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, TaskComment> $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\Task|null $task
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereTaskNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereUserId($value)
 */
	class TaskComment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $project_id
 * @property int $task_number
 * @property int $depends_on_task_number
 * @property \App\Enums\DependencyTypes $dependency_type 依存関係の種類（FS: 終了後開始, SS: 同時開始, FF: 同時終了, SF: 開始後終了）
 * @property int $lag_minutes 遅延（正）またはリード（負）時間（分単位）。例：60=1時間後、-30=30分前
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Task|null $dependencyTask
 * @property-read \App\Models\Task|null $dependentTask
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskDependency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskDependency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskDependency query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskDependency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskDependency whereDependencyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskDependency whereDependsOnTaskNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskDependency whereLagMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskDependency whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskDependency whereTaskNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskDependency whereUpdatedAt($value)
 */
	class TaskDependency extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskPriority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskPriority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskPriority query()
 */
	class TaskPriority extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\Task|null $sourceTask
 * @property-read \App\Models\Task|null $targetTask
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskRelationship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskRelationship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskRelationship query()
 */
	class TaskRelationship extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id ID
 * @property string $key ステータス名
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @method static \Database\Factories\TaskStatusFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereUpdatedAt($value)
 */
	class TaskStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $task_status_id
 * @property int $locale_id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Locale|null $locale
 * @property-read \App\Models\TaskStatus $taskStatus
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatusTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatusTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatusTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatusTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatusTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatusTranslation whereLocaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatusTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatusTranslation whereTaskStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatusTranslation whereUpdatedAt($value)
 */
	class TaskStatusTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\ValueObjects\UserId $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $participatedProjects
 * @property-read int|null $participated_projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectMember> $projectMembers
 * @property-read int|null $project_members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

