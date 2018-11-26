
<?php include "../templates/header.php"; ?>

<h2>Customer Search</h2>
<br>

<form method="post">
	<label for="name">Customer Name</label>
	<input type="text" id="name" name="name">
	<input type="submit" name="submit" value="View Results">
</form>

<br>
<p>Or search by:</p>
<br>

<form method="post">
	<label for="idNo">Customer ID</label>
	<input type="text" id="idNo" name="idNo">
	<input type="submit" name="submitID" value="View Results">
</form>

<!-- search by name-->
<?php if (isset($_POST['submit'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT * 
				FROM c9.Customer
				WHERE clientName = :name";
				
		$clientName = $_POST['name'];
		
		$statement = $connection->prepare($sql);
        $statement->bindParam(':name', $clientName, PDO::PARAM_STR);
        $statement->execute();
        
        $result = $statement->fetchAll();
        
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>

<!-- search by ID-->
<?php if (isset($_POST['submitID'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $username, $password, $options);
		
		$sql = "SELECT * 
				FROM c9.Customer
				WHERE idNo = :idNo";
				
		$idNo = $_POST['idNo'];
		
		$statement = $connection->prepare($sql);
        $statement->bindParam(':idNo', $idNo, PDO::PARAM_STR);
        $statement->execute();
        
        $result = $statement->fetchAll();
        
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>

<!-- display results for name search-->
<?php  
if (isset($_POST['submit'])) {
	if ($result && $statement->rowCount() > 0) { ?>
		<h2>Results</h2>
		<table>
			<thead>
				<tr>
					<th>Customer ID</th>
					<th>Name</th>
					<th>Address</th>
					<th>Email</th>
					<th>Birth Date</th>
					<th>Date Joined</th>
					<th>Service Provider ID</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["idNo"]); ?></td>
				<td><?php echo escape($row["clientName"]); ?></td>
				<td><?php echo escape($row["clientAddress"]); ?></td>
				<td><?php echo escape($row["clientEmail"]); ?></td>
				<td><?php echo escape($row["birthDate"]); ?></td>
				<td><?php echo escape($row["dateJoined"]); ?></td>
				<td><?php echo escape($row["serviceProviderID"]); ?></td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<blockquote>No results found for <?php echo escape($_POST['clientName']); ?>.</blockquote>
	<?php } 
} ?> 

<br>

<!-- display results for ID search-->
<?php  
if (isset($_POST['submitID'])) {
	if ($result && $statement->rowCount() > 0) { ?>
		<h2>Results</h2>
		<table>
			<thead>
				<tr>
					<th>Customer ID</th>
					<th>Name</th>
					<th>Address</th>
					<th>Email</th>
					<th>Birth Date</th>
					<th>Date Joined</th>
					<th>Service Provider ID</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["idNo"]); ?></td>
				<td><?php echo escape($row["clientName"]); ?></td>
				<td><?php echo escape($row["clientAddress"]); ?></td>
				<td><?php echo escape($row["clientEmail"]); ?></td>
				<td><?php echo escape($row["birthDate"]); ?></td>
				<td><?php echo escape($row["dateJoined"]); ?></td>
				<td><?php echo escape($row["serviceProviderID"]); ?></td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<blockquote>No results found for <?php echo escape($_POST['idNo']); ?>.</blockquote>
	<?php } 
} ?> 




<?php include "../templates/footer.php"; ?>