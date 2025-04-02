<?php
include ('../conn/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = $_POST['student_name'];
    $course_section = $_POST['course_section'];
    $admission_number = $_POST['admission_number'];
    $unit_name = $_POST['unit_name'];
    $academic_year = $_POST['academic_year'];
    $generated_code = $_POST['generated_code'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO tbl_student (student_name, course_section, admission_number, unit_name, academic_year, generated_code) VALUES (:student_name, :course_section, :admission_number, :unit_name, :academic_year, :generated_code)");
    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':course_section', $course_section);
    $stmt->bindParam(':admission_number', $admission_number);
    $stmt->bindParam(':unit_name', $unit_name);
    $stmt->bindParam(':academic_year', $academic_year);
    $stmt->bindParam(':generated_code', $generated_code);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: ../masterlist.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid request method.";
}
?>