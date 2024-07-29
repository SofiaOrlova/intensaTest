<?php
$fioDB = [];
$emailDB = [];
$phoneDB = [];
$cityDB = [];
$conn = new mysqli("localhost", "root", "", "intensaTestDB");
if ($conn == false){
    print("Ошибка: Невозможно подключиться" . mysqli_connect_error());
}
else {
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $selectedCity = isset($_GET['city']) ? $_GET['city'] : '';
        // $selectedCity = $conn->real_escape_string($selectedCity);
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
    }
    // $data = [];
    // $data[] = ['FIO', 'Email', 'Phone', 'City'];
    // for ($i = 0; $i < count($fioDB); $i++) {
    //     $data[] = [$fioDB[$i], $emailDB[$i], $phoneDB[$i], $cityDB[$i]];
    // }
    // var_dump($data);
}
// $data = [];
// $data[] = ['FIO', 'Email', 'Phone', 'City'];
// for ($i = 0; $i < count($fioDB); $i++) {
//     $data[] = [$fioDB[$i], $emailDB[$i], $phoneDB[$i], $cityDB[$i]];
// }
// echo '<pre>';
// print_r($data);
// echo '</pre>';
// foreach ($data as $fields) {
//     var_dump($fields);
// }

if (isset($_POST['export-csv'])){
    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=download.csv");

    $fp = fopen('php://output', 'w');

    // $list = array (
    //     array('FIO', 'Email', 'Phone', 'City'),
    //     array('Иванов Иван Иванович', 'Иванов Иван Иванович', 'Иванов Иван Иванович'),
    //     array('ivanIvanov@ya.ru', 'sidorov@mail.ru'),
    //     array('+7 950 990-00-55', '+7 999 999-99-99')
    // );

    // foreach ($list as $fields) {
    //     fputcsv($fp, $fields, ';');
    // }
    setlocale(LC_ALL, 'ru_RU.CP1251');

    $query = "SELECT * FROM contacts ";
    $result = mysqli_query($conn, $query);

    fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($fp, $row, ';');
    }

    // $data = [];
    // $data[] = ['FIO', 'Email', 'Phone', 'City'];
    // for ($i = 0; $i < count($fioDB); $i++) {
    //     $data[] = [$fioDB[$i], $emailDB[$i], $phoneDB[$i], $cityDB[$i]];
    // }

    // foreach ($data as $fields) {
    //     fputcsv($fp, $fields, ';');
    // }

    fclose($fp);
    exit();
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список контактов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/index.php">Контакты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Список</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container">
            <!-- <label for="city" class="form-label">Город</label> -->
        <form method="GET" class="filter">
            <select class="form-select" id="city" name="city">
                <option value="">Все города</option>
                <option value="Москва" <?php echo $selectedCity == 'Москва' ? 'selected' : '' ;?>>Москва</option>
                <option value="Санкт-Петербург" <?php echo $selectedCity == 'Санкт-Петербург' ? 'selected' : ''; ?>>Санкт-Петербург</option>
                <option value="Тула" <?php echo $selectedCity == 'Тула' ? 'selected' : ''; ?>>Тула</option>
            </select>
            <button type="submit" class="btn btn-primary btn-city">Выбрать</button>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">ФИО</th>
                <th scope="col">Email</th>
                <th scope="col">Телефон</th>
                <th scope="col">Город</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    for($i = 0; $i < count($fioDB); $i++){
                        echo '<tr><th scope="row">' . $i+1 . '</th><td>' . $fioDB[$i] . '</td><td>' . $emailDB[$i] . '</td><td>' . $phoneDB[$i] . '</td><td class="citySelected">' . $cityDB[$i] . '</td></tr>';
                    }
                ?>
            </tbody>
        </table>

        <form action="" method="post">
        <button type="submit" class="btn btn-primary" name="export-csv">Экспорт</button>
        </form>
    </div>

    <script>
        // document.addEventListener("DOMContentLoaded", () => {
        //     let citySelect = document.getElementById('city');
        //     let select = document.querySelector('.citySelected').textContent;
        //     citySelect.value = select;
        //     console.log(select);
        //     console.log(citySelect.value);
        // });
        // let btn = document.querySelector(".btn-city");
    </script>
</body>
</html>