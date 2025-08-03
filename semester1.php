<?php
require_once 'admin/config.php';

function getMaterialsByType($conn, $semester, $type) {
  $stmt = $conn->prepare("SELECT title, link FROM materials WHERE semester = ? AND type = ? ORDER BY created_at DESC");
  $stmt->bind_param("is", $semester, $type);
  $stmt->execute();
  return $stmt->get_result();
}

$semester = 1;
$books = getMaterialsByType($conn, $semester, 'book');
$videos = getMaterialsByType($conn, $semester, 'video');
$assignments = getMaterialsByType($conn, $semester, 'assignment');
$pyqs = getMaterialsByType($conn, $semester, 'pyq');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semester 1 - IGNOU BCA CMS</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(to right, #dfe9f3, #ffffff);
    color: #333;
  }
</style>

</head>
<body>
<header class="bg-dark text-white text-center py-4">
  <h1>Semester 1 Resources</h1>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid justify-content-center">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
      </ul>
    </div>
  </nav>
</header>

<main class="container my-5">
  <div class="accordion" id="semesterAccordion">

    <!-- Books -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingBooks">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBooks">
           Books / Study Materials
        </button>
      </h2>
      <div id="collapseBooks" class="accordion-collapse collapse show" data-bs-parent="#semesterAccordion">
        <div class="accordion-body">
          <ul class="list-group">
            <?php while ($row = $books->fetch_assoc()): ?>
              <li class="list-group-item"><a href="<?= $row['link'] ?>" target="_blank"><?= $row['title'] ?></a></li>
            <?php endwhile; ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- Videos -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingVideos">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVideos">
           YouTube Lectures
        </button>
      </h2>
      <div id="collapseVideos" class="accordion-collapse collapse" data-bs-parent="#semesterAccordion">
        <div class="accordion-body">
          <ul class="list-group">
            <?php while ($row = $videos->fetch_assoc()): ?>
              <li class="list-group-item"><a href="<?= $row['link'] ?>" target="_blank"><?= $row['title'] ?></a></li>
            <?php endwhile; ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- Assignments -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingAssignments">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAssignments">
           Assignments
        </button>
      </h2>
      <div id="collapseAssignments" class="accordion-collapse collapse" data-bs-parent="#semesterAccordion">
        <div class="accordion-body">
          <ul class="list-group">
            <?php while ($row = $assignments->fetch_assoc()): ?>
              <li class="list-group-item"><a href="<?= $row['link'] ?>" target="_blank"><?= $row['title'] ?></a></li>
            <?php endwhile; ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- PYQs -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingPYQ">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePYQ">
           Previous Year Questions
        </button>
      </h2>
      <div id="collapsePYQ" class="accordion-collapse collapse" data-bs-parent="#semesterAccordion">
        <div class="accordion-body">
          <ul class="list-group">
            <?php while ($row = $pyqs->fetch_assoc()): ?>
              <li class="list-group-item"><a href="<?= $row['link'] ?>" target="_blank"><?= $row['title'] ?></a></li>
            <?php endwhile; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</main>

<footer class="bg-dark text-white text-center py-3">
  <p>&copy; 2025 IGNOU BCA CMS</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
