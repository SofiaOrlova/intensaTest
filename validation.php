<?php

function validationEmail($email){
    $errors=[];
    if ($email == '') {
        $errors[] = "Email не может быть пустым.";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Неверный формат email.";
    }
    return $errors;
}

function validationFIO($fio){
    $errors=[];
    if ($fio == '') {
        $errors[] = "ФИО не может быть пустым.";
    } elseif (!preg_match('/^([А-Я][а-яё]{1,30})(\s[А-Я][а-яё]{1,30})*(\s)?$/u', $fio, $matches)) {
        $errors[] = "Неверное ФИО. Пример для заполнения: Иванов Иван Иванович"; 
    }
    return $errors;
}

function validationPhone($phone){
    $errors=[];
    if (strlen($phone)<16) {
        $errors[] = "Неполный номер телефона."; 
    } elseif (!preg_match('/^\+7\s\d{3}\s\d{3}-\d{2}-\d{2}$/', $phone, $matches)) {
        $errors[] = "Неверный формат телефона."; 
    }
    return $errors;
}



?>