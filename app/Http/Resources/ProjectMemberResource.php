<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Traits\Paginatable;

class ProjectMemberResource extends JsonResource
{
    use Paginatable;
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'project_id' => $this->resource->project_id->getValue(),
            'user' => [
                'id' => $this->resource->user_id->getValue(),
                'name' => $this->resource->user->name,
            ],
            'joined_at' => $this->resource->joined_at->format('Y-m-d H:i:s'),
        ];
    }
}