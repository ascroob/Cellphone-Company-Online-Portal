
<?php include "../templates/header.php"; ?>

<h2>Edit Customer Information</h2>

<form method="post">
	<label for="spID">Service Provider ID</label>
	<input type="text" id="spID" name="spID">
	<input type="submit" name="submit" value="View Results">
</form>
<br>

<?php if (isset($_POST['submit'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT * 
				FROM c9.Customer
				WHERE serviceProviderID = :spID";
				
		$serviceProviderID = $_POST['spID'];
		
		$statement = $connection->prepare($sql);
        $statement->bindParam(':spID', $serviceProviderID, PDO::PARAM_STR);
        $statement->execute();
        
        $result = $statement->fetchAll();
        
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>


<?php  
if (isset($_POST['submit'])) {
	if ($result && $statement->rowCount() > 0) { ?>
		<h2 align = "center">All Customers</h2>

		<table class="table table-sm">
  			<thead>
   		 		<tr>
					<th scope="col">Customer ID</th>
					<th scope="col">Name</th>
					<th scope="col">Address</th>
					<th scope="col">Email</th>
					<th scope="col">Birth Date</th>
					<th scope="col">Date Joined</th>
					<th scope="col">Edit</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<th scope = "row"><?php echo escape($row["idNo"]); ?></td>
				<td><?php echo escape($row["clientName"]); ?></td>
				<td><?php echo escape($row["clientAddress"]); ?></td>
				<td><?php echo escape($row["clientEmail"]); ?></td>
				<td><?php echo escape($row["birthDate"]); ?></td>
				<td><?php echo escape($row["dateJoined"]); ?></td>
				<td><a href="update-single.php?idNo=<?php echo escape($row["idNo"]); ?>">Edit</a></td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<blockquote>No results found for <?php echo escape($_POST['spID']); ?>.</blockquote>
	<?php } 
} ?> 


<?php include "../templates/footer.php"; ?>