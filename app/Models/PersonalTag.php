<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class PersonalTag extends Tag
{
    /**
     * モデルの「起動」メソッド
     */
    protected static function booted()
    {
        // 個人タグのみに限定するグローバルスコープを追加
        static::addGlobalScope('personal', function (Builder $builder) {
            $builder->where('is_personal', true);
        });

        // 新規作成時に is_personal を true に設定
        static::creating(function ($tag) {
            $tag->is_personal = true;
        });
    }

    /**
     * 個人タグの検証
     * 
     * @throws \InvalidArgumentException 検証エラーの場合
     */
    public function validate(): void
    {
        parent::validate();

        if (!$this->is_personal) {
            throw new \InvalidArgumentException('Personal tag must be personal');
        }

        if (!$this->user_id) {
            throw new \InvalidArgumentException('Personal tag must belong to a user');
        }

        if ($this->project_id) {
            throw new \InvalidArgumentException('Personal tag cannot belong to a project');
        }
    }

    /**
     * ユーザーの個人タグを取得
     */
    public static function forUser(int $userId): Builder
    {
        return static::where('user_id', $userId);
    }

    /**
     * ユーザーのルートタグを取得
     * 
     * @return array<PersonalTag>
     */
    public static function getRootTags(int $userId): array
    {
        return static::forUser($userId)
            ->whereNull('parent_tag_id')
            ->orderBy('name')
            ->get()
            ->all();
    }

    /**
     * ユーザーのタグツリーを取得
     * 
     * @return array<array{tag: PersonalTag, children: array}>
     */
    public static function getTagTree(int $userId): array
    {
        $tags = static::forUser($userId)->get();
        $tree = [];

        // ルートタグを見つける
        $rootTags = $tags->whereNull('parent_tag_id');

        // 各ルートタグに対して再帰的に子タグを追加
        foreach ($rootTags as $rootTag) {
            $tree[] = [
                'tag' => $rootTag,
                'children' => self::buildTagTree($tags, $rootTag->id),
            ];
        }

        return $tree;
    }

    /**
     * タグツリーを再帰的に構築
     * 
     * @param \Illuminate\Support\Collection<Tag> $tags 全タグのコレクション
     * @param int $parentId 親タグのID
     * @return array<array{tag: PersonalTag, children: array}>
     */
    private static function buildTagTree($tags, int $parentId): array
    {
        $tree = [];
        $children = $tags->where('parent_tag_id', $parentId);

        foreach ($children as $child) {
            $tree[] = [
                'tag' => $child,
                'children' => self::buildTagTree($tags, $child->id),
            ];
        }

        return $tree;
    }

    /**
     * タグを別のユーザーに移行
     */
    public function moveToUser(int $userId): void
    {
        // 子タグも含めて再帰的に移行
        $this->moveTagTreeToUser($this, $userId);
    }

    /**
     * タグツリーを再帰的にユーザーに移行
     */
    private function moveTagTreeToUser(PersonalTag $tag, int $userId): void
    {
        $tag->user_id = $userId;
        $tag->save();

        foreach ($tag->childTags as $childTag) {
            $this->moveTagTreeToUser($childTag, $userId);
        }
    }

    /**
     * タグの使用回数をユーザー別に取得
     */
    public function getUsageCountByUser(int $userId): int
    {
        return TagAssignment::where('tag_id', $this->id)
            ->where('assigned_by', $userId)
            ->count();
    }

    /**
     * タグの使用履歴をユーザー別に取得
     */
    public function getUsageHistoryByUser(int $userId): array
    {
        return TagAssignment::where('tag_id', $this->id)
            ->where('assigned_by', $userId)
            ->with(['taggable', 'assignedBy'])
            ->orderByDesc('created_at')
            ->get()
            ->all();
    }
}
