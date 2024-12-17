<?php
session_start();

require_once("settings.php");
require_once("Application/DTO/RegistrationRequest.php");

$message = '';

use application\dto\RegistrationRequest;

if(!empty($_POST["registrationButton"])) {
    try {
        $registrationInfo = new RegistrationRequest(
            htmlspecialchars($_POST["username"]),
            htmlspecialchars($_POST["email"]),
            htmlspecialchars($_POST["password"])
        );

        $accountService->register($registrationInfo);
        $_SESSION['username'] = $registrationInfo->username;
        header("Location: http://localhost:3000/chat/chat.php");
        exit();
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .registration-container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h2 class="text-center">Регистрация</h2>

        <?php if ($message): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Имя пользователя</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button name="registrationButton" value="ImClicked" type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
        </form>
        <div class="text-center mt-3">
            <a href="login.html">Уже есть аккаунт? Войдите!</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
