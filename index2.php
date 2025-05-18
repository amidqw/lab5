<?php

$isSubmitted = $_SERVER["REQUEST_METHOD"] === "POST";
$errors = [];
$result = [];

if ($isSubmitted) {
    
    $name = trim($_POST["name"] ?? '');
    $age = $_POST["age"] ?? '';
    $sport = $_POST["sport"] ?? '';
    $gender = $_POST["gender"] ?? '';
    $agree = $_POST["agree"] ?? '';

    
    if (empty($name)) $errors[] = "Введите имя.";
    if (empty($age) || $age < 10 || $age > 100) $errors[] = "Возраст должен быть от 10 до 100.";
    if (empty($sport)) $errors[] = "Выберите вид спорта.";
    if (empty($gender)) $errors[] = "Выберите пол.";
    if ($agree !== 'yes') $errors[] = "Необходимо согласиться с правилами.";

    
    if (empty($errors)) {
        $result = [
            "Имя" => htmlspecialchars($name),
            "Возраст" => htmlspecialchars($age),
            "Вид спорта" => htmlspecialchars($sport),
            "Пол" => htmlspecialchars($gender),
            "Согласие с правилами" => "Да"
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация на спортивное мероприятие</title>
</head>
<body>
    <h2>Регистрация на спортивное мероприятие</h2>
    <form method="POST" action="">
        <label>Имя:
            <input type="text" name="name" value="<?php echo $_POST["name"] ?? ''; ?>">
        </label><br><br>

        <label>Возраст:
            <input type="number" name="age" min="10" max="100" value="<?php echo $_POST["age"] ?? ''; ?>">
        </label><br><br>

        <label>Выберите вид спорта:
            <select name="sport">
                <option value="">-- Выберите --</option>
                <option value="Футбол" <?php if ($_POST["sport"] ?? '' === 'Футбол') echo 'selected'; ?>>Футбол</option>
                <option value="Баскетбол" <?php if ($_POST["sport"] ?? '' === 'Баскетбол') echo 'selected'; ?>>Баскетбол</option>
                <option value="Бег" <?php if ($_POST["sport"] ?? '' === 'Бег') echo 'selected'; ?>>Бег</option>
            </select>
        </label><br><br>

        <label>Пол:</label><br>
        <input type="radio" name="gender" value="Мужской" <?php if ($_POST["gender"] ?? '' === 'Мужской') echo 'checked'; ?>> Мужской<br>
        <input type="radio" name="gender" value="Женский" <?php if ($_POST["gender"] ?? '' === 'Женский') echo 'checked'; ?>> Женский<br><br>

        <label>
            <input type="checkbox" name="agree" value="yes" <?php if (isset($_POST["agree"])) echo 'checked'; ?>>
            Я согласен с правилами участия
        </label><br><br>

        <input type="submit" value="Зарегистрироваться">
    </form>

    <?php if ($isSubmitted): ?>
        <?php if (!empty($errors)): ?>
            <div style="color: red;">
                <h3>Ошибки:</h3>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <h3>Данные успешно отправлены:</h3>
            <ul>
                <?php foreach ($result as $key => $val): ?>
                    <li><strong><?php echo $key; ?>:</strong> <?php echo $val; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
