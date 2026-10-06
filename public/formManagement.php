<?php

/**
 * On this page, you should display a form with two fields, one for the Name and one for the Age.
 * The server should respond to the form submission by displaying the same page with the name and age in a h1 "Toto is 20 years old".
 * If there is no submission or only one of the two fields, the h1 should display "Submit the form".
 * If the user have a name with more than 6 characters, the name must be displayed in red (only the name, not all h1).
 * If the user is more than 18 years old, you should display a list with one line per year of the age of the user.
 * The data submitted should remain displayed in the form after the submission.
 * (Your form should be semantically correct, use a label and name your fields)
 */

(string) $name = filter_input(INPUT_GET, 'name');
(string) $age  = filter_input(INPUT_GET, 'age');

$isSubmitted = $name !== '' && $age !== '' && $age;
$ageInt = $isSubmitted ? $age : 0;

function userInformation($value)
{
    return htmlspecialchars($value, ENT_QUOTES);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form management</title>
</head>
<body>

<form action="" method="get">
    <label for="inputName">Name</label>
    <input id="inputName" name="name" type="text" value="<?= userInformation($name) ?>">

    <label for="inputAge">Age</label>
    <input id="inputAge" name="age" type="number" min="0" value="<?= userInformation($age) ?>">

    <button type="submit">Submit</button>
</form>

<h1>
    <?php if ($isSubmitted): ?>
        <?php if (mb_strlen($name) > 6): ?>

            <span style="color: red;"><?= userInformation($name) ?></span>
        <?php else: ?>
            <?= userInformation($name) ?>

        <?php endif; ?>
        is <?= $ageInt ?> years old
    <?php else: ?>
        Submit the form
    <?php endif; ?>
</h1>

<?php if ($isSubmitted && $ageInt > 18): ?>

    <ul>
        <?php for ($i = 1; $i <= $ageInt; $i++): ?>
            <li><?= $i ?></li>
        <?php endfor; ?>
    </ul>
<?php endif; ?>

</body>
</html>
