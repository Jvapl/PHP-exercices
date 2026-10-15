<?php

/**
 * Get the todos from the sqlite database, and display them in a list.
 * You need to add a sort query parameter to the page to order by date or name.
 * If the query parameter is not set, the todos should be displayed in the order they were added.
 * If the request to the database fails, display an error message.
 * If the user wants to delete a todo, a form that sends a POST request to the deleteTodoFromDatabase.php page should be displayed on each todo elements.
 * The sort option selected must be remembered after the form submission (use a query parameter).
 * The todo title and date should be displayed in a list (date in american format).
 */

$errors = [];
$todos = [];
$sort = filter_input(INPUT_GET, 'sort', FILTER_UNSAFE_RAW);

$query = "SELECT * FROM todos";

if ($sort === "name"){
    $query = 'SELECT * FROM todos ORDER BY title ASC';
} elseif ($sort === "date") {
    $query = 'SELECT * FROM todos ORDER BY due_date ASC';
}

try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/../database.db");
    $stmt = $pdo->query($query);
    $todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errors[] = "Something went wrong" . $e;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List of todos</title>
</head>
<body>

<h1>
    All todos
</h1>

<a href="writeTodoToDatabase.php">Ajouter une nouvelle todo</a>

<!-- WRITE YOUR HTML AND PHP TEMPLATING HERE -->

<div>
    <span>Sort by: </span>
    <a href="?sort=name">Name</a>
    <a href="?sort=date">Date</a>
    <a href="displayAllTodosFromDatabase.php">Default</a>
</div>
<?php foreach ($errors as $error):?>
    <?= htmlspecialchars($error)?>
<?php endforeach?>
<ul>
    <?php foreach ($todos as $todo) :?>
        <li>
            <?= htmlspecialchars($todo['title'])?><br>
            <?= htmlspecialchars(new DateTimeImmutable($todo['due_date'])->format('m/d/Y')
                )?>
        </li>
    <?php endforeach?>
</ul>

</body>
</html>
