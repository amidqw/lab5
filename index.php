<?php

$name = $email = $review = $comment = "";
$errors = [];
$isSubmitted = $_SERVER["REQUEST_METHOD"] === "POST";

if ($isSubmitted) {
  
    $name = trim($_POST["name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $review = $_POST["review"] ?? '';
    $comment = trim($_POST["comment"] ?? '');

    
    if (empty($name)) $errors[] = "Поле 'Имя' обязательно.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Введите корректный email.";
    if (empty($review)) $errors[] = "Пожалуйста, оцените сервис.";
    if (empty($comment)) $errors[] = "Поле 'Комментарий' обязательно.";
}
?>

<div class="form">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <fieldset>
            <legend>Оставьте отзыв!</legend>
            <div id="main_info" style="display: flex; flex-direction: column; gap: 10px;">
                <div>
                    <label for="name">Имя:
                        <input type="text" name="name"/>
                    </label>
                </div>
                <div>
                    <label for="email">Email:
                        <input type="email" name="email"/>
                    </label>
                </div>
            </div>
            <div id="extra_info">
                <div>
                    <p><label for="review">Оцените наш сервис!</label></p>
                    <div style="display: flex; flex-direction: column;">
                        <p><input id="review" type="radio" name="review" value="10" checked>Хорошо</p>
                        <p><input id="review" type="radio" name="review" value="8">Удовлетворительно</p>
                        <p><input id="review" type="radio" name="review" value="5">Плохо</p>
                    </div>
                </div>
            </div>
            <div id="message_info">
                <div>
                    <p><label for="comment">Ваш комментарий: </label></p>
                    <textarea id="comment" name="comment" cols="30" rows="10" class="comment"></textarea>
                </div>
            </div>
            <div id="buttons" style="display: flex; flex-direction: row; gap: 10px; margin-top: 10px;">
                <input type="submit" value="Отправить"/>
                <input type="reset" value="Удалить"/>
            </div>
        </fieldset>
    </form>

    <?php if ($isSubmitted): ?>
        <?php if (!empty($errors)): ?>
            <div style="color: red;">
                <h4>Ошибки:</h4>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
             <div id="result">
        <p>Ваше имя: <b><?php echo $_POST["name"] ?? ''; ?></b></p>
        <p>Ваш e-mail: <b><?php echo $_POST["email"] ?? ''; ?></b></p>
        <p>Оценка товара: <b><?php echo $_POST["review"] ?? ''; ?></b></p>
        <p>Ваше сообщение: <b><?php echo $_POST["comment"] ?? ''; ?></b></p>
    </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
