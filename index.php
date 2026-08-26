<?php
require_once('config/config.php');

$user_id = "root";
$user_email = "root";

$buttons = [
    'login',
    'logout',
    'create Record',
    'update Record',
    'delete Record',
    'view Record',
    'upload File',
    'Download',
    'Search',
    'Generate Report',
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logger Test</title>
</head>
<body>

<table border="1" cellpadding="10">
    <tr>
        <th>Action</th>
        <th>Test</th>
    </tr>

    <?php foreach ($buttons as $button): ?>
    <tr>
        <td><?= htmlspecialchars($button); ?></td>
        <td>
            <form method="post">
                <input
                    type="hidden"
                    name="action"
                    value="<?= htmlspecialchars($button); ?>"
                >
                <button type="submit">Test</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){

$action = $_POST['action'] ?? "test_activity";

$status = random_int(0,1) === 1? 'success' : 'failed';

$success = logActivity(
    $pdo,
    $user_id,
    $user_email,
    $action,
    $status
);
if($success){
    echo "<p> Activity: ". htmlspecialchars($action) .
    "status: ". htmlspecialchars($status) .
     " logged successfully!</p>";


} else {
    echo "Failed to insert activity log!";
}
}
?>