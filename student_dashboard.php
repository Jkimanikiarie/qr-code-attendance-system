<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit();
}

include ('./conn/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = $_POST['student_name'];
    $course_section = $_POST['course_section'];
    $admission_number = $_POST['admission_number'];
    $unit_name = $_POST['unit_name'];
    $academic_year = $_POST['academic_year'];
    $generated_code = $_POST['generated_code'];
    
    $stmt = $conn->prepare("INSERT INTO tbl_student (student_name, course_section, admission_number, unit_name, academic_year, generated_code) VALUES (:student_name, :course_section, :admission_number, :unit_name, :academic_year, :generated_code)");
    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':course_section', $course_section);
    $stmt->bindParam(':admission_number', $admission_number);
    $stmt->bindParam(':unit_name', $unit_name);
    $stmt->bindParam(':academic_year', $academic_year);
    $stmt->bindParam(':generated_code', $generated_code);

    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
    } else {
        $error = "Error updating profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Student Dashboard</h2>
        <?php if (isset($message)) echo "<p class='text-success'>$message</p>"; ?>
        <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
        <form action="student_dashboard.php" method="POST">
            <div class="form-group">
                <label for="student_name">Full Name:</label>
                <input type="text" class="form-control" id="student_name" name="student_name" required>
            </div>
            <div class="form-group">
                <label for="course_section">Course and Section:</label>
                <input type="text" class="form-control" id="course_section" name="course_section" required>
            </div>
            <div class="form-group">
                <label for="admission_number">Admission Number:</label>
                <input type="text" class="form-control" id="admission_number" name="admission_number" required>
            </div>
            <div class="form-group">
                <label for="unit_name">Unit Name:</label>
                <input type="text" class="form-control" id="unit_name" name="unit_name" required>
            </div>
            <div class="form-group">
                <label for="academic_year">Academic Year:</label>
                <input type="text" class="form-control" id="academic_year" name="academic_year" required>
            </div>
            <button type="button" class="btn btn-secondary form-control qr-generator" onclick="generateQrCode()">Generate QR Code</button>

            <div class="qr-con text-center" style="display: none;">
                <input type="hidden" class="form-control" id="generated_code" name="generated_code">
                <p>Take a pic with your QR code.</p>
                <img class="mb-4" src="" id="qrImg" alt="">
            </div>
            <div class="modal-footer modal-close" style="display: none;">
                <button type="submit" class="btn btn-dark">Update Profile</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- QR Code Generation Script -->
    <script>
        function generateQrCode() {
            const studentName = document.getElementById('student_name').value;
            const courseSection = document.getElementById('course_section').value;
            const admissionNumber = document.getElementById('admission_number').value;
            const unitName = document.getElementById('unit_name').value;
            const academicYear = document.getElementById('academic_year').value;
            
            const qrData = `${studentName},${courseSection},${admissionNumber},${unitName},${academicYear}`;
            const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(qrData)}`;
            
            document.getElementById('generated_code').value = qrData;
            document.getElementById('qrImg').src = qrCodeUrl;
            document.querySelector('.qr-con').style.display = 'block';
            document.querySelector('.modal-footer').style.display = 'block';
        }
    </script>
</body>
</html>