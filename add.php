<?php require 'connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Student</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

    <!-- Optional custom styles -->
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">➕ Add Student Info</h2>
    <form action="insert.php" method="post" class="row g-3" enctype="multipart/form-data">
        <div class="col-md-6">
            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required />
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control" required />
        </div>

        <div class="col-md-6">
            <label for="program" class="form-label">Program</label>
            <input type="text" name="program" id="program" class="form-control" />
        </div>

        <div class="col-md-3">
            <label for="yearpicker" class="form-label">Academic Year</label>
            <input type="text" name="year" id="yearpicker" class="form-control" placeholder="Select Year" />
        </div>

        <div class="col-md-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" />
        </div>

        <div class="col-md-3">
            <label for="startpicker" class="form-label">Academic Year Start Date</label>
            <input type="text" name="start_date" id="startpicker" class="form-control" placeholder="YYYY-MM-DD" />
        </div>

        <div class="col-md-3">
            <label for="endpicker" class="form-label">Academic Year End Date</label>
            <input type="text" name="end_date" id="endpicker" class="form-control" placeholder="YYYY-MM-DD" />
        </div>

        <div class="col-md-3">
            <label for="cgpa" class="form-label">CGPA</label>
            <input type="number" name="cgpa" id="cgpa" step="0.01" min="0" max="10" class="form-control" />
        </div>

        <div class="col-md-6">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" class="form-control" rows="2"></textarea>
        </div>

        <div class="col-md-6">
            <label for="photo" class="form-label">Photo (Passport Size) <span class="text-danger">*</span></label>
            <input type="file" name="photo" id="photo" class="form-control" accept="image/*" required />
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save Student</button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#yearpicker", {
        dateFormat: "Y",
        allowInput: true,
    });
    flatpickr("#startpicker", {
        dateFormat: "Y-m-d",
    });
    flatpickr("#endpicker", {
        dateFormat: "Y-m-d",
    });
</script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($_GET['error'])): ?>
<script>
    alert("<?php echo htmlspecialchars(urldecode($_GET['error'])); ?>");
</script>
<?php endif; ?>

</body>
</html>
