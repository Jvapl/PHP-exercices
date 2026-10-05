<?php
/**
 * Get the values from the GET parameters with filter_input function
 */
    (string) $msgParameter = " ";
    (string) $name = filter_input(INPUT_GET, 'name') ?? null;
    (string) $age = filter_input(INPUT_GET, 'age') ?? null;
    $parsed_info = 'No query parameters found';
    if ($name && $age) {
        $parsed_info = "{$name} is {$age} years old";
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>URL query parameters</title>
</head>
<body>

<!-- Display parameters here in a h1 tag -->
    <h1><?=$parsed_info?></h1>
<!-- Display message in list element in case of missing parameters -->
    <?php if(!$name || !$age): ?>
        <ul>
            <?php if(empty($name)): ?>
                <li>Missing name</li>
            <?php endif; ?>
            <?php if(empty($age)): ?>
                <li>Missing age</li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
