<?php
include("database.php");

if (isset($_POST["submit"])) {
    $studentid = $_GET['studentid']; // Fetch the correct student ID from the URL
    $name = $_POST['name'];
    //$email = $_POST['email'];
    $totalscore = $_POST['totalscore'];  // Ensure you fetch score if needed
    $section = $_POST['section'];  // Fetch the section value from form

    // Ensure all values are safely escaped before the query (prevents SQL injection)
    $name = mysqli_real_escape_string($conn, $name);
    //$email = mysqli_real_escape_string($conn, $email);
    $totalscore = mysqli_real_escape_string($conn, $totalscore);
    $section = mysqli_real_escape_string($conn, $section);

    // Correct SQL query with the right column names and student ID
    $query = "UPDATE `studentinfo` SET `name`='$name', /*`email`='$email',*/ `totalscore`='$totalscore', `strand`='$section' WHERE `studentid` = $studentid";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: admin_student_control.php");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Edit Student Information</title>
</head>

<body>
  <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5573;">
    Edit Student Information
  </nav>

  <div class="container">
    <div class="text-center mb-4">
      <h3>Edit Student Information</h3>
    </div>

    <?php
    if (isset($_GET['studentid']) && is_numeric($_GET['studentid'])) {
        $studentid = $_GET['studentid'];
        $query = "SELECT * FROM studentinfo WHERE studentid = $studentid LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "No data found for the given student ID.";
            exit;
        }
    } else {
        echo "Invalid or missing student ID.";
        exit;
    }
    ?>

    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width:50vw; min-width:300px;">
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Name:</label>
            <input type="text" class="form-control" name="name" value="<?php echo $row['name'] ?>">
          </div>

          <div class="col">
            <label class="form-label">Score:</label>
            <input type="text" class="form-control" name="totalscore" value="<?php echo $row['totalscore'] ?>">
          </div>
        </div>

        <!-- <div class="mb-3">
          <label class="form-label">Email:</label>
          <input type="email" class="form-control" name="email" value="<?php //echo $row['email'] ?>">
        </div> -->

        <div class="form-group mb-3">
            <label for="section">Section: </label>
            <select name="section" id="section" class="form-control">
                <optgroup label="Select Section">
                    <option value="section1" <?php echo ($row['strand'] == 'section1') ? 'selected' : ''; ?>>Section 1</option>
                    <option value="section2" <?php echo ($row['strand'] == 'section2') ? 'selected' : ''; ?>>Section 2</option>
                    <option value="section3" <?php echo ($row['strand'] == 'section3') ? 'selected' : ''; ?>>Section 3</option>
                </optgroup>
            </select>
        </div>

        <div>
          <button type="submit" class="btn btn-success" name="submit">Update</button>
          <a href="admin_student_control.php" class="btn btn-danger">Cancel</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
