
<?php include "../templates/header.php"; ?>


<h2>Unpaid Customer Statements</h2>
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
<!-- get all unpaid statements for a service provider-->
<?php if (isset($_POST['submit'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, co.contractID, endDate, transAmount
                FROM c9.Customer cu, c9.Contract co, c9.Payment p, c9.Statement s, c9.Transactions t
                WHERE cu.idNo = co.idNo
                AND co.idNo = p.idNo
                AND p.paid = 0
                AND p.methodID = t.methodID
                AND co.contractID = s.contractID
                AND cu.serviceProviderID = :spID
                AND transAmount > 0
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
<!-- just get upnaid statement for a customer id-->
<?php if (isset($_POST['submitID'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, co.contractID, endDate, transAmount
                FROM c9.Customer cu, c9.Contract co, c9.Payment p, c9.Statement s, c9.Transactions t
                WHERE cu.idNo = :idNo
                AND cu.idNo = co.idNo
                AND co.idNo = p.idNo
                AND p.paid = 0
                AND p.methodID = t.methodID
                AND co.contractID = s.contractID
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

<!--just get unpaid statement for contract id-->
<?php if (isset($_POST['submitCo'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, co.contractID, endDate, transAmount
                FROM c9.Customer cu, c9.Contract co, c9.Payment p, c9.Statement s, c9.Transactions t
                WHERE co.contractID = :contractID
                AND cu.idNo = co.idNo
                AND co.idNo = p.idNo
                AND p.paid = 0
                AND p.methodID = t.methodID
                AND co.contractID = s.contractID
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
		<h2 align="center">Customers with Outstanding Statements</h2>
		<table align="center">
			<thead>
				<tr>
					<th>Customer ID</th>
					<th>Contract ID</th>
					<th>Statement Date</th>
					<th>Amount Owing</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["idNo"]); ?></td>
				<td><?php echo escape($row["contractID"]); ?></td>
				<td><?php echo escape($row["endDate"]); ?></td>
				<td><?php echo escape($row["transAmount"]); ?></td>
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