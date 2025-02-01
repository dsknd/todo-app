<?php

namespace App\Enums;

enum ProjectInvitationStatusEnum: int
{
    case PENDING = 1;     // 招待保留中
    case ACCEPTED = 2;   // 招待承諾済み
    case DECLINED = 3;   // 招待辞退
    case EXPIRED = 4;     // 招待期限切れ
    case CANCELED = 5;   // 招待キャンセル

    /**
     * ステータスの表示名を取得
     */
    public static function getDisplayName(mixed $value): string
    {
        $value = $value instanceof self ? $value->value : $value;

        return match($value) {
            self::PENDING->value => '招待保留中',
            self::ACCEPTED->value => '招待承諾済み',
            self::DECLINED->value => '招待辞退',
            self::EXPIRED->value => '招待期限切れ',
            self::CANCELED->value => '招待キャンセル',
        };
    }

    /**
     * ステータスの説明を取得
     */
    public static function getDescription(mixed $value): string
    {
        $value = $value instanceof self ? $value->value : $value;

        return match($value) {
            self::PENDING->value => '招待保留中',
            self::ACCEPTED->value => '招待承諾済み',
            self::DECLINED->value => '招待辞退',
            self::EXPIRED->value => '招待期限切れ',
            self::CANCELED->value => '招待キャンセル',
        };
    }

    /**
     * 次の有効なステータスの配列を取得
     * @return array<ProjectInvitationStatuses>
     */
    public static function getNextStatuses(mixed $value): array
    {
        $value = $value instanceof self ? $value->value : $value;

        return match($value) {
            self::PENDING => [self::ACCEPTED, self::DECLINED, self::EXPIRED, self::CANCELED],
            self::ACCEPTED => [],  // 承諾後は変更不可
            self::DECLINED => [],  // 辞退後は変更不可
            self::EXPIRED => [],   // 期限切れ後は変更不可
            self::CANCELED => [],  // キャンセル後は変更不可
        };
    }

    /**
     * ステータスが変更可能かどうかを確認
     */
    public static function canChangeTo(mixed $value, mixed $newStatus): bool
    {
        $value = $value instanceof self ? $value->value : $value;
        $newStatus = $newStatus instanceof self ? $newStatus->value : $newStatus;

        if ($newStatus === $value) {
            return false;
        }

        return in_array($newStatus, self::getNextStatuses($value));
    }
}
