<?php
include("conn/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $admission_number = $_GET['admission_number'];

    $stmt = $conn->prepare("SELECT * FROM tbl_student WHERE admission_number = :admission_number");
    $stmt->bindParam(":admission_number", $admission_number);
    $stmt->execute();
    $student = $stmt->fetch();

    if ($student) {
        echo "Student Name: " . $student['student_name'] . "<br>";
        echo "Course & Section: " . $student['course_section'] . "<br>";
        echo "Unit Name: " . $student['unit_name'] . "<br>";
        echo "Academic Year: " . $student['academic_year'] . "<br>";
    } else {
        echo "No student found with the admission number: " . $admission_number;
    }
}
?>