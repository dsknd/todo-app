<?php

namespace App\Http\Queries;

use Illuminate\Http\Request;
use InvalidArgumentException;

class ProjectIndexQuery
{
    public const TYPE_OWNED = 'owned';
    public const TYPE_PARTICIPATING = 'participating';
    public const ALLOWED_TYPES = [self::TYPE_OWNED, self::TYPE_PARTICIPATING];

    public const SORT_CREATED_AT = 'created_at';
    public const SORT_NAME = 'name';
    public const SORT_STATUS = 'status';
    public const ALLOWED_SORTS = [self::SORT_CREATED_AT, self::SORT_NAME, self::SORT_STATUS];

    public const ORDER_ASC = 'asc';
    public const ORDER_DESC = 'desc';
    public const ALLOWED_ORDERS = [self::ORDER_ASC, self::ORDER_DESC];

    private function __construct(
        public readonly ?string $type = null,
        public readonly ?string $status = null,
        public readonly int $perPage = 15,
        public readonly string $sort = self::SORT_CREATED_AT,
        public readonly string $order = self::ORDER_DESC,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $validated = validator($request->query(), [
            'type' => ['nullable', 'string', 'in:' . implode(',', self::ALLOWED_TYPES)],
            'status' => 'nullable|string',
            'per_page' => 'nullable|integer|min:1|max:100',
            'sort' => ['nullable', 'string', 'in:' . implode(',', self::ALLOWED_SORTS)],
            'order' => ['nullable', 'string', 'in:' . implode(',', self::ALLOWED_ORDERS)],
        ])->validate();

        return new self(
            type: $validated['type'] ?? null,
            status: $validated['status'] ?? null,
            perPage: (int)($validated['per_page'] ?? 15),
            sort: $validated['sort'] ?? self::SORT_CREATED_AT,
            order: $validated['order'] ?? self::ORDER_DESC,
        );
    }

    public function isOwnedProjectsRequest(): bool
    {
        return $this->type === self::TYPE_OWNED;
    }

    public function isParticipatingProjectsRequest(): bool
    {
        return $this->type === self::TYPE_PARTICIPATING || $this->type === null;
    }

    public function getSortColumn(): string
    {
        return match($this->sort) {
            self::SORT_NAME => 'projects.name',
            self::SORT_STATUS => 'projects.project_status_id',
            default => 'projects.created_at',
        };
    }

    public function isAscending(): bool
    {
        return $this->order === self::ORDER_ASC;
    }
} 