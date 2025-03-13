<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1>ToDoList</h1>


<?php

$filename = 'file.txt';


if(file_exists($filename))
{
    $data = file_get_contents($filename);
}



if (!empty($data)) {
    $data = explode("\n", trim($data));
} else 
{
    $data = [];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) && !empty(trim($_POST['name']))) {
        $task = trim($_POST["name"]); 
        $data[] = $task;
        file_put_contents($filename, implode("\n", $data));
        header ("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    }


?>
<form method="POST">
    <label for="name">What to do:</label>
    <input type="text" id="name" name="name"require>
    <button type="submit">Save</button>
</form>
<h3>You need to</h3>

<ul>



<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {
    $indexToRemove = (int) $_POST['remove'];
    if (isset($data[$indexToRemove])) {
        unset($data[$indexToRemove]);
        $data = array_values($data);
        file_put_contents($filename, implode("\n", $data));
    }
    header ("Location: " . $_SERVER["PHP_SELF"]);}
    foreach ($data as $index => $do ):
    ?>




    <li>
        <?=htmlspecialchars($do)?>
        <form method="POST" style="display:inline;">
                <input type="hidden" name="remove" value="<?= $index ?>">
                <button type="submit">Remove</button>
            </form>
    </li>
<?php endforeach;?>
</ul>

</body>
</html>