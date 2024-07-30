<?php
include 'sort_data.php';
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

        <form action="export_csv.php" method="post">
            <button type="submit" class="btn btn-primary" name="export-csv">Экспорт</button>
        </form>
    </div>
</body>
</html>