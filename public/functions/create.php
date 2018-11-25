<? php require 'common.php';?>

<?php
if (isset($_POST['submit'])) {
	require "../../connect.php";

	try {
	    $mysqli = new mysqli($servername, $username, $password, $dbname);

    	$sql = "USE c9";
    	$sql = "INSERT INTO Customer VALUES (?, ?, ?, ?, ?, ?, ?)";
    	$stmt = mysqli_prepare($mysqli, $sql);
    	$stmt->bind_param("isssssi", $_POST['idNo'], $_POST['name'], $_POST['address'], $_POST['email'], $_POST['bday'], $_POST['jDate'], $_POST['spID']);
    	$stmt->execute();
    
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
}; ?>

<?php include '../templates/header.php'; ?>

<?php if (isset($_POST['submit']) && $stmt) { ?>
	<blockquote><?php echo $_POST['name']; ?> successfully added.</blockquote>
<?php } ?>

<form method="post">
    <label for="idNo">ID Number</label>
	<input type="text" name="idNo" id="idNo"><br><br>
	<label for="name">Full Name</label>
	<input type="text" name="name" id="name"><br><br>
	<label for="address">Home Address</label>
	<input type="text" name="address" id="address"><br><br>
	<label for="email">Email Address</label>
	<input type="text" name="email" id="email"><br><br>
	<label for="bday">Birth Date (YYYY-MM-DD)</label>
	<input type="text" name="bday" id="bday"><br><br>
	<label for="jDate">Join Date (YYYY-MM-DD)</label>
	<input type="text" name="jDate" id="jDate"><br><br>
	<label for="spID">Service Provider ID</label>
	<input type="text" name="spID" id="spID"><br><br>
	<input type="submit" name="submit" value="Submit"><br><br>
</form>

<a href="../index.php">Back to home</a>

<?php include '../templates/footer.php'; ?>