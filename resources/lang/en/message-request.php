<?php
return [
    'company' => [
        'img_url' => [
            'image' => 'File type is not accepted',
            'mimes' => 'File to large'
        ],
        'name_vi' => [
            'required' => 'Company\'s Vietnamese name is required',
            'unique' => 'Company\'s Vietnamese name is in used',
        ],
        'name_en' => [
            'required' => 'Company\'s English name is required',
            'unique' => 'Company\'s English name is in used',
        ],
        'account_id' => [
            'required' => 'Chưa chọn người quản lí công ty'
        ],
        'delete' => 'Delete company successfully'
    ],
    'errors' => [
          'not-found' => 'Content not found',
    ],
];
