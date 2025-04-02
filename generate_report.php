<?php
include("conn/conn.php");

$stmt = $conn->prepare("SELECT tbl_student.student_name, tbl_student.course_section, tbl_attendance.time_in FROM tbl_attendance LEFT JOIN tbl_student ON tbl_student.tbl_student_id = tbl_attendance.tbl_student_id");
$stmt->execute();
$results = $stmt->fetchAll();

echo "<h2>Attendance Report</h2>";
echo "<table border='1'>";
echo "<tr><th>Student Name</th><th>Course & Section</th><th>Time In</th></tr>";

foreach ($results as $row) {
    echo "<tr><td>" . $row['student_name'] . "</td><td>" . $row['course_section'] . "</td><td>" . $row['time_in'] . "</td></tr>";
}

echo "</table>";
?>