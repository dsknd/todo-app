<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
{
    /**
     * リクエストの認可を判定
     */
    public function authorize(): bool
    {
        return true;  // 必要に応じて認可ロジックを実装
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status_id' => ['required', 'exists:project_statuses,id'],
            'planned_start_date' => ['nullable', 'date'],
            'planned_end_date' => [
                'nullable',
                'date',
                'after_or_equal:planned_start_date'
            ],
            'actual_start_date' => ['nullable', 'date'],
            'actual_end_date' => [
                'nullable',
                'date',
                'after_or_equal:actual_start_date'
            ],
            'is_private' => ['required', 'boolean'],
        ];
    }

    /**
     * バリデーションメッセージをカスタマイズ
     */
    public function messages(): array
    {
        return [
            'name.required' => 'プロジェクト名は必須です',
            'name.max' => 'プロジェクト名は255文字以内で入力してください',
            'status_id.required' => 'ステータスは必須です',
            'status_id.exists' => '指定されたステータスは存在しません',
            'planned_end_date.after_or_equal' => '予定終了日は予定開始日以降の日付を指定してください',
            'actual_end_date.after_or_equal' => '実績終了日は実績開始日以降の日付を指定してください',
            'is_private.required' => 'プロジェクトの公開設定は必須です',
            'is_private.boolean' => 'プロジェクトの公開設定はブール値で入力してください',
        ];
    }

    /**
     * バリデーション前のデータ整形
     */
    protected function prepareForValidation(): void
    {
        // 日付データの整形
        $dates = ['planned_start_date', 'planned_end_date', 'actual_start_date', 'actual_end_date'];
        foreach ($dates as $date) {
            if ($this->has($date) && is_string($this->input($date))) {
                $this->merge([
                    $date => $this->input($date) ? date('Y-m-d H:i:s', strtotime($this->input($date))) : null
                ]);
            }
        }

        // 配列データの整形
        $arrays = ['team_ids', 'member_ids'];
        foreach ($arrays as $array) {
            if ($this->has($array) && is_string($this->input($array))) {
                $this->merge([
                    $array => array_filter(explode(',', $this->input($array)))
                ]);
            }
        }
    }
}