<?php

namespace App\ValueObjects;

use App\ValueObjects\ProjectMemberOrderParam;
use InvalidArgumentException;

/**
 * プロジェクトメンバーのソート条件リスト
 */
final class ProjectMemberOrderParamList
{
    /**
     * コンストラクタ
     *
     * @param ProjectMemberOrderParam[] $orderParamList
     */
    public function __construct(
        private readonly array $orderParamList
    ) {
        // ソート条件の妥当性を検証
        $this->validate($orderParamList);
    }

    /**
     * ソート条件の数を取得
     * 
     * @return int
     */
    public function count(): int
    {
        return count($this->orderParamList);
    }

    /**
     * ソート条件を取得
     * 
     * @return ProjectMemberOrderParam[]
     */
    public function all(): array
    {
        return $this->orderParamList;
    }

    /**
     * ソート条件を取得
     * 
     * @return ProjectMemberOrderParam
     */
    public function get(int $index): ProjectMemberOrderParam
    {
        if ($index < 0 || $index >= count($this->orderParamList)) {
            throw new InvalidArgumentException('Invalid index');
        }
        return $this->orderParamList[$index];
    }

    /**
     * ソート条件の妥当性を検証
     *
     * @param ProjectMemberOrderParam[] $orderParamList
     * @throws InvalidArgumentException
     */
    private function validate(array $orderParamList): void
    {
        // 重複しているソート条件がある場合はエラー
        $uniqueOrderParamList = array_unique($orderParamList);
        if (count($uniqueOrderParamList) !== count($orderParamList)) {
            throw new InvalidArgumentException('Duplicate order parameters are not allowed');
        }

        // ソート条件がProjectMemberOrderParamのインスタンスでない場合はエラー
        foreach ($orderParamList as $orderParam) {
            if (!$orderParam instanceof ProjectMemberOrderParam) {
                throw new InvalidArgumentException('All elements must be ProjectMemberOrderParam instances');
            }
            $orderParam->validate();
        }
    }

    /**
     * ソート条件リストを作成
     * 
     * @param ProjectMemberOrderParam[] $orderParamList
     * @return self
     */
    public static function from(array $orderParamList): self
    {
        return new self($orderParamList);
    }
}