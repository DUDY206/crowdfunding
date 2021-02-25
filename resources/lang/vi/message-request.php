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
    ],
    'user-info' =>  [
        "user_name" => [
            "required" => "Chưa nhập username",
            "unique" => "username đã sử dụng",
        ],
        "full_name" => [
            "required" => "Chưa nhập họ tên",
        ],
        "password" => [
            "required" => "Chưa nhập mật khẩu",
            "min" => "Mật khẩu quá ngắn (tối thiểu 8 ký tự)",
        ],
        "email" => [
            "required" => "Chưa nhập email",
            "email" => "Email không đúng định dạng",
            "unique" => "Email đã được sử dụng",
        ],
        "phone_number" => [
            "required" => "Chưa nhập số điện thoại",
            "unique" => "Số điện thoại đã được sử dụng",
        ],
        "date_of_birth" => [
            "required" => "Chưa nhập ngày sinh",
            "date" => "Ngày sinh không hợp lệ",
        ],
        "avatar" => [
            "image" => "Ảnh avatar không đúng định dạng",
            "mimes" => "Ảnh avatar không đúng định dạng",
        ],
        "cover_photo" => [
            "image" => "Ảnh cover không đúng định dạng",
            "mimes" => "Ảnh cover không đúng định dạng",
        ],
        "is_verify" => [
            "boolean" => "is_verify field is invalid",
        ],
        "is_reliable_investor" => [
            "boolean" => "is_reliable_investor field is invalid",
        ],
    ],

];
