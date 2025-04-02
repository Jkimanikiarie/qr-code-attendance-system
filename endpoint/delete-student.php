<?php
include ('../conn/conn.php');

if (isset($_GET['student'])) {
    $student = $_GET['student'];

    try {
        $query = "DELETE FROM tbl_student WHERE tbl_student_id = :student_id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":student_id", $student, PDO::PARAM_INT);

        $query_execute = $stmt->execute();

        if ($query_execute) {
            echo "
                <script>
                    alert('Student deleted successfully!');
                    window.location.href = 'http://localhost/qr-code-attendance-system/masterlist.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Failed to delete student!');
                    window.location.href = 'http://localhost/qr-code-attendance-system/masterlist.php';
                </script>
            ";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>