<?php
session_start();

if (isset($_POST['export-csv'])){
    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=download.csv");

    $fp = fopen('php://output', 'w');

    setlocale(LC_ALL, 'ru_RU.CP1251');

    fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

    $fioDB = isset($_SESSION['fioDB']) ? $_SESSION['fioDB'] : [];
    $emailDB = isset($_SESSION['emailDB']) ? $_SESSION['emailDB'] : [];
    $phoneDB = isset($_SESSION['phoneDB']) ? $_SESSION['phoneDB'] : [];
    $cityDB = isset($_SESSION['cityDB']) ? $_SESSION['cityDB'] : [];

    $data = [];
    $data[] = ['ФИО', 'Email', 'Телефон', 'Город'];
    for ($i = 0; $i < count($fioDB); $i++) {
        $data[] = [$fioDB[$i], $emailDB[$i], $phoneDB[$i], $cityDB[$i]];
    }

    foreach ($data as $fields) {
        fputcsv($fp, $fields, ';');
    }

    fclose($fp);
    exit();
}

?>