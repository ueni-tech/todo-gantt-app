<?php

return [
    'required' => ':attributeは必須です。',
    'string'   => ':attributeは文字列でなければなりません。',
    'unique'   => ':attributeは既に存在します。',
    'after_or_equal' => ':attributeは開始日以降でなければなりません。',
    'date' => ':attributeは日付でなければなりません。',
    'image' => ':attributeは画像でなければなりません。',
    'mimes' => ':attributeは:values形式でなければなりません。',
    'uploaded' => ':attributeはjpeg,png,jpg,gif,svg形式でなければなりません。',
    
    'max'      => [
        'string' => ':attributeは:max文字以内でなければなりません。',
        'file' => ':attributeは:maxKB以内でなければなりません。',
    ],
    'attributes' => [
        'team_name' => 'チーム名',
        'project_name' => 'プロジェクト名',
        'task_name' => 'タスク名',
        'note' => 'メモ',
        'start_date' => '開始日',
        'end_date' => '終了日',
        'team_image_name' => 'チームアイコン',
    ],
];
