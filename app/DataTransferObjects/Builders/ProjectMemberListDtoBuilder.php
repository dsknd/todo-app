<?php

namespace App\DataTransferObjects;

use Illuminate\Database\Eloquent\Collection;

class ProjectMemberListDtoBuilder
{
    private Collection $projectMembers;
    private int $totalCount;
    private int $perPage;
    private ?string $nextToken = null;

    public function projectMembers(Collection $projectMembers): self
    {
        $this->projectMembers = $projectMembers;
        return $this;
    }

    public function totalCount(int $totalCount): self
    {
        $this->totalCount = $totalCount;
        return $this;
    }

    public function perPage(int $perPage): self
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function nextToken(?string $nextToken): self
    {
        $this->nextToken = $nextToken;
        return $this;
    }

    public function build(): ProjectMemberListDto
    {
        return new ProjectMemberListDto(
            projectMembers: $this->projectMembers,
            totalCount: $this->totalCount,
            perPage: $this->perPage,
            nextToken: $this->nextToken
        );
    }
}