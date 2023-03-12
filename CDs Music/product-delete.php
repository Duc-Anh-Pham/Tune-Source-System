<?php
  require_once("connection/connectdb.php");
  session_start();

  if($_SESSION['adminID'] == null) {
		echo '<script>';
		echo 'alert("You must login with admin role");';
		echo 'window.location.href="login_admin/index.php"';
		echo '</script>';
  }
?>

<?php
    try
    {
        $sql = "delete from product where productID =?";
        $stml = $conn->prepare($sql);
        $stml->bindParam(1, $_GET['id']);
        $stml->execute();
        header('Location: product-list.php');
    }
    catch (PDOException $ex)
    {   
        echo "Error: " . $ex->getMessage();
    }
?>