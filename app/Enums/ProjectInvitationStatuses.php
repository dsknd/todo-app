<?php

namespace App\Enums;

enum ProjectInvitationStatuses: string
{
    case PENDING = 'pending';     // 招待保留中
    case ACCEPTED = 'accepted';   // 招待承諾済み
    case DECLINED = 'declined';   // 招待辞退
    case EXPIRED = 'expired';     // 招待期限切れ
    case CANCELED = 'canceled';   // 招待キャンセル

    /**
     * ステータスの説明を取得
     */
    public function getDescription(): string
    {
        return match($this) {
            self::PENDING => '招待保留中',
            self::ACCEPTED => '招待承諾済み',
            self::DECLINED => '招待辞退',
            self::EXPIRED => '招待期限切れ',
            self::CANCELED => '招待キャンセル',
        };
    }

    /**
     * 次の有効なステータスの配列を取得
     * @return array<ProjectInvitationStatuses>
     */
    public function getNextStatuses(): array
    {
        return match($this) {
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
    public function canTransitionTo(self $newStatus): bool
    {
        return in_array($newStatus, $this->getNextStatuses());
    }
}
