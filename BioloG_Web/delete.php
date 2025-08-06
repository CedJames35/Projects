<?php
include("database.php");

// Ensure studentid is provided and valid
if (isset($_GET['studentid']) && is_numeric($_GET['studentid'])) {
    $studentid = $_GET['studentid'];

    $queries = array(
        "DELETE FROM `monitoring` WHERE studentid = {$studentid}",
        "DELETE FROM `student_score` WHERE studentid = {$studentid}",
        "DELETE FROM `studentlogin` WHERE studentid = {$studentid}",
        "DELETE FROM `studentinfo` WHERE studentid = {$studentid}" // this should be the last because it is the primary key of the studentid
    );

    try {
        // Execute each query
        foreach ($queries as $query) {
            if (!mysqli_query($conn, $query)) {
                throw new mysqli_sql_exception(mysqli_error($conn));
            }
        }

        mysqli_commit($conn);
        header("Location: admin_student_control.php?msg=Data deleted successfully");

    } catch (mysqli_sql_exception $e) {
        mysqli_rollback($conn);
        echo "Error Delete: " . $e->getMessage();
    }
} else {
    echo "Invalid Student ID.";
}
?>
