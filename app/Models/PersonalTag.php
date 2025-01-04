<?php

namespace App\Models;

use App\Enums\OwnershipTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalTag extends Model
{
    //
    protected $primaryKey = 'tag_id';

    public $timestamps = false;

    protected $fillable = [
        'tag_id',
        'user_id'
    ];

    public function scopeWithTagDetail($query, $tagId)
    {
        $ownershipTypeId = OwnershipTypes::Personal()->value;

        return $query->join('tags', function ($join) use ($tagId) {
            $join->on('personal_tags.tag_id', '=', 'tags.id')
                ->where('tags.id', $tagId);
            })
            ->join('ownership_types', function ($join) {
                $join->on('tags.ownership_type_id', '=', 'ownership_types.id')
                    ->where('ownership_types.id', OwnershipTypes::Personal);
            })
            ->select('personal_tags.*', 'tags.*');
    }

    public function scopeWithTagByUserId($query, $userId)
    {
        return $query->join('tags', function ($join) use ($userId) {
            $join->on('personal_tags.tag_id', '=', 'tags.id')
                ->where('personal_tags.user_id', $userId);
        })->select('personal_tags.*', 'tags.*');
    }
}
