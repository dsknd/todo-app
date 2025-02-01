<?php

namespace App\Http\Requests;

use App\Enums\ProjectRoleTypes;
use App\Models\AppLog;
use App\Models\ProjectPermission;
use App\Models\ProjectRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class UpdateProjectRoleRequest extends FormRequest
{
    /**
     * リクエストの認可を判定
     */
    public function authorize(): bool
    {
        $projectRole = $this->route('projectRole');
        return Auth::user()->can('update', $projectRole);
    }

    /**
     * バリデーションの前処理
     */
    public function prepareForValidation(): void
    {
        // デフォルトロールは編集不可
        if ($this->route('projectRole')->project_role_type_id === ProjectRoleTypes::DEFAULT) {
            abort(403, 'Cannot modify default project role');
        }
    }

    /**
     * バリデーションルールを取得
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $projectRole = $this->route('projectRole');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                // 同じプロジェクト内で重複する名前を禁止（自分自身は除く）
                'unique:project_roles,name,' . $projectRole->id . ',id,project_id,' . $projectRole->project_id,
            ],
            'description' => 'nullable|string|max:1000',
            'permissions' => 'array',
            'permissions.*' => [
                'integer',
                'exists:project_permissions,id',
                function ($attribute, $value, $fail) use ($projectRole) {
                    // プロジェクト固有の権限の場合、同じプロジェクトに属していることを確認
                    $permission = ProjectPermission::find($value);
                    if ($permission && !$permission->is_custom) {
                        return;
                    }
                    if ($permission && $permission->project_id !== $projectRole->project_id) {
                        $fail('The selected permission is not available for this project.');
                    }
                },
            ],
        ];
    }

    /**
     * バリデーションエラーメッセージをカスタマイズ
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'ロール名は必須です。',
            'name.unique' => 'このロール名は既に使用されています。',
            'permissions.*.exists' => '指定された権限は存在しません。',
        ];
    }

    /**
     * バリデーション後の処理
     */
    protected function passedValidation(): void
    {
        $projectRole = $this->route('projectRole');

        // 変更をログに記録
        AppLog::createEntry(
            'update_validation',
            $projectRole,
            Auth::user(),
            'Validated project role update',
            [
                'old_values' => [
                    'name' => $projectRole->name,
                    'description' => $projectRole->description,
                    'permissions' => $projectRole->projectPermissions->pluck('id')->toArray(),
                ],
                'new_values' => [
                    'name' => $this->input('name'),
                    'description' => $this->input('description'),
                    'permissions' => $this->input('permissions', []),
                ],
            ]
        );
    }
}
