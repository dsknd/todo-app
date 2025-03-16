<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'status_id' => ['sometimes', 'nullable', 'integer'],
            'planned_start_date' => ['sometimes', 'nullable', 'date'],
            'planned_end_date' => [
                'sometimes',
                'nullable',
                'date',
                'after_or_equal:planned_start_date'
            ],
            'actual_start_date' => ['sometimes', 'nullable', 'date'],
            'actual_end_date' => [
                'sometimes',
                'nullable',
                'date',
                'after_or_equal:actual_start_date'
            ],
            'is_private' => ['sometimes', 'nullable', 'boolean'],
        ];
    }

    /**
     * バリデーションメッセージをカスタマイズ
     */
    public function messages(): array
    {
        return [
            'name.string' => 'プロジェクト名は文字列で入力してください',
            'name.max' => 'プロジェクト名は255文字以内で入力してください',
            'description.string' => 'プロジェクトの説明は文字列で入力してください',
            'status_id.integer' => 'プロジェクトのステータスは整数で入力してください',
            'planned_start_date.date' => '予定開始日は日付形式で入力してください',
            'planned_end_date.date' => '予定終了日は日付形式で入力してください',
            'planned_end_date.after_or_equal' => '予定終了日は予定開始日以降の日付を指定してください',
            'actual_start_date.date' => '実績開始日は日付形式で入力してください',
            'actual_end_date.date' => '実績終了日は日付形式で入力してください',
            'actual_end_date.after_or_equal' => '実績終了日は実績開始日以降の日付を指定してください',
            'is_private.boolean' => 'プロジェクトの公開設定はブール値で入力してください',
        ];
    }

    protected function prepareForValidation(): void
    {
        $dates = ['planned_start_date', 'planned_end_date', 'actual_start_date', 'actual_end_date'];
        foreach ($dates as $date) {
            if ($this->has($date) && is_string($this->input($date))) {
                $this->merge([
                    $date => $this->input($date) ? date('Y-m-d H:i:s', strtotime($this->input($date))) : null
                ]);
            }
        }
    }
} 