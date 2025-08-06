<?php
    include("database.php");
    session_start();

    $msgerror = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $adminID = filter_input(INPUT_POST, "admin_id", FILTER_SANITIZE_SPECIAL_CHARS);
        $adminPassword = filter_input(INPUT_POST, "admin_password", FILTER_SANITIZE_SPECIAL_CHARS);

        try{
            if(!empty($adminID) && !empty($adminPassword)){
                $hashed_password = hash("SHA256", $adminPassword);
                $query = "SELECT * FROM adminlogin WHERE id='{$adminID}' AND password='{$hashed_password}'";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    if($row["id"] == $adminID && $row["password"] == $hashed_password){
                        $_SESSION["adminID"] = $adminID;
                        header("Location: admin_student_control.php");
                        die();
                    }else{
                        $msgerror = "Invalid ID or password";
                    }
                }
            }
        }catch (mysqli_sql_exception $e) {
            $msgerror = "Error Registering: " . $e->getMessage();
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
    <link rel="stylesheet" href="admin_login.css">
    <title>Admin Login</title>
</head>
<body>
    <div class="container">
        <div class="container-1">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                <label for="admin_id">Admin ID:</label>
                <input type="text" 
                id="admin_id" 
                name="admin_id" 
                maxlength="11"
                required><br>

                <label for="admin_password">Password:</label>
                <input type="password" 
                id="admin_password" 
                name="admin_password" 
                maxlength="20"
                required><br>

                <input type="submit" value="Submit">
            </form>

            <?php
                echo $msgerror;
            ?>
        </div>
    </div>
</body>
</html>