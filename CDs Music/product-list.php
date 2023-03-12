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
//Cách 1
//     try {
// 		$sql = "select * from category order by productID desc";
// 		$stmt_cat = $conn->query($sql);
// 		$rows_cat = $stmt_cat->fetchAll();		
// 	} catch(PDOException $ex) {
// 		echo "Error: " . $ex->getMessage();
// 	}

    try {
		$sql = "select p.*, c.categoryName from product p
                join category c 
                on p.categoryID = c.categoryID
                order by p.productID desc";
		$stmt = $conn->prepare($sql);
		$stmt->execute();		
	} catch(PDOException $ex) {
		echo "Error: " . $ex->getMessage();
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" >
    <title>Product List</title>
</head>

<body>
    <div class="container mt-4">
        <p><a href="product-add.php" class="btn btn-outline-primary">Add product</a></p>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ProductID</th>
                    <th>Product name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch()) { ?>
                <tr>
                    <td><?= $row['productID'] ?></td>
                    <td><?= $row['productName'] ?></td>
                    <td><?= $row['productPrice'] ?></td>
                    <td>
                        <a href="#" title="<?= $row['productDetails'] ?>">
                            <img src="images\products\<?= $row['productImage'] ?>" 
                                height="140px" width="120px" alt="no image">
                        </a>
                    </td>

                    <td><?= $row['categoryName'] ?></td>
                    <td>
                        <a href="product-edit.php?id=<?= $row['productID'] ?>" title="Edit"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="product-delete.php?id=<?= $row['productID'] ?>" title="Delete" onclick="return confirm('Are You Sure ?');">
                        <i class="fa-solid fa-trash"></i></a>
                    </td>
                    
                </tr>   
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>


