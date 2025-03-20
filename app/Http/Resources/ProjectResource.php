<?php

namespace App\Http\Resources;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // /** @var Project $this->resource */
        return [
            'id' => $this->resource->id->getValue(),
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'is_private' => $this->resource->is_private,
            'status' => [
                'id' => $this->resource->project_status_id->getValue(),
                'name' => $this->resource->projectStatus->name,
            ],
            'owner' => [
                'id' => $this->resource->user_id->getValue(),
                'name' => $this->resource->user->name,
            ],
            'planned_start_date' => $this->resource->planned_start_date?->format('Y-m-d'),
            'planned_end_date' => $this->resource->planned_end_date?->format('Y-m-d'),
            'actual_start_date' => $this->resource->actual_start_date?->format('Y-m-d'),
            'actual_end_date' => $this->resource->actual_end_date?->format('Y-m-d'),
            'created_at' => $this->resource->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->resource->updated_at->format('Y-m-d H:i:s'),
        ];
    }
} 