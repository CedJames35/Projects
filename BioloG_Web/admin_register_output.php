<?php
    include("database.php");
    session_start();

    function generateRandomString($length = 11) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }
    
    // Generate a unique ID
    do {
        $id = generateRandomString();
        $query_id = "SELECT id FROM admininfo WHERE id='{$id}'";
        $is_id = mysqli_query($conn, $query_id);
    } while (mysqli_num_rows($is_id) > 0);

    // Session once register
    $name = $_SESSION["name"];
    $email = $_SESSION["email"];
    $password = $_SESSION["password"];

    $queries = array(
        "INSERT INTO admininfo (id, name, email) 
         VALUES ('{$id}', '{$name}', '{$email}')",
        "INSERT INTO adminlogin (id, password) 
         VALUES ('{$id}', '{$password}')"
    );

    $message = "";

    try {
        // Execute each query
        foreach ($queries as $query) {
            if (!mysqli_query($conn, $query)) {
                throw new mysqli_sql_exception(mysqli_error($conn));
            }
        }

        $message = "<h1>You have successfully registered</h1><br>
        Your AdminID is {$id}<br>";

    } catch (mysqli_sql_exception $e) {
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
    <link rel="stylesheet" href="admin_register_output.css"> <!-- Link to the external CSS file -->
    <title>Registered</title>
</head>
<body>
    <div class="container">
        <?php
            echo $message;
        ?>
        <a href="admin_login.php" class="button">Go to Login</a>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
</body>
</html>
