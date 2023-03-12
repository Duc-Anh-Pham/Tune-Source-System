<?php
    require_once("../connection/connectdb.php");
?>

<?php
if (isset($_POST['login'])) {
  try {
    $sql = "select * from manager where managerID = ? and managerPass = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $_POST['managerID']);
    $stmt->bindParam(2, $_POST['managerPass']);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row == FALSE)
        echo '<span style="color:#AFA;text-align:center;">Wrong user name or password!</span>'; 
    else {
      session_start();
      $_SESSION['managerID'] = $row['managerID'];
      $_SESSION['managerEmail'] = $row['managerEmail'];
      $_SESSION['managerFullname'] = $row['managerFullname'];
      $_SESSION['managerPhoto'] = $row['managerPhoto'];
      header("Location: ../web_admin/index.php");
    }
  } catch (PDOException $ex) 
  {
    echo 'Error: ' . $ex->getMessage();
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login_manager</title>
  <link rel="stylesheet" href="./style.css">
</head>

<body>
  <!-- partial:index.partial.html -->
  <div class="login-box">
    <h2>Login</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <div class="user-box">
        <input type="text" name="managerID" id="managerEmail" required="managerEmail" placeholder="Enter your Email manager or manager ID address">
        <label>Username</label>
      </div>

      <div class="user-box">
        <input type="password" name="managerPass" required="managerPass" placeholder="Enter your Password manager ">
        <label>Password</label>
      </div>
      <a href="#">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        <button type="submit" name="login" >Login</button>
      </a>
    </form>
  </div>
  <!-- partial -->
</body>

</html>