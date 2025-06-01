<?php

namespace App\ValueObjects;

use App\ValueObjects\ProjectMemberSortOrder;
use InvalidArgumentException;
use JsonSerializable;

/**
 * プロジェクトメンバーのソート条件リスト
 */
final class ProjectMemberSortOrders implements JsonSerializable
{
    /**
     * コンストラクタ
     *
     * @param ProjectMemberSortOrder[] $sortOrders
     */
    public function __construct(
        private readonly array $sortOrders
    ) {
        // ソート条件の妥当性を検証
        $this->validate($sortOrders);
    }

    /**
     * ソート条件の数を取得
     * 
     * @return int
     */
    public function count(): int
    {
        return count($this->sortOrders);
    }

    /**
     * ソート条件を取得
     * 
     * @return ProjectMemberSearchOrder[]
     */
    public function all(): array
    {
        return $this->sortOrders;
    }

    /**
     * ソート条件を取得
     * 
     * @return ProjectMemberSearchOrder
     */
    public function get(int $index): ProjectMemberSortOrder
    {
        if ($index < 0 || $index >= count($this->sortOrders)) {
            throw new InvalidArgumentException('Invalid index');
        }
        return $this->sortOrders[$index];
    }

    /**
     * ソート条件の妥当性を検証
     *
     * @param ProjectMemberSearchOrder[] $sortOrders
     * @throws InvalidArgumentException
     */
    private function validate(array $sortOrders): void
    {
        // 重複しているソート条件がある場合はエラー
        $uniqueSortOrders = array_unique($sortOrders);
        if (count($uniqueSortOrders) !== count($sortOrders)) {
            throw new InvalidArgumentException('Duplicate order parameters are not allowed');
        }

        // ソート条件がProjectMemberOrderParamのインスタンスでない場合はエラー
        foreach ($sortOrders as $sortOrder) {
            if (!$sortOrder instanceof ProjectMemberSortOrder) {
                throw new InvalidArgumentException('All elements must be ProjectMemberSearchOrder instances');
            }
            $sortOrder->validate();
        }
    }

    /**
     * ソート条件リストを作成
     * 
     * @param ProjectMemberSearchOrder[] $sortOrders
     * @return self
     */
    public static function from(array $sortOrders): self
    {
        return new self($sortOrders);
    }

    /**
     * JSONシリアライズ
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->sortOrders;
    }
}