<?php

return [
    'required' => ':attributeは必須です。',
    'string'   => ':attributeは文字列でなければなりません。',
    'max'      => [
        'string' => ':attributeは:max文字以内でなければなりません。',
    ],
    'unique'   => ':attributeは既に存在します。',
    'after_or_equal' => ':attributeは開始日以降でなければなりません。',
    'date' => ':attributeは日付でなければなりません。',
    
    'attributes' => [
        'team_name' => 'チーム名',
        'project_name' => 'プロジェクト名',
        'task_name' => 'タスク名',
        'note' => 'メモ',
        'start_date' => '開始日',
        'end_date' => '終了日',
    ],
];
