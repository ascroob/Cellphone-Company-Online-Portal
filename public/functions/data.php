
<?php include "../templates/header.php"; ?>

<?php if (isset($_POST['submit'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $username, $password, $options);
		
		$sql = "SELECT c.idNo, clientName, currData
                FROM c9.Customer c, c9.Phone p
                WHERE c.idNo = p.idNo
                AND dateJoined > 2018-11-20
                AND serviceProviderID = :spID
                GROUP BY c.idNo;";
				
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
		<h2>Results</h2>

		<table>
			<thead>
				<tr>
					<th>Customer ID</th>
					<th>Name</th>
					<th>Data Usage (GB)</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["idNo"]); ?></td>
				<td><?php echo escape($row["clientName"]); ?></td>
				<td><?php echo escape($row["currData"]); ?></td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<blockquote>No results found for <?php echo escape($_POST['spID']); ?>.</blockquote>
	<?php } 
} ?> 


<h2>Customers out of the Country</h2>

<form method="post">
	<label for="spID">Service Provider ID</label>
	<input type="text" id="spID" name="spID">
	<input type="submit" name="submit" value="View Results">
</form>

<a href="../index.php">Back to home</a>

<?php include "../templates/footer.php"; ?>