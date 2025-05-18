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
