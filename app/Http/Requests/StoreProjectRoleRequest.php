<?php

namespace App\Http\Requests;

use App\Models\ProjectPermission;
use App\Models\ProjectRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class StoreProjectRoleRequest extends FormRequest
{
    /**
     * リクエストの認可を判定
     */
    public function authorize(): bool
    {
        $project = $this->route('project');
        return Auth::user()->can('create', [ProjectRole::class, $project]);
    }

    /**
     * バリデーションルールを取得
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                // 同じプロジェクト内で重複する名前を禁止
                'unique:project_roles,name,NULL,id,project_id,' . $this->route('project')->id,
            ],
            'description' => 'nullable|string|max:1000',
            'permissions' => 'array',
            'permissions.*' => [
                'integer',
                'exists:project_permissions,id',
                function ($attribute, $value, $fail) {
                    // プロジェクト固有の権限の場合、同じプロジェクトに属していることを確認
                    $permission = ProjectPermission::find($value);
                    if ($permission && !$permission->is_custom) {
                        return;
                    }
                    if ($permission && $permission->project_id !== $this->route('project')->id) {
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
}
