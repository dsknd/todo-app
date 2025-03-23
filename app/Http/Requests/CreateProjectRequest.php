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
            'name.required' => __('errors.validation_error.project.name.required'),
            'name.max' => __('errors.validation_error.project.name.max'),
            'planned_start_date.date' => __('errors.validation_error.project.planned_start_date.date'),
            'planned_end_date.date' => __('errors.validation_error.project.planned_end_date.date'),
            'planned_end_date.after_or_equal' => __('errors.validation_error.project.planned_end_date.after_or_equal'),
            'actual_start_date.date' => __('errors.validation_error.project.actual_start_date.date'),
            'actual_end_date.date' => __('errors.validation_error.project.actual_end_date.date'),
            'actual_end_date.after_or_equal' => __('errors.validation_error.project.actual_end_date.after_or_equal'),
            'is_private.required' => __('errors.validation_error.project.is_private.required'),
            'is_private.boolean' => __('errors.validation_error.project.is_private.boolean'),
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