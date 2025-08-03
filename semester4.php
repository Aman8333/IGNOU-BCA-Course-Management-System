<?php
require_once 'admin/config.php';

function getMaterialsByType($conn, $semester, $type) {
  $stmt = $conn->prepare("SELECT title, link FROM materials WHERE semester = ? AND type = ? ORDER BY created_at DESC");
  $stmt->bind_param("is", $semester, $type);
  $stmt->execute();
  return $stmt->get_result();
}

$semester = 4;
$books = getMaterialsByType($conn, $semester, 'book');
$videos = getMaterialsByType($conn, $semester, 'video');
$assignments = getMaterialsByType($conn, $semester, 'assignment');
$pyqs = getMaterialsByType($conn, $semester, 'pyq');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Semester 4 Resources - IGNOU BCA CMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Optional: Your custom style.css -->
  <link rel="stylesheet" href="css/style.css">

  <style>
    body {
      background-color: #f8f9fa;
    }
    header, footer {
      background-color: #212529;
      color: white;
      padding: 20px 0;
    }
    header h1 {
      margin-bottom: 10px;
    }
    nav ul {
      list-style: none;
      padding-left: 0;
    }
    nav li {
      display: inline-block;
      margin: 0 10px;
    }
    nav a {
      color: #ddd;
      text-decoration: none;
    }
    nav a:hover {
      color: white;
    }
    .container {
      margin-top: 30px;
      margin-bottom: 60px;
    }
    footer p {
      margin: 0;
      text-align: center;
    }
  </style>
</head>
<body>

<!-- Header -->
<header class="text-center">
  <h1>Semester 4 Resources</h1>
  <nav>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="contact.html">Contact</a></li>
    </ul>
  </nav>
</header>

<!-- Main content -->
<div class="container">
  <div class="accordion" id="semester4Accordion">

    <!-- Books -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingBooks">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBooks" aria-expanded="true">
          Books / Study Materials
        </button>
      </h2>
      <div id="collapseBooks" class="accordion-collapse collapse show" data-bs-parent="#semester4Accordion">
        <div class="accordion-body">
          <ul class="list-group">
            <?php while ($row = $books->fetch_assoc()): ?>
              <li class="list-group-item">
                <a href="<?= $row['link'] ?>" target="_blank"><?= $row['title'] ?></a>
              </li>
            <?php endwhile; ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- YouTube Lectures -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingVideos">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVideos" aria-expanded="false">
          YouTube Lectures
        </button>
      </h2>
      <div id="collapseVideos" class="accordion-collapse collapse" data-bs-parent="#semester4Accordion">
        <div class="accordion-body">
          <ul class="list-group">
            <?php while ($row = $videos->fetch_assoc()): ?>
              <li class="list-group-item">
                <a href="<?= $row['link'] ?>" target="_blank"><?= $row['title'] ?></a>
              </li>
            <?php endwhile; ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- Assignments -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingAssignments">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAssignments" aria-expanded="false">
          Assignments
        </button>
      </h2>
      <div id="collapseAssignments" class="accordion-collapse collapse" data-bs-parent="#semester4Accordion">
        <div class="accordion-body">
          <ul class="list-group">
            <?php while ($row = $assignments->fetch_assoc()): ?>
              <li class="list-group-item">
                <a href="<?= $row['link'] ?>" target="_blank"><?= $row['title'] ?></a>
              </li>
            <?php endwhile; ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- Previous Year Questions -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingPYQ">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePYQ" aria-expanded="false">
          Previous Year Questions
        </button>
      </h2>
      <div id="collapsePYQ" class="accordion-collapse collapse" data-bs-parent="#semester4Accordion">
        <div class="accordion-body">
          <ul class="list-group">
            <?php while ($row = $pyqs->fetch_assoc()): ?>
              <li class="list-group-item">
                <a href="<?= $row['link'] ?>" target="_blank"><?= $row['title'] ?></a>
              </li>
            <?php endwhile; ?>
          </ul>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Footer -->
<footer>
  <p>&copy; 2025 IGNOU BCA CMS</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
