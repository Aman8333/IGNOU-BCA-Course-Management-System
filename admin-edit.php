<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: admin-login.php');
    exit;
}
require_once 'config.php';

// Get material ID from URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: admin-dashboard.php');
    exit;
}

// Handle update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $semester = $_POST['semester'];
    $course_code = $_POST['course_code'];
    $type = $_POST['type'];
    $title = $_POST['title'];
    $link = $_POST['link'];

    $stmt = $conn->prepare("UPDATE materials SET semester=?, course_code=?, type=?, title=?, link=? WHERE id=?");
    $stmt->bind_param("issssi", $semester, $course_code, $type, $title, $link, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin-dashboard.php");
    exit;
}

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM materials WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Material</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2>Edit Material</h2>
    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label">Semester</label>
        <select name="semester" class="form-select" required>
          <?php for ($i = 1; $i <= 6; $i++): ?>
            <option value="<?= $i ?>" <?= $data['semester'] == $i ? 'selected' : '' ?>>Semester <?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Course Code</label>
        <input type="text" name="course_code" class="form-control" value="<?= $data['course_code'] ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Material Type</label>
        <select name="type" class="form-select" required>
          <?php
            $types = ['book', 'video', 'assignment', 'pyq'];
            foreach ($types as $type):
          ?>
            <option value="<?= $type ?>" <?= $data['type'] == $type ? 'selected' : '' ?>><?= ucfirst($type) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?= $data['title'] ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Link</label>
        <input type="url" name="link" class="form-control" value="<?= $data['link'] ?>" required>
      </div>

      <button type="submit" class="btn btn-success">Update Material</button>
      <a href="admin-dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>
