<?php
    require_once("connection/connectdb.php");
?>

<?php
    try {
		$sql = "select * from category";
		$stmt_cat = $conn->query($sql);
		$rows_cat = $stmt_cat->fetchAll();		
	} catch(PDOException $ex) {
		echo "Error: " . $ex->getMessage();
    }

    if(isset($_POST['addnew'])) {
        try {
			$sql = "INSERT INTO album VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $_POST['albumID']);            
			$stmt->bindParam(2, $_POST['albumName']);
            $stmt->bindParam(3, $_POST['categoryID']);
			$stmt->bindParam(4, $_POST['albumPrice']);
			$stmt->bindParam(5, $_POST['albumImage']);	
			$stmt->bindParam(6, $_POST['albumDetails']);
			$stmt->execute();
			header('Location: album-list.php');	
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
    
    <title>Add album</title>
</head>

<body>
    <div class="container mt-4">
        <h2>Add New album</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="mb-3 mt-3">
                <label for="id">ID:</label>
                <input type="text" class="form-control" id="albumID" placeholder="Enter album id" name="albumID">
            </div>
            <div class="mb-3">
                <label>Album name:</label>
                <input type="text" class="form-control" id="albumName" placeholder="Enter album name" name="albumName">
            </div>
            <div class="mb-3">
                <label>Album price:</label>
                <input type="text" class="form-control" id="albumPrice" placeholder="Enter album price" name="albumPrice">
            </div>
            <div class="mb-3">
                <label>Album image:</label>
                <input type="file" class="form-control" id="albumImage" name="albumImage">
            </div>
            <div class="mb-3">
                <label>Album details:</label>
                <textarea class="form-control" rows="10" name="albumDetails" id="albumDetails"></textarea>
            </div>
            <div class="mb-3">
                <label>Category:</label>
                <select name="categoryID" id="categoryID" class="form-control">
                    <?php foreach($rows_cat as $row)  { ?> 
                    <option value="<?= $row['categoryID'] ?>">
                            <?php echo $row['categoryName'] ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="addnew">Add new</button>
            <a href="album-list.php" class="btn btn-success">Back</a>
        </form>
    </div>
</body>

</html>

