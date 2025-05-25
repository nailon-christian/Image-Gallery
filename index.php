<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>Simple Image Gallery</title>
  <link rel="stylesheet" href="style.css" />

  <!-- Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #ecfdf5; /* Light emerald background */
        font-family: Arial, sans-serif;
    }
    .navbar {
        background-color: #10b981 !important; /* Emerald green navbar */
    }
    .navbar-brand, .nav-link, .navbar-text {
        color: white !important;
    }
    .card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .btn-emerald {
        background-color: #10b981;
        color: white;
        border: none;
    }
    .btn-emerald:hover {
        background-color: #059669;
    }
</style>

</head>
<body>
  <nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">Image Gallery</a>
  </div>
</nav>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-6">

  <h2>Upload Image</h2>
  <form action="upload.php" method="POST" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" name="title" required><br>

    <label for="description">Description:</label>
    <textarea name="description" required></textarea><br>

    <label for="image">Choose Image:</label>
    <input type="file" name="image" id="imageInput" accept="image/*" onchange="previewImage()" required><br><br>

    <!-- Preview Image -->
    <img id="preview" src="#" alt="Image Preview" style="display:none; max-width: 300px; margin-bottom: 10px;"><br>

    <button type="submit" class="btn btn-emerald">Upload</button>

</form>

  </div>
    <div class="col-md-6">

  <h2>Gallery</h2>
  <div class="gallery">
    <?php
      $result = mysqli_query($conn, "SELECT * FROM gallery ORDER BY uploaded_at DESC");
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="gallery-item">';
        echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '" />';
        echo '<h4>' . htmlspecialchars($row['title']) . '</h4>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '</div>';
      }
    ?>

    <?php
$conn = new mysqli("localhost", "root", "", "image_gallery");
$sql = "SELECT * FROM gallery ORDER BY created_at DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<div>";
    echo "<img src='uploads/{$row['image']}' width='200'><br>";
    echo "<strong>{$row['title']}</strong><br>";
    echo "<p>{$row['description']}</p>";

    // 🔴 DELETE button
    echo "<form action='delete.php' method='POST' onsubmit='return confirm(\"Are you sure?\")'>";
    echo "<input type='hidden' name='id' value='{$row['id']}'>";
    echo "<button type='submit'>Delete</button>";
    echo "</form>";

    echo "<hr>";
}
$conn->close();
?>

  </div>
</div>
  </div>
</div>

  <script>
function previewImage() {
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('preview');

    const file = input.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }
}
</script>

</body>
</html>
