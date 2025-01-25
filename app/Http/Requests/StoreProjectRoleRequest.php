<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRoleRequest extends FormRequest
{
    /**
     * ユーザーがこのリクエストを実行できるかどうかを判定する
     * 認可処理はポリシーを通して行うため、ここでは常に true を返す
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ];
    }

    /**
     * バリデーションエラーのカスタムメッセージを取得する
     */
    public function messages(): array
    {
        return [
            'project_id.required' => '"project_id" is required.',
            'project_id.integer' => '"project_id" is invalid.',
            'name.required' => '"name" is required.',
            'name.string' => '"name" is not a valid string.',
            'description.string' => '"description" is not a valid string.',
        ];
    }
}
