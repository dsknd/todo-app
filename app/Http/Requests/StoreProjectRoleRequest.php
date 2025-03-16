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
        return true;
    }

    /**
     * バリデーションルールを取得
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
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
            'name.string' => 'ロール名は文字列で入力してください。',
            'name.max' => 'ロール名は255文字以内で入力してください。',
            'description.string' => 'ロールの説明は文字列で入力してください。',
            'description.max' => 'ロールの説明は1000文字以内で入力してください。',
        ];
    }
}
