<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $f_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $l_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $mid_initial = filter_input(INPUT_POST, "middle_initial", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, "new_password", FILTER_SANITIZE_SPECIAL_CHARS);
        $con_password = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_SPECIAL_CHARS);

        $is_password = false;
        
        if(empty($mid_initial)){
            $_SESSION["name"] = strtoupper($f_name) . " " . strtoupper($l_name);
        }else{
            $_SESSION["name"] = strtoupper($f_name) . " " . strtoupper($mid_initial) . " " . strtoupper($l_name);
        }

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION["email"] = $email;
        }

        if($password == $con_password){
            $_SESSION["password"] = hash("SHA256", $password);
            $is_password = true;
        }

        if($is_password){
            header("Location: admin_register_output.php");
            die();
        }else{
            echo "Error";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="admin_register.css">
    <title>Admin Register</title>
</head>
<body>
    
    <script src="js/bootstrap.bundle.js"></script>

    <div class="container-form">
        <h1>Admin Registration</h1>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
            <!-- Name -->
            <div class="Container-Name">
                <div class="Enter-Register-Name">
                    <label for="last_name">Last Name: </label>
                    <input type="text" 
                    name="last_name" 
                    id="last_name" 
                    maxlength="20"
                    style="text-transform: capitalize;"
                    required> <br>
                </div>
            </div>

            <div class="Container-Name">
                <div class="Enter-Register-Name">
                    <label for="first_name">First Name: </label>
                    <input type="text" 
                    name="first_name" 
                    id="first_name" 
                    maxlength="20" 
                    style="text-transform: capitalize;"
                    required> <br>
                </div>
            </div>

            <div class="Container-Name">
                <div class="Enter-Register-MI">
                    <label for="middle_initial">Middle Initial: </label>
                    <input type="text" 
                    name="middle_initial" 
                    id="middle_intial"
                    oninput="this.value = this.value.toUpperCase()"
                    maxlength="1"> <br>
                </div>
            </div>
            
            <!-- Student Info -->
            <div class="Container-Info">
                <div class="Enter-Register-Email">
                    <label for="email">Email: </label>
                    <input type="text" name="email" id="email" required> <br>
                </div>
            </div>

            <div class="Container-Info">
                <div class="Enter-Register-Password">
                <Label for="new_password">Password: </Label>
                <input type="password" name="new_password" id="new_password" required><br>
                </div>
            </div>

            <div class="Container-Info">
                <div class="Enter-Register-Password">
                    <label for="confirm_password">Confirm Password: </label>
                    <input type="password" name="confirm_password" id="confirm_password" required><br>
                </div>
            </div>
            
            <div class="Enter-Register-Submit">
                <input type="submit" name="Register" value="Register"><br>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    
?>