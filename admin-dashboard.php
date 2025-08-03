<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: admin-login.php');
    exit;
}
require_once 'config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $semester = $_POST['semester'];
    $course_code = $_POST['course_code'];
    $type = $_POST['type'];
    $title = $_POST['title'];
    $link = $_POST['link'];

    $stmt = $conn->prepare("INSERT INTO materials (semester, course_code, type, title, link) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $semester, $course_code, $type, $title, $link);
    $stmt->execute();
    $stmt->close();
    $success = "Material added successfully!";
}

// Fetch all materials
$materials = $conn->query("SELECT * FROM materials ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="mb-0">Welcome, Midhat</h2>
  <a href="admin-logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>
<h4 class="mb-4">Add Study Material</h4>

    

    <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label">Semester</label>
        <select name="semester" class="form-select" required>
          <option value="1">Semester 1</option>
          <option value="2">Semester 2</option>
          <option value="3">Semester 3</option>
          <option value="4">Semester 4</option>
          <option value="5">Semester 5</option>
          <option value="6">Semester 6</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Course Code</label>
        <input type="text" name="course_code" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Material Type</label>
        <select name="type" class="form-select" required>
          <option value="book">Book</option>
          <option value="video">YouTube Video</option>
          <option value="assignment">Assignment</option>
          <option value="pyq">Previous Year Question</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Link</label>
        <input type="url" name="link" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Add Material</button>
    </form>

    <hr class="my-5">

    <h3 class="mb-3">All Materials</h3>
    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Semester</th>
          <th>Course</th>
          <th>Type</th>
          <th>Title</th>
          <th>Link</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $materials->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['semester'] ?></td>
            <td><?= $row['course_code'] ?></td>
            <td><?= ucfirst($row['type']) ?></td>
            <td><?= $row['title'] ?></td>
            <td><a href="<?= $row['link'] ?>" target="_blank">View</a></td>
            <td>
              <a href="admin-edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="admin-delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this entry?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
