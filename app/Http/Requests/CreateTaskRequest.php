<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority_id' => ['nullable', 'integer'],
            'category_id' => ['nullable', 'integer'],
            'is_recurring' => ['nullable', 'boolean'],
            'planned_start_date' => ['nullable', 'date'],
            'planned_end_date' => [
                'nullable',
                'date',
                'after_or_equal:planned_start_date',
            ],
            'actual_start_date' => ['nullable', 'date'],
            'actual_end_date' => [
                'nullable',
                'date',
                'after_or_equal:actual_start_date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルは必須です',
            'title.max' => 'タイトルは255文字以内で入力してください',
            'description.string' => '詳細は文字列で入力してください',
            'priority_id.integer' => '優先度は整数で入力してください',
            'category_id.integer' => 'カテゴリは整数で入力してください',
            'is_recurring.boolean' => 'リマインダーはブール値で入力してください',
            'planned_start_date.date' => '予定開始日は日付で入力してください',
            'planned_end_date.date' => '予定終了日は日付で入力してください',
            'planned_end_date.after_or_equal' => '予定終了日は予定開始日以降の日付を指定してください',
            'actual_start_date.date' => '実際の開始日は日付で入力してください',
            'actual_end_date.date' => '実際の終了日は日付で入力してください',
            'actual_end_date.after_or_equal' => '実際の終了日は実際の開始日以降の日付を指定してください',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->prepareDates();
        $this->prepareArrays();
    }

    private function prepareDates(): void
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

    private function prepareArrays(): void
    {
        $arrays = ['assignee_ids', 'tag_ids'];
        foreach ($arrays as $array) {
            if ($this->has($array) && is_string($this->input($array))) {
                $this->merge([
                    $array => array_filter(explode(',', $this->input($array)))
                ]);
            }
        }
    }
} 