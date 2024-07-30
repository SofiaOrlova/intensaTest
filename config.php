<?php
$conn = new mysqli("localhost", "root", "", "intensaTestDB");

if ($conn == false){
    print("Ошибка: Невозможно подключиться" . mysqli_connect_error());
}

?>