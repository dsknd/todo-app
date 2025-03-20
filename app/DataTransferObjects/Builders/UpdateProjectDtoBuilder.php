<?php

namespace App\DataTransferObjects\Builders;

use App\DataTransferObjects\UpdateProjectDto;
use Carbon\Carbon;
use App\ValueObjects\ProjectStatusId;
final class UpdateProjectDtoBuilder
{
    private string $name;
    private string $description;
    private ?ProjectStatusId $project_status_id = null;
    private bool $is_private;
    private ?Carbon $planned_start_date = null;
    private ?Carbon $planned_end_date = null;

    public function __construct()
    {
        $this->name = '';
        $this->description = '';
        $this->is_private = false;
        $this->project_status_id = null;
    }

    public static function builder(): self
    {
        return new self();
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function description(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function projectStatusId(ProjectStatusId $projectStatusId): self
    {
        $this->project_status_id = $projectStatusId;
        return $this;
    }

    public function isPrivate(bool $isPrivate): self
    {
        $this->is_private = $isPrivate;
        return $this;
    }

    public function plannedStartDate(?string $date): self
    {
        $this->planned_start_date = $date ? Carbon::parse($date) : null;
        return $this;
    }

    public function plannedEndDate(?string $date): self
    {
        $this->planned_end_date = $date ? Carbon::parse($date) : null;
        return $this;
    }

    public function build(): UpdateProjectDto
    {
        return new UpdateProjectDto(
            name: $this->name,
            description: $this->description,
            project_status_id: $this->project_status_id,
            is_private: $this->is_private,
            planned_start_date: $this->planned_start_date,
            planned_end_date: $this->planned_end_date,
        );
    }
} 