<?php
$conn = new mysqli("localhost", "root", "", "image_gallery");

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Get image filename first
    $stmt = $conn->prepare("SELECT image FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    // Delete image from folder
    if ($image && file_exists("uploads/$image")) {
        unlink("uploads/$image");
    }

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: index.php");
exit();
?>
