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
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $childCategories
 * @property-read int|null $child_categories_count
 * @property-read Category|null $parentCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $code_iso_639_1
 * @property string $code_ietf_bcp_47
 * @property string $name
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $code
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaskStatus> $taskStatuses
 * @property-read int|null $task_statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereCodeIetfBcp47($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereCodeIso6391($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locale whereUpdatedAt($value)
 */
	class Locale extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $scope
 * @property string $resource
 * @property string $action
 * @property string $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permission> $ancestors
 * @property-read int|null $ancestors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permission> $descendants
 * @property-read int|null $descendants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectPermission> $projectPermissions
 * @property-read int|null $project_permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereDisplayName($value)
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
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $planned_start_date
 * @property \Illuminate\Support\Carbon|null $planned_end_date
 * @property \Illuminate\Support\Carbon|null $actual_start_date
 * @property \Illuminate\Support\Carbon|null $actual_end_date
 * @property int $project_status_id
 * @property bool $is_private
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectInvitation> $invitations
 * @property-read int|null $invitations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectMilestone> $milestones
 * @property-read int|null $milestones_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectRole> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\ProjectStatus $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project onlyTrashed()
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project withoutTrashed()
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
 * @property int $project_invitation_status_id
 * @property int $project_invitation_type_id
 * @property \Illuminate\Support\Carbon $expires_at 招待の有効期限
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProjectEmailInvitation|null $emailInvitation
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\ProjectInvitationStatus $status
 * @property-read \App\Models\ProjectInvitationType $type
 * @property-read \App\Models\ProjectUserInvitation|null $userInvitation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereInviterBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereProjectInvitationStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereProjectInvitationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitation whereUpdatedAt($value)
 */
	class ProjectInvitation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectInvitation> $projectInvitations
 * @property-read int|null $project_invitations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus whereUpdatedAt($value)
 */
	class ProjectInvitationStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property \App\Enums\ProjectInvitationTypeEnum $id
 * @property string $key システム内部キー
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectInvitation> $projectInvitations
 * @property-read int|null $project_invitations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationType whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationType whereUpdatedAt($value)
 */
	class ProjectInvitationType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $project_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $joined_at
 * @property-read \App\Models\Project $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectRoleAssignment> $roleAssignments
 * @property-read int|null $role_assignments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectRole> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereUserId($value)
 */
	class ProjectMember extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMemberRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMemberRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMemberRole query()
 */
	class ProjectMemberRole extends \Eloquent {}
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
 * @property int $permission_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectRole> $assignments
 * @property-read int|null $assignments_count
 * @property-read \App\Models\Permission $permission
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectRole> $projectRoles
 * @property-read int|null $project_roles_count
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
 * @property int $project_permission_id
 * @property int $project_role_id
 * @property-read \App\Models\User|null $assigner
 * @property-read \App\Models\ProjectPermission $projectPermission
 * @property-read \App\Models\ProjectRole $projectRole
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPermissionAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPermissionAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPermissionAssignment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPermissionAssignment whereProjectPermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectPermissionAssignment whereProjectRoleId($value)
 */
	class ProjectPermissionAssignment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $project_role_type
 * @property int|null $project_id
 * @property int|null $created_by
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\ProjectRoleTypes $type
 * @property-read \App\Models\Project|null $project
 * @property-read \App\Models\ProjectRoleAssignment|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $projectMembers
 * @property-read int|null $project_members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectPermission> $projectPermissions
 * @property-read int|null $project_permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectRoleAssignment> $projectRoleAssignments
 * @property-read int|null $project_role_assignments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereProjectRoleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereUpdatedAt($value)
 */
	class ProjectRole extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $project_role_id
 * @property int $project_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $assigner
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\ProjectMember $projectMember
 * @property-read \App\Models\ProjectRole $role
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment whereProjectRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment whereUserId($value)
 */
	class ProjectRoleAssignment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleScope newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleScope newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleScope query()
 */
	class ProjectRoleScope extends \Eloquent {}
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
 * @property int $id
 * @property string $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereId($value)
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
 * @property int $id
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
 * @property-read \App\Models\ProjectRoleAssignment|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectRole> $projectRoles
 * @property-read int|null $project_roles_count
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

