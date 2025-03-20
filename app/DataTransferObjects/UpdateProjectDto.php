<?php

namespace App\DataTransferObjects;

use App\Http\Requests\UpdateProjectRequest;
use App\DataTransferObjects\Builders\UpdateProjectDtoBuilder;
use Carbon\Carbon;
use App\ValueObjects\ProjectStatusId;
final class UpdateProjectDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly ?ProjectStatusId $project_status_id,
        public readonly bool $is_private,
        public readonly ?Carbon $planned_start_date,
        public readonly ?Carbon $planned_end_date,
    ) {
    }

    public static function builder(): UpdateProjectDtoBuilder
    {
        return UpdateProjectDtoBuilder::builder();
    }

    public static function fromRequest(UpdateProjectRequest $request): self
    {
        return self::builder()
            ->name($request->input('name'))
            ->description($request->input('description'))
            ->projectStatusId($request->input('project_status_id'))
            ->isPrivate($request->boolean('is_private'))
            ->plannedStartDate($request->input('planned_start_date'))
            ->plannedEndDate($request->input('planned_end_date'))
            ->build();
    }

    public function isEmpty(): bool
    {
        return empty($this->toArray());
    }

    /**
     * DTOをarray形式に変換
     */
    public function toArray(): array
    {
        $array = [];

        if ($this->name) {
            $array['name'] = $this->name;
        }
        if ($this->description) {
            $array['description'] = $this->description;
        }
        if ($this->project_status_id) {
            $array['project_status_id'] = $this->project_status_id;
        }
        if ($this->is_private) {
            $array['is_private'] = $this->is_private;
        }

        if ($this->planned_start_date) {
            $array['planned_start_date'] = $this->planned_start_date;
        }
        if ($this->planned_end_date) {
            $array['planned_end_date'] = $this->planned_end_date;
        }

        return $array;
    }
} 