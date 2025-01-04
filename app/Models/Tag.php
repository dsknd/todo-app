<?php

namespace App\Models;

use App\Enums\OwnershipTypes;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'ownership_type_id',
        'created_by',
    ];

    public function scopeWithTagDetail($query, $tagId)
    {
        $ownershipTypeId = OwnershipTypes::Personal()->value;

        return $query->join('ownership_types', function ($join) use ($ownershipTypeId) {
            $join->on('tags.ownership_type_id', '=', 'ownership_types.id')
                ->where('ownership_types.id', $ownershipTypeId);
            })
            ->where('tags.id', $tagId)
            ->select(
                'tags.id',
                'tags.name',
                'tags.description',
                'tags.created_by',
                'ownership_types.name as ownership_type'
            );
    }

    public function scopeWithPersonalTagDetailByTagId($query, $tagId)
    {
        // OwnershipType ID を取得
        $ownershipTypeId = OwnershipTypes::Personal()->value;

        return $query->join('ownership_types', function ($join) use ($ownershipTypeId) {
            $join->on('tags.ownership_type_id', '=', 'ownership_types.id')
                ->where('ownership_types.id', $ownershipTypeId); // 個人タグのみ
        })
            ->join('personal_tags', function ($join) use ($tagId) {
                $join->on('tags.id', '=', 'personal_tags.tag_id')
                    ->where('personal_tags.tag_id', $tagId); // 特定のタグIDに絞る
            })
            ->select(
                'tags.id',
                'tags.name',
                'tags.description',
                'tags.created_by',
                'ownership_types.name as ownership_type'
            );
    }

    public function scopeWithPeronalTagDetailByUserId($query, $userId)
    {
        $ownershipTypeId = OwnershipTypes::Personal()->value;

        return $query->join('personal_tags', function ($join) use ($userId) {
            $join->on('tags.id', '=', 'personal_tags.tag_id')
                ->where('personal_tags.user_id', $userId);
            })
            ->join('ownership_types', function ($join) use ($ownershipTypeId) {
                $join->on('tags.ownership_type_id', '=', 'ownership_types.id')
                    ->where('ownership_types.id', $ownershipTypeId);
            })
            ->select(
                'tags.id',
                'tags.name',
                'tags.description',
                'tags.created_by',
                'personal_tags.user_id',
                'ownership_types.name as ownership_type'
            );
    }



}
