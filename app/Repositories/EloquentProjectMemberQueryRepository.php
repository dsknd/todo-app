<?php

namespace App\Repositories;

use App\ValueObjects\ProjectId;
use App\Models\User;
use Illuminate\Support\Collection;
use App\ValueObjects\ProjectMemberId;
use App\Models\ProjectMember;
use App\ValueObjects\UserId;
use App\ValueObjects\PaginatorPageCount;
use App\ValueObjects\ProjectMemberOrderParamList;
use App\ReadModels\ProjectMemberReadModel;
use App\ReadModels\ProjectMemberSearchResultReadModel;
use App\ValueObjects\ProjectMemberNextToken;

/**
 * プロジェクトメンバーの問い合わせ専用Repository
 */
class EloquentProjectMemberQueryRepository
{
    /**
     * プロジェクトメンバーを取得する
     */
    public function find(ProjectMemberId $projectMemberId): ?ProjectMemberReadModel
    {
        $result = ProjectMember::query()
            ->join('users', 'project_members.user_id', '=', 'users.id')
            ->select([
                'project_members.id as member_id',
                'project_members.project_id',
                'project_members.user_id',
                'project_members.joined_at',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email'
            ])
            ->where('project_members.id', $projectMemberId->getValue())
            ->first();

        if (!$result) {
            return null;
        }

        // 手動でUserオブジェクトを作成
        $user = new User();
        $user->id = $result->user_id;
        $user->name = $result->user_name;
        $user->email = $result->user_email;

        return new ProjectMemberReadModel(
            ProjectMemberId::from($result->member_id),
            ProjectId::from($result->project_id),
            $user,
            $result->joined_at
        );
    }

    /**
     * プロジェクトIDでプロジェクトメンバー一覧を取得する
     */
    public function findByProjectId(ProjectId $projectId): Collection
    {
        $results = ProjectMember::query()
            ->join('users', 'project_members.user_id', '=', 'users.id')
            ->select([
                'project_members.id as member_id',
                'project_members.project_id',
                'project_members.user_id',
                'project_members.joined_at',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email'
            ])
            ->where('project_members.project_id', $projectId->getValue())
            ->get();

        return $results->map(function ($result) {
            // 手動でUserオブジェクトを作成
            $user = new User();
            $user->id = $result->user_id;
            $user->name = $result->user_name;
            $user->email = $result->user_email;

            return new ProjectMemberReadModel(
                ProjectMemberId::from($result->member_id),
                ProjectId::from($result->project_id),
                $user,
                $result->joined_at
            );
        });
    }

    /**
     * プロジェクトIDとユーザーIDでプロジェクトメンバーを取得する
     */
    public function findByProjectIdAndUserId(ProjectId $projectId, UserId $userId): ?ProjectMemberReadModel
    {
        $result = ProjectMember::query()
            ->join('users', 'project_members.user_id', '=', 'users.id')
            ->select([
                'project_members.id as member_id',
                'project_members.project_id',
                'project_members.user_id',
                'project_members.joined_at',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email'
            ])
            ->where('project_members.project_id', $projectId->getValue())
            ->where('project_members.user_id', $userId->getValue())
            ->first();

        if (!$result) {
            return null;
        }

        // 手動でUserオブジェクトを作成
        $user = new User();
        $user->id = $result->user_id;
        $user->name = $result->user_name;
        $user->email = $result->user_email;

        return new ProjectMemberReadModel(
            ProjectMemberId::from($result->member_id),
            ProjectId::from($result->project_id),
            $user,
            $result->joined_at
        );
    }

    /**
     * プロジェクトメンバーを検索する（初回検索）
     */
    public function search(
        ProjectId $projectId,
        PaginatorPageCount $pageCount,
        ProjectMemberOrderParamList $orderParamList
    ): ProjectMemberSearchResultReadModel
    {
        $query = ProjectMember::query()
            ->join('users', 'project_members.user_id', '=', 'users.id')
            ->select([
                'project_members.id as member_id',
                'project_members.project_id',
                'project_members.user_id',
                'project_members.joined_at',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email'
            ])
            ->where('project_members.project_id', $projectId->getValue());

        foreach($orderParamList->all() as $orderParam){
            $column = $orderParam->getColumn();
            // JOINクエリのためテーブル名を明示的に指定
            if (in_array($column, ['joined_at', 'created_at', 'updated_at'])) {
                $column = 'project_members.' . $column;
            }
            $query->orderBy($column, $orderParam->getDirection());
        }

        // 一意性を保つためにIDで二次ソート（常に昇順）
        $query->orderBy('project_members.id', 'asc');

        // ページサイズ+1件取得して、次のページがあるかを判定
        $limit = $pageCount->getValue() + 1;
        $results = $query->take($limit)->get();

        // 次のページがあるかチェック
        $hasMore = $results->count() > $pageCount->getValue();
        if ($hasMore) {
            // 余分な1件を削除
            $results = $results->take($pageCount->getValue());
        }

        // ReadModelに変換
        $members = $this->convertToReadModels($results);

        // 次のページのトークンを生成
        $nextPageToken = null;
        if ($hasMore && $members->isNotEmpty()) {
            $lastMember = $members->last();
            $nextPageToken = ProjectMemberNextToken::from(
                $projectId,
                $pageCount,
                $orderParamList,
                $lastMember->projectMemberId
            );
        }

        return new ProjectMemberSearchResultReadModel(
            $members,
            $nextPageToken,
            $hasMore
        );
    }

    /**
     * NextTokenを使ってプロジェクトメンバーを検索する（次ページ以降）
     */
    public function searchByNextToken(ProjectMemberNextToken $nextToken): ProjectMemberSearchResultReadModel
    {
        $query = ProjectMember::query()
            ->join('users', 'project_members.user_id', '=', 'users.id')
            ->select([
                'project_members.id as member_id',
                'project_members.project_id',
                'project_members.user_id',
                'project_members.joined_at',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email'
            ])
            ->where('project_members.project_id', $nextToken->getProjectId()->getValue());

        // カーソルベースフィルタリング - IDで境界を設定
        if ($nextToken->getLastId()) {
            $query->where('project_members.id', '>', $nextToken->getLastId()->getValue());
        }

        // ユーザー指定のソート条件を適用
        foreach($nextToken->getOrderParamList()->all() as $orderParam){
            $column = $orderParam->getColumn();
            // JOINクエリのためテーブル名を明示的に指定
            if (in_array($column, ['joined_at', 'created_at', 'updated_at'])) {
                $column = 'project_members.' . $column;
            }
            $query->orderBy($column, $orderParam->getDirection());
        }

        // 一意性を保つためにIDで二次ソート（常に昇順）
        $query->orderBy('project_members.id', 'asc');

        // ページサイズ+1件取得して、次のページがあるかを判定
        $limit = $nextToken->getPageCount()->getValue() + 1;
        $results = $query->take($limit)->get();

        // 次のページがあるかチェック
        $hasMore = $results->count() > $nextToken->getPageCount()->getValue();
        if ($hasMore) {
            // 余分な1件を削除
            $results = $results->take($nextToken->getPageCount()->getValue());
        }

        // ReadModelに変換
        $members = $this->convertToReadModels($results);

        // 次のページのトークンを生成
        $nextPageToken = null;
        if ($hasMore && $members->isNotEmpty()) {
            $lastMember = $members->last();
            $nextPageToken = ProjectMemberNextToken::from(
                $nextToken->getProjectId(),
                $nextToken->getPageCount(),
                $nextToken->getOrderParamList(),
                $lastMember->projectMemberId
            );
        }

        return new ProjectMemberSearchResultReadModel(
            $members,
            $nextPageToken,
            $hasMore
        );
    }

    /**
     * クエリ結果をReadModelに変換する共通処理
     */
    private function convertToReadModels($results): Collection
    {
        return $results->map(function ($result) {
            $user = new User();
            $user->id = $result->user_id;
            $user->name = $result->user_name;
            $user->email = $result->user_email;

            return new ProjectMemberReadModel(
                ProjectMemberId::from($result->member_id),
                ProjectId::from($result->project_id),
                $user,
                $result->joined_at
            );
        });
    }
} 