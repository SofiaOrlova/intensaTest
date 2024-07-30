<?php
include 'config.php';
session_start();

$fioDB = [];
$emailDB = [];
$phoneDB = [];
$cityDB = [];

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $selectedCity = isset($_GET['city']) ? $_GET['city'] : '';
    if ($selectedCity) {
        $query = "SELECT * FROM contacts WHERE city = '$selectedCity'";
    } else {
        $query = "SELECT * FROM contacts ";
    }

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $fioDB[] = $row['FIO'];
        $emailDB[] = $row['email'];
        $phoneDB[] = $row['phone'];
        $cityDB[] = $row['city'];
    }

    $_SESSION['fioDB'] = $fioDB;
    $_SESSION['emailDB'] = $emailDB;
    $_SESSION['phoneDB'] = $phoneDB;
    $_SESSION['cityDB'] = $cityDB;
}

$conn->close();
?>