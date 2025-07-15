<?php
require 'connect.php';

// Check if ID is passed
if (!isset($_GET['id'])) {
    die("No ID provided.");
}

$id = $_GET['id'];

// Fetch existing student data
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">✏️ Edit Student Info</h2>
    <form action="update.php" method="post" class="row g-3" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">

        <div class="col-md-6">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($student['name']); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($student['email']); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Program</label>
            <input type="text" name="program" class="form-control" value="<?php echo htmlspecialchars($student['program']); ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Academic Year</label>
            <input type="text" name="year" class="form-control" value="<?php echo htmlspecialchars($student['year']); ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($student['phone']); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Change Photo (optional)</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">💾 Update Student</button>
            <a href="index.php" class="btn btn-secondary">⬅ Back</a>
        </div>
    </form>
</div>
</body>
</html>
