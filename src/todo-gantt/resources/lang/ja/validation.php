<?php

return [
    'required' => ':attributeは必須です。',
    'string'   => ':attributeは文字列でなければなりません。',
    'max'      => [
        'string' => ':attributeは:max文字以内でなければなりません。',
    ],
    'unique'   => ':attributeは既に存在します。',
    'attributes' => [
        'team_name' => 'チーム名',
        'project_name' => 'プロジェクト名',
        'task_name' => 'タスク名',
    ],
];
