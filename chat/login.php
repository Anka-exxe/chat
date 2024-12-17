<?php
    session_start();

    require_once("settings.php");
    require_once("Application/DTO/LoginRequest.php");
    use application\dto\LoginRequest;

    $loginInfo = new LoginRequest(
        htmlspecialchars($_POST['username']),
        htmlspecialchars($_POST['password'])
    );

    if ($accountService->logIn($loginInfo)) {
        $_SESSION['username'] = $loginInfo->username;
        header("Location: http://localhost:3000/chat/chat.php");
        exit();
    } else {
        header("Location: http://localhost:3000/chat/login.html");
        exit();
    }
?>
