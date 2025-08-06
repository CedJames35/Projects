<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- CSS -->
  <style>
    body {
      background-color: rgb(26, 124, 124);
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
    }

    .topnav {
      overflow: hidden;
      background-color: #333;
    }

    .topnav a {
      float: left;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 17px;
    }

    /* Create a right-aligned (split) link inside the navigation bar */
    .topnav a.split {
      float: right;
      color: white;
    }
    
    .topnav a.split:hover {
      background-color: #ddd;
      color: black;
    }
    /* Button styling */

    button {
        background-color: black;
        border: none;
        border-radius: 10px;
        padding-left: 6px;
        cursor: pointer;
    }

    /* Button link styling */
    button a {
        color: white;
        font-weight: bold;
        font-size: 12px;
    }

    /* Make sure the button and links are spaced evenly */
    button {
        float: right;
        background-color: #04AA6D;
        color: white;
        margin-left: 10px;
    }
    
    button:hover{
      background-color: #ddd;
      color: black;
    }
  </style>

</head>
<body>
  <div class="topnav">
    <a href="#">Biolo-G</a>
    <a href="admin_monitoring.php" class="split">Monitoring</a>
    <a href="admin_student_control.php" class="split">Student Info.</a>
    <button><a href="admin_logout.php" class="split">Log Out</a></button>
  </div>
</nav>
</body>
</html>