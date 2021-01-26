<?php
return [
    'company' => [
        'img_url' => [
            'image' => 'Ảnh không đúng định dạng',
            'mimes' => 'Kích thước ảnh quá lớn'
        ],
        'name_vi' => [
            'required' => 'Chưa nhập tên tiếng Việt',
            'unique' => 'Tên đã sử dụng',
        ],
        'name_en' => [
            'required' => 'Chưa nhập tên tiếng Anh',
            'unique' => 'Tên đã sử dụng',
        ],
        'account_id' => [
            'required' => 'Chưa chọn người quản lí công ty'
        ],
        'delete' => 'Xóa công ty thành công'
    ],
    'errors' => [
        'not-found' => 'Không tìm thấy nội dung',
    ],
];
