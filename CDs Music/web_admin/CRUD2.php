<?php
  require_once("../connection/connectdb.php");
  session_start();

  if($_SESSION['managerID'] == null) {
		echo '<script>';
		echo 'alert("You must login with manager role");';
		echo 'window.location.href="login_admin/index.php"';
		echo '</script>';
  }
?>

<?php
    try
    {
        $sql = "delete from album where albumID =?";
        $stml = $conn->prepare($sql);
        $stml->bindParam(1, $_GET['id']);
        $stml->execute();
        header('Location: ../web_admin/CRUD.php');
    }
    catch (PDOException $ex)
    {   
        echo "Error: " . $ex->getMessage();
    }
?>