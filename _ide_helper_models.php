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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppLog whereUpdatedAt($value)
 */
	class AppLog extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $category_id
 * @property int $type_id
 * @property int|null $project_id
 * @property-read \App\Models\TaskCategory $category
 * @property-read \App\Models\Project|null $project
 * @property-read \App\Models\TaskType $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomTaskCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomTaskCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomTaskCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomTaskCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomTaskCategory whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomTaskCategory whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomTaskCategory withProjectTaskCategories($projectId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomTaskCategory withTaskCategories($projectId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomTaskCategory withTaskCategory($categoryId = null)
 */
	class CustomTaskCategory extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $status_id
 * @property int $member_count
 * @property int $task_count
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectRole> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\ProjectStatus $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectTaskStatistic> $taskStatistics
 * @property-read int|null $task_statistics_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ProjectFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereMemberCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereTaskCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereUpdatedAt($value)
 */
	class Project extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $name Status name (e.g., pending, accepted)
 * @property string|null $description Detailed description of the status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectInvitationStatus whereUpdatedAt($value)
 */
	class ProjectInvitationStatus extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember query()
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
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $project_id
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Scope> $scopes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Project $project
 * @property-read int|null $scopes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereScopes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRole whereUpdatedAt($value)
 */
	class ProjectRole extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $role_id
 * @property int $project_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectRoleAssignment whereRoleId($value)
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
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @method static \Database\Factories\ProjectStatusFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus whereUpdatedAt($value)
 */
	class ProjectStatus extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $project_id
 * @property int $task_id
 * @property int $assignee_id
 * @property int $assigned_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignments query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignments whereAssignedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignments whereAssigneeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignments whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignments whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskAssignments whereUpdatedAt($value)
 */
	class ProjectTaskAssignments extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $project_id
 * @property int $status_id
 * @property int $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\TaskStatus $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskStatistic query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskStatistic whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskStatistic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskStatistic whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskStatistic whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTaskStatistic whereUpdatedAt($value)
 */
	class ProjectTaskStatistic extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectRole> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Scope newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Scope newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Scope query()
 */
	class Scope extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScopeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScopeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScopeType query()
 */
	class ScopeType extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $due_date
 * @property int $type_id
 * @property int|null $priority_id
 * @property int $user_id
 * @property int|null $status_id
 * @property int|null $project_id
 * @property int $is_recurring
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereIsRecurring($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUserId($value)
 * @mixin \Eloquent
 */
	class Task extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $created_by
 * @property int $is_custom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CustomTaskCategory|null $customCategory
 * @property-read \App\Models\Project|null $project
 * @property-read \App\Models\Project|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory whereIsCustom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategory withCustomCategory($categoryId = null)
 */
	class TaskCategory extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $task_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategoryAssigment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategoryAssigment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategoryAssigment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategoryAssigment whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategoryAssigment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategoryAssigment whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskCategoryAssigment whereUpdatedAt($value)
 */
	class TaskCategoryAssigment extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
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
 * @property int $task_id
 * @property int $user_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskComment whereUserId($value)
 */
	class TaskComment extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property int $priority_level
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskPriority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskPriority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskPriority query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskPriority whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskPriority whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskPriority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskPriority whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskPriority wherePriorityLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskPriority whereUpdatedAt($value)
 */
	class TaskPriority extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $parent_task_id
 * @property int $child_task_id
 * @property int $depth
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskRelationship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskRelationship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskRelationship query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskRelationship whereChildTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskRelationship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskRelationship whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskRelationship whereParentTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskRelationship whereUpdatedAt($value)
 */
	class TaskRelationship extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereUpdatedAt($value)
 */
	class TaskStatus extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskType whereUpdatedAt($value)
 */
	class TaskType extends \Eloquent {}
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

