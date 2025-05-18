# lab5 Пономарь Дмитрий
## 1. Инструкции по запуску проекта
1. Скачайте проект и разместите файлы в директории веб-сервера:
`git clone https://github.com/ваш-репозиторий.git`
2. Запустите сервер:
   `php -S localhost:8000`
4. Откройте в браузере:
   `http://localhost:8000`
   
## 2. Описание лабораторной работы   

__Цель:__ Познакомиться с глобальной переменной $_POST и обработкой данных из форм в PHP. Научиться валидировать пользовательские данные, работать с различными типами элементов формы, а также анализировать различия между $_REQUEST и $_POST.

## 3. Краткая документация к проекту 

<table>
    <tr>
        <th>Файл</th>
        <th>Описание</th>
    </tr>
    <tr>
        <td>index.php</td>
        <td>Решение 1 задания</td>
    </tr>
    <tr>
       <td>index2.php</td>
      <td>Решение 2 задания </td>
    </tr>
     <tr>
          <td>index3.php</td>
      <td>Решение 3 задания </td>
    </tr>
   <tr>
          <td>index4.php</td>
      <td>Решение 4 задания </td>
    </tr>
</table>

## 4. Примеры использования проекта с приложением скриншотов или фрагментов кода

1. Работа с глобальной переменной $_POST
   Объясните, что такое глобальные переменные $_POST и $_SERVER["PHP_SELF"].

$_POST - суперглобальный массив, содержащий данные, отправленные медотом POST.

$_SERVER["PHP_SELF"]- возвращает путь к текущему скрипту, используется как action формы, чтобы отправить форму на ту же страницу

   ```php
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
   ```
Скриншот:
![image](https://github.com/user-attachments/assets/15850af7-00c8-4498-8a9d-f860926d3ddb)



2. Получение данных с различных контроллеров

 ```php
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
```
Скриншот:
![image](https://github.com/user-attachments/assets/990d6e4d-e5b6-45d8-9266-1294beec7ac1)


3. Создание, обработка и валидация форм
 Объясните, чем отличаются глобальные переменные $_REQUEST и $_POST.

$_REQUEST - Объединяет $_GET, $_POST B $_COOKIE. Имеет проблемы с безопасностью.

$_POST - массив, содержащий данные из формы, отправленные методом POST.

```php
<?php
$name = $email = $comment = '';
$agree = false;
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['mail'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    $agree = isset($_POST['agree']);

   
    if (strlen($name) < 3 || strlen($name) > 20) {
        $errors[] = "Name must be between 3 and 20 characters.";
    }
    if (preg_match('/\\d/', $name)) {
        $errors[] = "Name cannot contain numbers.";
    }

    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    
    if (empty($comment)) {
        $errors[] = "Comment cannot be empty.";
    }

   
    if (!$agree) {
        $errors[] = "You must agree with data processing.";
    }

    $success = empty($errors);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Write Comment</title>
    <style>
        body { font-family: monospace; }
        .form-container { width: 400px; padding: 20px; }
        .form-field { margin-bottom: 10px; }
        .error { color: red; }
        .success { color: green; margin-top: 10px; }
        .header { background: #ccc; padding: 10px; display: flex; justify-content: space-between; }
    </style>
</head>
<body>

<div class="header">
    <div>#my-shop</div>
    <div>
        <button>Home</button>
        <button>Comments</button>
        <button>Exit</button>
    </div>
</div>

<div class="form-container">
    <h3>#write-comment</h3>
    <form method="POST" action="">
        <div class="form-field">
            <label>Name:<br>
                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
            </label>
        </div>
        <div class="form-field">
            <label>Mail:<br>
                <input type="text" name="mail" value="<?php echo htmlspecialchars($email); ?>">
            </label>
        </div>
        <div class="form-field">
            <label>Comment:<br>
                <textarea name="comment" cols="30" rows="5"><?php echo htmlspecialchars($comment); ?></textarea>
            </label>
        </div>
        <div class="form-field">
            <label>
                <input type="checkbox" name="agree" <?php echo $agree ? 'checked' : ''; ?>>
                Do you agree with data processing?
            </label>
        </div>
        <input type="submit" value="Send">
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif ($success): ?>
            <div class="success">
                Thank you for your comment!
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>


 ```
Скриншот:
![image](https://github.com/user-attachments/assets/52dd4d70-70c8-4bc3-b1e0-790a02d71c21)

![image](https://github.com/user-attachments/assets/6211b0b4-b80e-43aa-87f4-7489812b32e2)




4. Создание теста
   
  ```php
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

    // Валидация
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



   ```
Скриншот:
![image](https://github.com/user-attachments/assets/15cf8649-bcf5-4756-a3ed-5f7ab9889c04)
![image](https://github.com/user-attachments/assets/dcf960d9-e821-4232-91d3-8b2e4285ed36)


## 5. Ответы на контрольные вопросы

$_POST - суперглобальный массив, содержащий данные, отправленные медотом POST.
$_REQUEST - Объединяет $_GET, $_POST B $_COOKIE. Имеет проблемы с безопасностью.

## 6. Список использованных источников

https://metanit.com/php/tutorial/3.4.php

https://www.php.net/manual/ru/tutorial.forms.php
