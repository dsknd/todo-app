<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class ProjectTag extends Tag
{
    /**
     * モデルの「起動」メソッド
     */
    protected static function booted()
    {
        // プロジェクトタグのみに限定するグローバルスコープを追加
        static::addGlobalScope('project', function (Builder $builder) {
            $builder->where('is_personal', false);
        });

        // 新規作成時に is_personal を false に設定
        static::creating(function ($tag) {
            $tag->is_personal = false;
        });
    }

    /**
     * プロジェクトタグの検証
     * 
     * @throws \InvalidArgumentException 検証エラーの場合
     */
    public function validate(): void
    {
        parent::validate();

        if ($this->is_personal) {
            throw new \InvalidArgumentException('Project tag cannot be personal');
        }

        if (!$this->project_id) {
            throw new \InvalidArgumentException('Project tag must belong to a project');
        }
    }

    /**
     * プロジェクト内のタグを取得
     */
    public static function forProject(int $projectId): Builder
    {
        return static::where('project_id', $projectId);
    }

    /**
     * プロジェクト内のルートタグを取得
     * 
     * @return array<ProjectTag>
     */
    public static function getRootTags(int $projectId): array
    {
        return static::forProject($projectId)
            ->whereNull('parent_tag_id')
            ->orderBy('name')
            ->get()
            ->all();
    }

    /**
     * プロジェクト内のタグツリーを取得
     * 
     * @return array<array{tag: ProjectTag, children: array}>
     */
    public static function getTagTree(int $projectId): array
    {
        $tags = static::forProject($projectId)->get();
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
     * @return array<array{tag: ProjectTag, children: array}>
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
     * タグを別のプロジェクトに移行
     */
    public function moveToProject(int $projectId): void
    {
        // 子タグも含めて再帰的に移行
        $this->moveTagTreeToProject($this, $projectId);
    }

    /**
     * タグツリーを再帰的にプロジェクトに移行
     */
    private function moveTagTreeToProject(ProjectTag $tag, int $projectId): void
    {
        $tag->project_id = $projectId;
        $tag->save();

        foreach ($tag->childTags as $childTag) {
            $this->moveTagTreeToProject($childTag, $projectId);
        }
    }
}
