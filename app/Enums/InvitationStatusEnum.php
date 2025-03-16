<?php

namespace App\Enums;

enum InvitationStatusEnum: int
{
    case PENDING = 1;     // 招待保留中
    case ACCEPTED = 2;   // 招待承諾済み
    case DECLINED = 3;   // 招待辞退
    case EXPIRED = 4;     // 招待期限切れ
    case CANCELED = 5;   // 招待キャンセル

    /**
     * ステータスのキーを取得
     */
    public static function getKey(self $value): string
    {
        return match($value) {
            self::PENDING => 'pending',
            self::ACCEPTED => 'accepted',
            self::DECLINED => 'declined',
            self::EXPIRED => 'expired',
            self::CANCELED => 'canceled',
        };
    }

    /**
     * 次の有効なステータスの配列を取得
     * @return array<ProjectInvitationStatuses>
     */
    public static function getNextStatuses(self $value): array
    {
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
    public static function canChangeTo(self $value, self $newStatus): bool
    {
        if ($newStatus === $value) {
            return false;
        }

        if (in_array($newStatus, self::getNextStatuses($value))) {
            return true;
        }

        return false;
    }
}
