
<?php include "../templates/header.php"; ?>


<h2>View All Customer Statements</h2>
<br>

<form method="post">
	<label for="spID">Service Provider ID</label>
	<input type="text" id="spID" name="spID">
	<input type="submit" name="submit" value="View Results">
</form>
<br>
<p> Or search by:</p>
<br>
<form method="post">
	<label for="idNo">Customer ID</label>
	<input type="text" id="idNo" name="idNo">
	<input type="submit" name="submitID" value="View Results">
</form>
<br>
<p> Or search by:</p>
<br>
<form method="post">
	<label for="contractID">Contract ID</label>
	<input type="text" id="contractID" name="contractID">
	<input type="submit" name="submitCo" value="View Results">
</form>
<br>

<p>Note: There may be an additional charge added to the final transaction amount for customers who have left the country.</p>
<br>
<!--find all statements for a provider-->
<?php if (isset($_POST['submit'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, s.contractID, planID, startDate, endDate, monthlyFee, overChargeFee
                FROM c9.Customer cu, c9.Contract co, c9.Statement s
                WHERE co.contractID = s.contractID
                AND cu.idNo = co.idNo
                AND serviceProviderID = :spID
                GROUP BY cu.idNo";
				
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
<!-- search by customer id -->
<?php if (isset($_POST['submitID'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, s.contractID, planID, startDate, endDate, monthlyFee, overChargeFee
                FROM c9.Customer cu, c9.Contract co, c9.Statement s
                WHERE cu.idNo = :idNo
                AND co.contractID = s.contractID
                AND cu.idNo = co.idNo
                GROUP BY cu.idNo";
				
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

<!--find statement by contract id-->
<?php if (isset($_POST['submitCo'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, s.contractID, planID, startDate, endDate, monthlyFee, overChargeFee
                FROM c9.Customer cu, c9.Contract co, c9.Statement s
                WHERE s.contractID = :contractID 
                AND co.contractID = s.contractID
                AND cu.idNo = co.idNo
                GROUP BY cu.idNo";
				
		$contractID = $_POST['contractID'];
		
		$statement = $connection->prepare($sql);
        $statement->bindParam(':contractID', $contractID, PDO::PARAM_STR);
        $statement->execute();
        
        $result = $statement->fetchAll();
        
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>


<?php  
if (isset($_POST['submit']) || isset($_POST['submitID']) || isset($_POST['submitCo'])) {
	if ($result && $statement->rowCount() > 0) { ?>
		<h2 align="center">Results</h2>
		<table align="center">
			<thead>
				<tr>
					<th>Customer ID</th>
					<th>Contract ID</th>
					<th>Plan ID</th>
					<th>start Date</th>
					<th>End Date </th>
					<th>Monthly Fee</th>
					<th>Over Charge Fee</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["idNo"]); ?></td>
				<td><?php echo escape($row["contractID"]); ?></td>
				<td><?php echo escape($row["planID"]); ?></td>
				<td><?php echo escape($row["startDate"]); ?></td>
				<td><?php echo escape($row["endDate"]); ?></td>
				<td><?php echo escape($row["monthlyFee"]); ?></td>
				<td><?php echo escape($row["overChargeFee"]); ?></td>
				
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<h3 align = "center">No results found. Please enter a valid input.</h3>
	<?php } 
} ?> 
<br><br>


<?php include "../templates/footer.php"; ?>