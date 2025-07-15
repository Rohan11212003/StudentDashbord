<?php require 'connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .student-card {
            transition: transform 0.2s ease;
            text-decoration: none;
            color: inherit;
        }
        .student-card:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <!-- Header and Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📚 Student Dashboard</h2>
        <a href="add.php" class="btn btn-success">➕ Add New</a>
    </div>

    <!-- Alerts -->
    <?php if (isset($_GET['saved']) && $_GET['saved'] == 1): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ Student has been saved successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            ✏️ Student updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            🗑️ Student deleted successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Student Cards -->
    <div class="row">
        <?php
        $stmt = $conn->query("SELECT * FROM students ORDER BY id DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="col-md-4 mb-4">
            <a href="student.php?id=<?php echo $row['id']; ?>" class="student-card d-block">
                <div class="card shadow-sm h-100">
                    <?php if (!empty($row['photo'])): ?>
                        <img src="photos/<?php echo htmlspecialchars($row['photo']); ?>" class="card-img-top img-fluid" style="height: 200px; object-fit: cover;" alt="Student Photo">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No photo">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                        <!-- <p class="card-text">
                            <strong>Email:</strong> <?= htmlspecialchars($row['email']); ?><br>
                            <strong>Program:</strong> <?= htmlspecialchars($row['program']); ?><br>
                            <strong>Year:</strong> <?= htmlspecialchars($row['year']); ?><br>
                            <strong>Start:</strong> <?= htmlspecialchars($row['start_date']); ?><br>
                            <strong>End:</strong> <?= htmlspecialchars($row['end_date']); ?><br>
                            <strong>CGPA:</strong> <?= htmlspecialchars($row['cgpa']); ?><br>
                            <strong>Phone:</strong> <?= htmlspecialchars($row['phone']); ?><br>
                            <strong>Address:</strong> <?= nl2br(htmlspecialchars($row['address'])); ?>
                        </p> -->
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">✏️ Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this student?');">🗑️ Delete</a>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
