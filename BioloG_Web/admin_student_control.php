<?php
    include("database.php");
    session_start();
    
    $query = "SELECT * FROM studentinfo ORDER BY totalscore DESC";

    if(empty($_SESSION["adminID"])){
        header("location: admin_login.php");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $studentid = $_POST['studentid'];
        if(empty($studentid)){
            $query = "SELECT * FROM studentinfo ORDER BY totalscore DESC";;
        }else{
            $query = "SELECT * FROM studentinfo WHERE studentid='{$studentid}' ORDER BY totalscore DESC";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_student_control.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Leaderboard</title>
</head>
<body>
    <?php include 'admin_navbar.php'; ?>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="studentid">Find Student</label>
            <input type="text" name="studentid" id="studentid" placeholder="2000xxxxxx" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            <input type="submit" class="btn-stu" value="Search">
        </form>

        <table>
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Section</th>
            <th>Score</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>". $row["studentid"]. "</td><td>" . 
                $row["name"]. "</td><td>". 
                $row["email"]. "</td><td>". 
                $row["strand"]. "</td><td>". 
                $row["totalscore"]. "</td><td>".
                "<button><a href=\"edit.php?studentid=" . $row['studentid'] . "\" class=\"split\">Edit</a></button>". 
                "<button><a href=\"delete.php?studentid=" . $row['studentid'] . "\" class=\"split\">Delete</a></button>"
                ."</td></tr>";
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
