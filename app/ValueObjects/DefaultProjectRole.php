<?php

namespace App\ValueObjects;

final class DefaultProjectRole
{
    private string $name;
    private string $description;
    private array $permissions;
    private array $localizedNames;
    private array $localizedDescriptions;

    private function __construct(string $name, string $description, array $permissions, array $localizedNames = [], array $localizedDescriptions = [])
    {
        $this->name = $name;
        $this->description = $description;
        $this->permissions = $permissions;
        $this->localizedNames = $localizedNames;
        $this->localizedDescriptions = $localizedDescriptions;
    }

    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getPermissions(): array { return $this->permissions; }

    /**
     * ロケールに応じた名前を取得
     *
     * @param LocaleCode $localeCode
     * @return string
     */
    public function getLocalizedName(LocaleCode $localeCode): string
    {
        $languageCode = $localeCode->getLanguage();
        return $this->localizedNames[$languageCode] ?? $this->name;
    }

    /**
     * ロケールに応じた説明を取得
     *
     * @param LocaleCode $localeCode
     * @return string
     */
    public function getLocalizedDescription(LocaleCode $localeCode): string
    {
        $languageCode = $localeCode->getLanguage();
        return $this->localizedDescriptions[$languageCode] ?? $this->description;
    }

    /**
     * すべてのデフォルトロールを取得
     */
    public static function all(): array
    {
        return [
            self::OWNER(),
            self::ADMIN(),
            self::MEMBER(),
            self::VIEWER(),
            self::GUEST(),
        ];
    }

    /**
     * 各デフォルトロールを定義
     */
    public static function OWNER(): self
    {
        return new self(
            'Owner',
            'The owner of the project has all permissions',
            ['projects:*', 'projects:tasks:*', 'projects:roles:*', 'projects:members:*', 'projects:invitations:*'],
            [
                'ja' => 'オーナー',
                'en' => 'Owner'
            ],
            [
                'ja' => 'プロジェクトのオーナーはすべての権限を持っています',
                'en' => 'The owner of the project has all permissions'
            ]
        );
    }

    public static function ADMIN(): self
    {
        return new self(
            'Admin',
            'The admin of the project has all permissions',
            ['projects:read', 'projects:update', 'projects:tasks:*', 'projects:roles:*', 'projects:members:*', 'projects:invitations:*'],
            [
                'ja' => '管理者',
                'en' => 'Admin'
            ],
            [
                'ja' => 'プロジェクトの管理者はほとんどの権限を持っています',
                'en' => 'The admin of the project has all permissions'
            ]
        );
    }

    public static function MEMBER(): self
    {
        return new self(
            'Member',
            'The member of the project has basic privileges',
            ['projects:read', 'projects:tasks:read', 'projects:tasks:create', 'projects:tasks:update', 'projects:members:read', 'projects:invitations:read'],
            [
                'ja' => 'メンバー',
                'en' => 'Member'
            ],
            [
                'ja' => 'プロジェクトのメンバーは基本的な権限を持っています',
                'en' => 'The member of the project has basic privileges'
            ]
        );
    }

    public static function VIEWER(): self
    {
        return new self(
            'Viewer',
            'The viewer can only read project information',
            ['projects:read', 'projects:tasks:read', 'projects:members:read'],
            [
                'ja' => '閲覧者',
                'en' => 'Viewer'
            ],
            [
                'ja' => '閲覧者はプロジェクト情報の閲覧のみ可能です',
                'en' => 'The viewer can only read project information'
            ]
        );
    }

    public static function GUEST(): self
    {
        return new self(
            'Guest',
            'Guests have very limited access',
            ['projects:read', 'projects:tasks:read'],
            [
                'ja' => 'ゲスト',
                'en' => 'Guest'
            ],
            [
                'ja' => 'ゲストは非常に限られたアクセス権を持っています',
                'en' => 'Guests have very limited access'
            ]
        );
    }
}