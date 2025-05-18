<?php
$name = '';
$errors = [];
$result = [];
$answers = [
    'q1' => 'Париж',
    'q2' => '4',
    'q3' => ['Python', 'PHP', 'JavaScript']
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["username"] ?? '');
    $q1 = $_POST["q1"] ?? '';
    $q2 = $_POST["q2"] ?? '';
    $q3 = $_POST["q3"] ?? [];

 
    if (empty($name)) $errors[] = "Введите имя.";
    if (empty($q1)) $errors[] = "Ответьте на вопрос 1.";
    if (empty($q2)) $errors[] = "Ответьте на вопрос 2.";
    if (empty($q3)) $errors[] = "Выберите хотя бы один вариант в вопросе 3.";

    if (empty($errors)) {
        sort($q3);
        sort($answers['q3']);

        $result = [
            'Имя' => htmlspecialchars($name),
            'q1' => [
                'question' => '1. Столица Франции?',
                'user' => $q1,
                'correct' => $answers['q1']
            ],
            'q2' => [
                'question' => '2. Сколько будет 2 + 2?',
                'user' => $q2,
                'correct' => $answers['q2']
            ],
            'q3' => [
                'question' => '3. Какие языки программирования являются интерпретируемыми?',
                'user' => $q3,
                'correct' => $answers['q3']
            ]
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тест</title>
    <style>
        body { font-family: sans-serif; }
        .error { color: red; }
        .correct { color: green; }
        .wrong { color: red; }
        .result { margin-top: 20px; }
    </style>
</head>
<body>

<h2>Мини-тест</h2>

<form method="POST">
    <label>Ваше имя:<br>
        <input type="text" name="username" value="<?php echo htmlspecialchars($name); ?>">
    </label><br><br>

    <p><strong>1. Столица Франции?</strong></p>
    <label><input type="radio" name="q1" value="Париж" <?php if (($q1 ?? '') === 'Париж') echo 'checked'; ?>> Париж</label><br>
    <label><input type="radio" name="q1" value="Берлин" <?php if (($q1 ?? '') === 'Берлин') echo 'checked'; ?>> Берлин</label><br>
    <label><input type="radio" name="q1" value="Мадрид" <?php if (($q1 ?? '') === 'Мадрид') echo 'checked'; ?>> Мадрид</label><br><br>

    <p><strong>2. Сколько будет 2 + 2?</strong></p>
    <label><input type="radio" name="q2" value="4" <?php if (($q2 ?? '') === '4') echo 'checked'; ?>> 4</label><br>
    <label><input type="radio" name="q2" value="5" <?php if (($q2 ?? '') === '5') echo 'checked'; ?>> 5</label><br><br>

    <p><strong>3. Какие языки программирования являются интерпретируемыми? (можно несколько)</strong></p>
    <label><input type="checkbox" name="q3[]" value="Python" <?php if (!empty($q3) && in_array("Python", $q3)) echo 'checked'; ?>> Python</label><br>
    <label><input type="checkbox" name="q3[]" value="PHP" <?php if (!empty($q3) && in_array("PHP", $q3)) echo 'checked'; ?>> PHP</label><br>
    <label><input type="checkbox" name="q3[]" value="JavaScript" <?php if (!empty($q3) && in_array("JavaScript", $q3)) echo 'checked'; ?>> JavaScript</label><br>
    <label><input type="checkbox" name="q3[]" value="C++" <?php if (!empty($q3) && in_array("C++", $q3)) echo 'checked'; ?>> C++</label><br><br>

    <input type="submit" value="Отправить">
</form>

<?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <h3>Ошибки:</h3>
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?php echo $err; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif (!empty($result)): ?>
        <div class="result">
            <h3>Результаты теста:</h3>
            <p><strong>Имя:</strong> <?php echo $result['Имя']; ?></p>
            <ul>
                <li>
                    <?php
                        $ok = $result['q1']['user'] === $result['q1']['correct'];
                        echo $result['q1']['question'] . ": ";
                        echo "<span class='" . ($ok ? "correct" : "wrong") . "'>" . $result['q1']['user'] . "</span>";
                    ?>
                </li>
                <li>
                    <?php
                        $ok = $result['q2']['user'] === $result['q2']['correct'];
                        echo $result['q2']['question'] . ": ";
                        echo "<span class='" . ($ok ? "correct" : "wrong") . "'>" . $result['q2']['user'] . "</span>";
                    ?>
                </li>
                <li>
                    <?php
                        sort($result['q3']['user']);
                        $ok = $result['q3']['user'] === $result['q3']['correct'];
                        echo $result['q3']['question'] . ": ";
                        echo "<span class='" . ($ok ? "correct" : "wrong") . "'>" . implode(", ", $result['q3']['user']) . "</span>";
                    ?>
                </li>
            </ul>
        </div>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
