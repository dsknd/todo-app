<?php

return [
    'unauthenticated' => [
        'title' => '認証エラー',
        'detail' => '認証に失敗しました。',
    ],
    'resource_not_found' => [
        'title' => '存在しないリソース',
        'detail' => '指定されたリソースは存在しません。',
    ],
    'json_parse_error' => [
        'title' => '不正なリクエスト',
        'detail' => 'JSONの形式が無効または壊れています。',
    ],
    'unauthorized' => [
        'title' => '認可エラー',
        'detail' => 'このリソースにアクセスする権限がありません。',
    ],
    'validation_error' => [
        'title' => '検証エラー',
        'project' => [
            'name' => [
                'required' => 'プロジェクト名は必須です。',
                'max' => 'プロジェクト名は255文字以内で入力してください。',
            ],
            'planned_start_date' => [
                'date' => '計画開始日は有効な日付で入力してください。',
            ],
            'planned_end_date' => [
                'date' => '計画終了日は有効な日付で入力してください。',
                'after_or_equal' => '計画終了日は計画開始日以降の日付で入力してください。',
            ],
            'actual_start_date' => [
                'date' => '実際の開始日は有効な日付で入力してください。',
            ],
            'actual_end_date' => [
                'date' => '実際の終了日は有効な日付で入力してください。',
                'after_or_equal' => '実際の終了日は実際の開始日以降の日付で入力してください。',
            ],
            'is_private' => [
                'required' => 'プライベートフラグは必須です。',
                'boolean' => 'プライベートフラグは真偽値で入力してください。',
            ],
        ],
    ],
];
