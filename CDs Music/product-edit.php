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
    // Query Statement
    try {
		$sql = "select * from category";
		$stmt_cat = $conn->query($sql);
		$rows_cat = $stmt_cat->fetchAll();		
	} catch(PDOException $ex) {
		echo "Error: " . $ex->getMessage();
	}
    
    // Edit Product
    try {
        $sql = "select * from product where productID = ?";
        $stmt_edit = $conn->prepare($sql);
        $stmt_edit->bindParam(1, $_GET['id']);
        $stmt_edit->execute();
        $row_edit = $stmt_edit->fetch();
    }catch(PDOException $ex) {
        echo 'Error: ' . $ex->getMessage();
    }

    // Update Product
    if(isset($_POST['update'])) {
        try {
			$sql = "update product      
                    set productName = ?, productPrice = ?, productImage = ?, 
                        productDetails = ?, categoryID = ?     
                    where productID = ?";

            $image = $_POST['productImage'] == '' ? $_POST['old_image'] : $_POST['productImage'];
			
            $stmt = $conn->prepare($sql);
			$stmt->bindParam(1, $_POST['productName']);
			$stmt->bindParam(2, $_POST['productPrice']);
			$stmt->bindParam(3, $image);	
			$stmt->bindParam(4, $_POST['productDetails']);
			$stmt->bindParam(5, $_POST['categoryID']);
            $stmt->bindParam(6, $_POST['productID']);   
			$stmt->execute(); 
            // When the command is executed, it will return to the list page
			header('Location: product-list.php');	
		} catch(PDOException $ex) {
			echo "Error: " . $ex->getMessage();
		}
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
    <title>Edit product</title>
</head>

<body>
    <div class="container mt-4">
        <h2>Edit Product</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="mb-3 mt-3">
                <label for="id">Product ID:</label>
                <input type="text" class="form-control" readonly value="<?= $row_edit['productID'] ?>" placeholder="Enter ProductID"  name="productID">
            </div>

            <div class="mb-3">  
                <label>Product Name:</label>
                <input type="text" class="form-control" value="<?= $row_edit['productName'] ?>" placeholder="Enter Product_Name" name="productName">
            </div>

            <div class="mb-3">
                <label>Product Price:</label>   
                <input type="text" class="form-control" value="<?= $row_edit['productPrice'] ?>" placeholder="Enter Product_Price" name="productPrice">
            </div>

            <div class="mb-3">
                <label>Product Image:</label>
                <img src="images\products\<?= $row_edit['productImage'] ?>" height="90px" width="90px" alt=" no image">
                <input type="hidden" value="<?php $row_edit['productImage'] ?>" name="old_image">
                <input type="file" class="form-control" id="productImage" name="productImage">
            </div>
    
            <div class="mb-3">
                <label>Product Details:</label>
                <textarea class="form-control" rows="10" name="productDetails"><?= $row_edit['productDetails'] ?> </textarea>
            </div>

            <div class="mb-3">
                <label>Category:</label>
                <select name="categoryID" class="form-control">
                    <?php foreach($rows_cat as $row)  { ?> 
                    <option value="<?= $row['categoryID'] ?>"
                            <?php echo $row['categoryID'] == $row_edit['categoryID']?'selected':''?> ><?php echo $row['categoryName']?>
                    </option>
                    <?php } ?>
                </select>
                
            </div>
            <button type="submit" class="btn btn-primary" name="update">Save</button>
            <a href="product-list.php" class="btn btn-success">Back</a>
        </form>
    </div>
</body>

</html>

