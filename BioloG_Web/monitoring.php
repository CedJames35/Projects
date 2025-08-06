<?php
    session_start();
    include("database.php");
    $query = "SELECT * FROM monitoring ORDER BY activity_time DESC";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="monitoring.css">
    <title>Monitoring</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="studentid">Find Student:</label>
            <input type="text" name="studentid" id="studentid" placeholder="2000xxxxxx" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            <input type="submit" class="btn-stu" value="Search">
        </form>

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $studentid = $_POST['studentid'];
                if(empty($studentid)){
                    $query = "SELECT * FROM monitoring ORDER BY activity_time DESC";
                }else{
                    $query = "SELECT * FROM monitoring WHERE studentid='{$studentid}' ORDER BY activity_time DESC";
                }
            }
        ?>
        
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Type</th>
                    <th>Date & Time</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>". $row["studentid"]. "</td><td>" . 
                        $row["activity_type"]. "</td><td>". 
                        $row["activity_time"]. "</td><td>". 
                        $row["activity_description"]. "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No results found</td></tr>";
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
