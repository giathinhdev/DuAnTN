<?php

return [
    'required' => 'Trường :attribute là bắt buộc.',
    'email' => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
    'unique' => 'Trường :attribute đã tồn tại.',
    'confirmed' => 'Xác nhận mật khẩu không khớp.',
    'min' => [
        'string' => 'Trường :attribute phải có ít nhất :min ký tự.',
    ],
    'max' => [
        'string' => 'Trường :attribute không được vượt quá :max ký tự.',
    ],
    // Thêm các quy tắc khác nếu cần
    'attributes' => [
        'name' => 'Tên',
        'email' => 'Email',
        'password' => 'Mật khẩu',
        'phone' => 'Điện thoại',
        'role' => 'Vai trò',
    ],
    'user_created' => 'Người dùng đã được tạo thành công.',
    
];
