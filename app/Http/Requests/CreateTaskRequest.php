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
            'category_id' => ['required', 'exists:categories,id'],
            'planned_start_date' => ['nullable', 'date'],
            'planned_end_date' => [
                'nullable',
                'date',
                'after_or_equal:planned_start_date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルは必須です',
            'title.max' => 'タイトルは255文字以内で入力してください',
            'category_id.required' => 'カテゴリは必須です',
            'category_id.exists' => '指定されたカテゴリは存在しません',
            'importance_id.required' => '重要度は必須です',
            'importance_id.exists' => '指定された重要度は存在しません',
            'urgency_id.required' => '緊急度は必須です',
            'urgency_id.exists' => '指定された緊急度は存在しません',
            'planned_end_date.after_or_equal' => '予定終了日は予定開始日以降の日付を指定してください',
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