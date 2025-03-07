<?php
include 'config.php';
include 'validation.php';
session_start();

$errors_email = [];
$errors_fio = [];
$errors_phone = [];
$error_token = ''; 
$success = false;

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = md5(uniqid(rand(), true));
}
$token = $_SESSION['csrf_token'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fio = trim($_POST['inputFIO']);
    $email = trim($_POST['inputEmail']);
    $phone = trim($_POST['inputPhone']);
    $city = trim($_POST['city']);

    $errors_email = validationEmail($email);
    $errors_fio = validationFIO($fio);
    $errors_phone = validationPhone($phone);

    if (empty($errors_email) && empty($errors_fio) && empty($errors_phone) && $city !== '') {
        if(isset($_POST['csrf_token'])){
            if($_POST['csrf_token'] == $_SESSION['csrf_token']){
                $sql = "INSERT INTO contacts (FIO, email, phone, city) VALUES ('$fio', '$email', '$phone', '$city')";
                $conn->query($sql);

                $success = true;
                header("Location: index.php?success=1");
            } else {
                $error_token = "Неверный токен CSRF";
            }
        } else {
            $error_token = "Токен CSRF не найден";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты</title>
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
                        <a class="nav-link active" aria-current="page" href="index.php">Контакты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cotact_list.php">Список</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1 class="title">Оставить заявку</h1>
        <div <?php echo isset($_GET["success"]) ? 'class="alert alert-success"' : 'class="alert alert-success display-none"'?> role="alert">
            Данные успешно отправлены
        </div>
        <form class="contacts" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
            <div class="mb-3">
                <label for="inputFIO" class="form-label">ФИО</label>
                <input type="text" class="form-control" id="inputFIO" name="inputFIO" value="<?php echo $fio ?? ''?>">
            </div>
            <?php if (!empty($errors_fio)): ?>
                <div class="text-error alert-danger-fio">
                    <?php foreach ($errors_fio as $error): ?>
                        <?php echo $error; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail" name="inputEmail" value="<?php echo $email ?? ''?>">
            </div>
            <?php if (!empty($errors_email)): ?>
                <div class="text-error alert-danger-email">
                    <?php foreach ($errors_email as $error): ?>
                        <?php echo $error; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="inputPhone" class="form-label">Телефон</label>
                <input type="tel" class="form-control" id="inputPhone" name="inputPhone" value="<?php echo $phone ?? ''?>">
            </div>
            <?php if (!empty($errors_phone)): ?>
                <div class="text-error alert-danger-phone">
                    <?php foreach ($errors_phone as $error): ?>
                        <?php echo $error; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="city" class="form-label">Город</label>
                <select class="form-select" id="city" name="city">
                    <option selected value="Москва">Москва</option>
                    <option value="Санкт-Петербург">Санкт-Петербург</option>
                    <option value="Тула">Тула</option>
                </select>
            </div>

            <div class="text-error">
                <?php echo $error_token; ?>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Отправить</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/imask"></script>
    <script>
        const element = document.getElementById('inputPhone');
        const maskOptions = {
            mask: '+{7} 000 000-00-00'
        };
        const mask = IMask(element, maskOptions);

        let alertsDanger = document.querySelectorAll(".text-error");
        console.log(alertsDanger);

        alertsDanger.forEach((alertDanger)=>{
            if(alertDanger.classList.contains('alert-danger-fio')){
                let inputFio = document.querySelector("#inputFIO");
                inputFio.classList.add("is-invalid");
            }
            if(alertDanger.classList.contains('alert-danger-email')){
                let inputEmail = document.querySelector("#inputEmail");
                inputEmail.classList.add("is-invalid");
            }
            if(alertDanger.classList.contains('alert-danger-phone')){
                let inputPhone = document.querySelector("#inputPhone");
                inputPhone.classList.add("is-invalid");
            }
        });
    </script>
</body>
</html>