
<?php include "../templates/header.php";  ?>


<h2>View Plans</h2>
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

<!-- view all plans for service provider-->
<?php if (isset($_POST['submit'])) {
	try {
		require "../../connect.php";
		require "../../common.php";
		include "../../authen_login.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, p.planID, textAmount, minAmount, dataAmount, co.contractID, serviceProviderID
                FROM c9.Customer cu, c9.Contract co, c9.Statement s, c9.Plan p
                WHERE cu.idNo = co.idNo
                AND co.contractID = s.contractID
                AND s.planID = p.planID
                AND cu.serviceProviderID = :spID
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

<!-- search for a customer's plan based on their ID -->
<?php if (isset($_POST['submitID'])) {
	try {
		require "../../connect.php";
		require "../../common.php";
		include "../../authen_login.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, p.planID, textAmount, minAmount, dataAmount, co.contractID, serviceProviderID
                FROM c9.Customer cu, c9.Contract co, c9.Statement s, c9.Plan p
                WHERE cu.idNo = co.idNo
                AND co.contractID = s.contractID
                AND s.planID = p.planID
                AND cu.idNo = :idNo
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

<!-- search for a plan based on a contract ID-->
<?php if (isset($_POST['submitCo'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, p.planID, textAmount, minAmount, dataAmount, co.contractID, serviceProviderID
                FROM c9.Customer cu, c9.Contract co, c9.Statement s, c9.Plan p
                WHERE cu.idNo = co.idNo
                AND co.contractID = s.contractID
                AND s.planID = p.planID
                AND co.contractID = :contractID
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
		<h2 align = "center">Result</h2>
		<table align = "center">
			<thead>
				<tr>
					<th>Service Provider ID</th>
					<th>Customer ID</th>
					<th>Contract ID</th>
					<th>Plan ID</th>
					<th>Text Limit</th>
					<th>Minutes Limit</th>
					<th>Data Limit</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["serviceProviderID"]); ?></td>
				<td><?php echo escape($row["idNo"]); ?></td>
				<td><?php echo escape($row["contractID"]); ?></td>
				<td><?php echo escape($row["planID"]); ?></td>
				<td><?php echo escape($row["textAmount"]); ?></td>
				<td><?php echo escape($row["minAmount"]); ?></td>
				<td><?php echo escape($row["dataAmount"]); ?> GB</td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<h3 align = "center">No results found. Please enter a valid input.</blockquote>
	<?php } 
} ?> 

<br><br>

<?php include "../templates/footer.php"; ?>