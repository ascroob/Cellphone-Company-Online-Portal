
<?php include "../templates/header.php"; ?>


<h2>Customer Contracts Expiring in Less than 4 Months</h2>
<br>
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

		$connection = new PDO($dsn, $username, $password, $options);
		
		$sql = "SELECT cu.idNo, clientName, clientEmail, contractLength, contractID
                FROM c9.Customer cu, c9.Contract co
                WHERE contractLength < 4
                AND cu.idNo = co.idNo
                AND serviceProviderID = :spID";
				
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
		<h2>Customers with Outstanding Statements</h2>
		<table>
			<thead>
				<tr>
					<th>Customer ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Contract Length</th>
					<th>Contract ID</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["idNo"]); ?></td>
				<td><?php echo escape($row["clientName"]); ?></td>
				<td><?php echo escape($row["clientEmail"]); ?></td>
				<td><?php echo escape($row["contractLength"]); ?></td>
				<td><?php echo escape($row["contractID"]); ?></td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<blockquote>No results found for <?php echo escape($_POST['spID']); ?>.</blockquote>
	<?php } 
} ?> 


<?php include "../templates/footer.php"; ?>