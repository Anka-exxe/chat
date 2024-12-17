<?php
session_start();
require_once("settings.php");

if(!empty($_SESSION['username'])) {
    $userEmail = $accountService->getEmailByUserName($_SESSION['username']);
} else {
    $userEmail = null;
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 25; 
$offset = ($page - 1) * $limit;

$sortType = $_GET['sort'] ?? " ";

switch($sortType) {
    case 'username': 
        $messages = $messageService->getMessages();
         usort($messages, function($a, $b) {
            return strcmp($a->username, $b->username); 
        });
        break;
    case 'email':
        $messages = $messageService->getMessages();
        usort($messages, function($a, $b) {
            return strcmp($a->email , $b->email); 
        });
        break;
    case 'dateOld':
        $messages = $messageService->getMessages();
        break;
    case 'dateYoung':
    default:
        $messages = array_reverse($messageService->getMessages());
}

$pageMessages = array_slice($messages, $offset, $limit);
$totalMessages = count($messages);
$totalPages = ceil($totalMessages / $limit);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чат</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        .message-table {
            margin-top: 20px;
        }
        .message-cell {
            white-space: normal; 
            max-width: 300px; 
            word-wrap: break-word; 
        }
    </style>
</head>
<body>
    <div class="container">
    <a href="login.html" style="font-weight: bold; font-size: 30px;">Вход</a>

        <h1 class="text-center">Чат</h1>
        
        <hr style="border: 1px solid #ccc; margin: 20px 0;">

        <form id="messageForm" action="submitMessage.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" id="username" name="username" value="<?= $_SESSION['username'] ?? "Необходим вход" ?>" disabled>
                <input type="text" id="username" name="username" value="<?= $_SESSION['username'] ?? "Нет данных" ?>" hidden>
                <input type="text" id="email" name="email" value=<?= $userEmail ?? "Нет данных" ?> disabled>

                <textarea class="form-control" id="text" name="text" required rows="3" placeholder="Введите сообщение"></textarea>
            </div>
            <div class="form-group">
                <label for="file">Прикрепить файл</label>
                <input type="file" class="form-control-file" id="file" name="file">
            </div>
            <button type="submit" class="btn btn-primary">Отправить сообщение</button>
        </form>

        <hr style="border: 1px solid #ccc; margin: 20px 0;">

        <form method="GET">
    <div class="form-group">
        <label for="sort">Сортировать по:</label>
        <select id="sort" name="sort" class="form-control">
            <option value="username">Имя пользователя</option>
            <option value="email">E-mail</option>
            <option value="dateOld">Дата добавления(сначала старые)</option>
            <option value="dateYoung">Дата добавления(сначала новые)</option>
        </select>
    </div>
    <button type="submit" name="sortButton" class="btn btn-primary">Сортировать</button>
</form>

        <table class="table table-bordered message-table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Пользователь</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Сообщение</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Прикреплённый файл</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pageMessages as $message): ?>
                     <tr>
                         <td><?= htmlspecialchars($message->username) ?></td>
                         <td><?= htmlspecialchars($message->email) ?></td>
                         <td class='message-cell'><?= htmlspecialchars($message->text) ?></td>
                         <td><?= htmlspecialchars($message->date) ?></td>
                         <?php if (!empty($message->attachmentUrl)): ?>
                             <td><a href='<?= htmlspecialchars($message->attachmentUrl) ?>'><?=str_replace('./Uploads/', '', $message->attachmentUrl) ?></a></td>
                         <?php else: ?>
                             <td></td>
                         <?php endif; ?>
                     </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&sort=<?= urlencode($sortType) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
