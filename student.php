<?php
require 'connect.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Student ID missing");
}

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Details - <?php echo htmlspecialchars($student['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Student Details</h2>

    <?php if (!empty($student['photo'])): ?>
        <img src="photos/<?php echo htmlspecialchars($student['photo']); ?>" alt="Student Photo" class="mb-3" />
    <?php else: ?>
        <p>No photo available.</p>
    <?php endif; ?>

    <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></li>
        <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></li>
        <li class="list-group-item"><strong>Program:</strong> <?php echo htmlspecialchars($student['program']); ?></li>
        <li class="list-group-item"><strong>Academic Year:</strong> <?php echo htmlspecialchars($student['year']); ?></li>
        <li class="list-group-item"><strong>Phone:</strong> <?php echo htmlspecialchars($student['phone']); ?></li>
        <li class="list-group-item"><strong>Start Date:</strong> <?php echo htmlspecialchars($student['start_date']); ?></li>
        <li class="list-group-item"><strong>End Date:</strong> <?php echo htmlspecialchars($student['end_date']); ?></li>
        <li class="list-group-item"><strong>CGPA:</strong> <?php echo htmlspecialchars($student['cgpa']); ?></li>
        <li class="list-group-item"><strong>Address:</strong> <?php echo htmlspecialchars($student['address']); ?></li>
    </ul>

    <a href="index.php" class="btn btn-secondary mt-3">Back</a>
</div>
</body>
</html>
