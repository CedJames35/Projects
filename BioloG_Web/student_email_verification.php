<?php
    session_start();
    include("database.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    function generateRandomToken($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }

    function verify_email($email, $token){
        $mail = new PHPMailer(true);

        try{
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output

            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';              //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'Biolog.dnes@gmail.com';                     //SMTP username
            $mail->Password   = 'gsuumegracvhrjuy';                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                                  //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('Biolog.dnes@gmail.com', 'Biolo-G Devs');
            $mail->addAddress($email);     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Registration Verification Code';
            $mail->Body    = 'Your Verification Code is: '. $token;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        }catch(Exception $e){
            return false;
        }

        
    }

    // generate and send token to the designated email
    if(empty($_SESSION["token"])){
        $_SESSION['token'] = generateRandomToken();
    }
    verify_email($_SESSION["email"], $_SESSION["token"]);
    
    $emsg = " ";
    $is_error = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $token = $_POST["token"];
        
        if($token == $_SESSION["token"]) {
            // Token is valid, proceed
            header("Location: output.php");
            exit();
        } else {
            $is_error = true;
            $emsg = "The code that you have entered is not valid.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .verification-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="verification-form">

        <?php
        if($is_error = false){
            echo '<div class="message">We have sent your verification code to your email</div>';
        }else{
            echo $emsg;
            echo $_SESSION['token'];
        }
        ?>

        <h2>Enter Verification Code</h2>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
            <input type="text" name="token" placeholder="Enter your code" maxlength="5" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>

