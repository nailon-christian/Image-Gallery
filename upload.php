<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Check if file was uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        $filesize = $_FILES['image']['size'];

        // Validate file extension
        if (!in_array(strtolower($filetype), $allowed)) {
            die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Validate file size - 5MB max
        if ($filesize > 5 * 1024 * 1024) {
            die("Error: File size is larger than 5MB.");
        }

        // Rename file to avoid overwriting
        $newfilename = uniqid('', true) . "." . $filetype;

        // Move the file to uploads folder
        if (move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $newfilename)) {
            // Insert into database
            $sql = "INSERT INTO gallery (image, title, description) VALUES ('$newfilename', '$title', '$description')";
            if (mysqli_query($conn, $sql)) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error: Could not save to database.";
            }
        } else {
            echo "Error: Failed to move uploaded file.";
        }
    } else {
        echo "Error: " . $_FILES['image']['error'];
    }
} else {
    header("Location: index.php");
    exit();
}
?>
