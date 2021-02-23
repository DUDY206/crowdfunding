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
    'company-invest' => [
        "name_vi" => [
            "required" => "Chưa nhập tên công ty",
            "unique" => "Tên công ty đã sử dụng",
        ],
        "name_en" => [
            "required" => "Chưa nhập tên công ty",
            "unique" => "Tên công ty đã sử dụng",
        ],
        "min_invest" => [
            "required" => "Chưa nhập min invest",
            "numeric" => "Min invest không hợp lệ",
            "min" => "Min invest không hợp lệ ",
        ],
        "valuation_cap" => [
            "required" => "Valuation Cap is required",
            "numeric" => "Valuation Cap input is invalid",
            "min" => "Valuation Cap input is invalid",
        ],
        "status" => [
            "required" => "Company Invest status is required",
            "numeric" => "Company Invest status is invalid",
        ],
        "company_id" => [
            "required" => "Company ID is invalid",
            "exists" => "Company ID is not exists"
        ],
        "total_follow" => [
            "numeric" => "Total follow is invalid",
            "min" => "Total follow is invalid",
        ],
        "img_url" => [
            "image" => "Image is invalid",
            "mimes" => "Image is invalid",
        ],
        "mutable_field" => [
            "position" => "Position is invalid"
        ],
        "delete" => "Delete investment successfully",
        "faq_risk" => [
            "invest_id" => [
                "required" => "ID investment is required",
                "exists" => "ID investment is not valid"
            ]
        ],
    ],
    'social-comment' => [
        'content' => 'Comment không được để trống',
        'invest_id' => 'Invest ID không hợp lệ',
        'reply_comment_id' => 'Reply comment id không hợp lệ',
    ]
];
