<?php
    include("database.php");
    session_start();

    // Set the default time zone to Asia/Manila
    date_default_timezone_set('Asia/Manila');

    // Session once register
    $stud_num = $_SESSION["stud_num"];
    $name = $_SESSION["name"];
    $email = $_SESSION["email"];
    $password = $_SESSION["password"];
    $section = $_SESSION["section"];
    $token = $_SESSION["token"];

    // Get current date and time
    $date = new DateTime();
    $formattedDate = $date->format('Y-m-d H:i:s');

    $queries = array(
        "INSERT INTO studentinfo (studentid, name, email, strand, totalscore) 
         VALUES ('{$stud_num}', '{$name}', '{$email}', '{$section}', 0)",
        "INSERT INTO studentlogin (studentid, password, token) 
         VALUES ('{$stud_num}', '{$password}', '{$token}')",
        "INSERT INTO monitoring (monitorid, studentid, activity_type, activity_time, activity_description) 
         VALUES (NULL,'{$stud_num}', 'Register', '{$formattedDate}', 'Register Successful')",
        "INSERT INTO student_score (studentid, level01, level02, level03, level04, level05, level06, level07, level08, level09, level10) 
         VALUES ('{$stud_num}', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)"
    );

    $message = "";

    try{
        // Execute each query
        foreach ($queries as $query) {
            if (!mysqli_query($conn, $query)) {
                throw new mysqli_sql_exception(mysqli_error($conn));
            }
        }
        $message = "<h1>You haved succesfully registered</h1><br>
        Welcome {$name} to Biolo-G<br>
        Please close the login and set your STUDENT NUMBER and PASSWORD to enter Biolo-G";
    }catch(mysqli_sql_exception $e){
        $message = "Error Registering: " . $e->getMessage();
    }
       

    mysqli_close($conn);
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="output.css"> <!-- Link to the external CSS file -->
    <title>Registered</title>
</head>
<body>
    <div class="container">
        <?php
            echo $message;
        ?>
        <!-- <a href="login.php" class="button">Go to Login</a> -->
        <div class="footer">Biolo-G - Empowering Students for a Better Tomorrow</div>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
    <!-- <form action="output.php" method="post">
        <input type="submit" name="logout" value="logout">
    </form> -->
</body>
</html>


<?php
    // if(isset($_POST["logout"])){
    //     header("Location: index.php");
    // }
?>