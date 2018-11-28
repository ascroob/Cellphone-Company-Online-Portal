
<?php include "../templates/header.php"; ?>


<h2>View Transactions</h2>
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
	<label for="contractID">Transaction Number</label>
	<input type="text" id="transNo" name="transNo">
	<input type="submit" name="submitT" value="View Results">
</form>
<br>

<!-- view all transactions for a service provider-->
<?php if (isset($_POST['submit'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, transNo, transDate, transAmount, serviceProviderID
                FROM c9.Customer cu, c9.Payment p, c9.Transactions t
                WHERE cu.idNo = p.idNo
                AND p.methodID = t.methodID
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

<!-- search for transactions based on customer id-->
<?php if (isset($_POST['submitID'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, transNo, transDate, transAmount, serviceProviderID
                FROM c9.Customer cu, c9.Payment p, c9.Transactions t
                WHERE cu.idNo = p.idNo
                AND p.methodID = t.methodID
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

<!-- view all transactions based on contract id -->
<?php if (isset($_POST['submitT'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, transNo, transDate, transAmount, serviceProviderID
                FROM c9.Customer cu, c9.Payment p, c9.Transactions t
                WHERE cu.idNo = p.idNo
                AND p.methodID = t.methodID
                AND transNo = :transNo
                GROUP BY cu.idNo";
				
		$transNo = $_POST['transNo'];
		
		$statement = $connection->prepare($sql);
        $statement->bindParam(':transNo', $transNo, PDO::PARAM_STR);
        $statement->execute();
        
        $result = $statement->fetchAll();
        
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>

<?php  
if (isset($_POST['submit']) || isset($_POST['submitID']) || isset($_POST['submitT'])) {
	if ($result && $statement->rowCount() > 0) { ?>
		<h2 align = "center">Result</h2>
		<table align = "center">
			<thead>
				<tr>
					<th>Service Provider ID</th>
					<th>Customer ID</th>
					<th>Transaction Number</th>
					<th>Transaction Date</th>
					<th>Transaction Amount</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["serviceProviderID"]); ?></td>
				<td><?php echo escape($row["idNo"]); ?></td>
				<td><?php echo escape($row["transNo"]); ?></td>
				<td><?php echo escape($row["transDate"]); ?></td>
				<td>$<?php echo escape($row["transAmount"]); ?></td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<blockquote>No results found for <?php echo escape($_POST['spID']); ?>.</blockquote>
	<?php } 
} ?> 

<br><br>
<?php include "../templates/footer.php"; ?>