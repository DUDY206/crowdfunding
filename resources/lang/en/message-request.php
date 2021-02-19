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
    'company-invest' => [
        "name_vi" => [
            "required" => "Company invest's Vietnamese name is required",
            "unique" => "Company invest's Vietnamese name is in used",
        ],
        "name_en" => [
            "required" => "Company invest's English name is required",
            "unique" => "Company invest's English name is in used",
        ],
        "min_invest" => [
            "required" => "Min invest is required",
            "numeric" => "Min invest input is invalid",
            "min" => "Min invest input is invalid",
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
            ],
            "is_faq" => "FAQ/Risks type is not valid"
        ],

    ],
];
