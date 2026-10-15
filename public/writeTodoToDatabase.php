<?php

/**
 * On this page, you will create a simple form that allows user to create todos (with a name and a date).
 * The form should be submitted to this PHP page.
 * Then get the inputs from the post request with `filter_input`.
 * Then, the PHP code should verify the user inputs (minimum length, valid date that is today or in the future)
 * If the user input is valid, insert the new todo information in the sqlite database
 * table `todos` columns `title` and `due_date`. Then redirect the user to the list of todos.
 * If the user input is invalid, display an error to the user
 */

$errors = [];
$title = '';
$date = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = trim((string) filter_input(INPUT_POST, 'name', FILTER_UNSAFE_RAW));
    $date = trim((string) filter_input(INPUT_POST, 'date', FILTER_UNSAFE_RAW));

    if (mb_strlen($title) < 3){
        $errors[] = 'This title must have 3 characters minimum';
    }
    
    $dueDate = DatetimeImmutable::createFromFormat('Y-m-d', $date);

    if (($dueDate < new DateTimeImmutable('today'))){
        $errors[] = "This date must be on the future";
    }   

    if (empty($errors)){
        
$pdo = new PDO("sqlite:" . __DIR__ . "/../database.db");
        $stmt = $pdo->prepare('INSERT INTO todos (title, due_date) VALUES (?, ?)');
        $stmt->execute([$title,$date]);
        header('Location: /displayAllTodosFromDatabase.php');
        exit;
        }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create a new todo</title>
</head>
<body>

<h1>
    Create a new todo
</h1>
<!-- WRITE YOUR HTML AND PHP TEMPLATING HERE -->
 <?php foreach ($errors as $error):?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
 <?php endforeach?>
    <form action="writeTodoToDatabase.php" method="POST">
        <label for="inputTitle">Title :</label>
        <input id="inputTitle" name="name" type="text" value="<?= htmlspecialchars($title) ?>">
        <label for="inputDate">Date :</label>
        <input id="inputDate" name="date" type="date" value="<?= htmlspecialchars($date) ?>">
        <button type="submit">Submit</button>
    </form>
</body>
</html>