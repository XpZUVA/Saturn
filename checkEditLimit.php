<?php
include_once 'inc/ini.php';

$id = $_GET['id'];

if (hasExceededEditLimit($conn, $id)) {
    echo json_encode(['redirect' => true]);
    exit;
}

echo json_encode(['redirect' => false]);

?>

<?php include_once 'inc/end.php'; ?>
