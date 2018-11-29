
<?php include "../templates/header.php"; ?>


<h2>Customer Contracts Expiring in Less than 4 Months</h2>
<br>
<form method="post">
	<label for="spID">Service Provider ID</label>
	<input type="text" id="spID" name="spID">
	<input type="submit" name="submit" value="View Results">
</form>
<br>
<p>Or check when a contract will expire:</p>
<br>
<form method="post">
	<label for="idNo">Customer ID</label>
	<input type="text" id="idNo" name="idNo">
	<input type="submit" name="submitID" value="View Results">
</form>
<br>

<!-- view all contracts expiring in 4 months or less-->
<?php if (isset($_POST['submit'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
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

<!-- view when a specific contract expires-->
<?php if (isset($_POST['submitID'])) {
	try {
		
		require "../../connect.php";
		require "../../common.php";
		
		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, clientName, clientEmail, contractLength, contractID
                FROM c9.Customer cu, c9.Contract co
                WHERE cu.idNo = co.idNo
                AND co.idNo = :idNo";
				
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

<?php  
if (isset($_POST['submit']) || isset($_POST['submitID'])) {
	if ($result && $statement->rowCount() > 0) { ?>
		<h2 align = "center">Contract Expiration Date</h2>
		<table align = "center">
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
				<td><?php echo escape($row["contractLength"]); ?> months</td>
				<td><?php echo escape($row["contractID"]); ?></td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<h3 align = "center">Cannot find contract. Double check contract number.<br>
			Otherwise, you may have entered an invalid Service Provider ID.</h3>
	<?php } 
} ?> 

<br><br>
<?php include "../templates/footer.php"; ?>