<?php
function validate($value, $type){
    $pattern = [
        'email' => "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/",
        'password' => "/^[a-zA-Z0-9_]{4,32}$/",
        'name' => "/^[a-z\s]{3,32}$/",
        'username' => "/^[a-zA-Z0-9_]{3,32}$/"
    ];
    if(array_key_exists($type, $pattern)){
        $pattern = $pattern[$type];
        return preg_match($pattern, $value);
    }
}

/// Best Way
/// 
// function registerValidation($inputs)
// {
//     $errors = array();
//     if (!filled($inputs, 'email')) {
//         $errors['email'][] = 'لطفا ایمیل را وارد کنید';
//     }

//     if (!isEmail($inputs['email'])) {
//         $errors['email'][] = 'لطفا یک ایمیل معتبر وارد کنید';
//     }


//     if (!filled($inputs, 'password')) {
//         $errors['password'][] = 'لطفا رمز عبور را وارد کنید';
//     }


//     $_SESSION['errors'] = $errors;
// }

// function filled($inputs, $name)
// {
//     return isset($inputs[$name]) && !empty($inputs[$name]);
// }

// function isEmail($email)
// {
//     return filter_var($email, FILTER_VALIDATE_EMAIL);
// }