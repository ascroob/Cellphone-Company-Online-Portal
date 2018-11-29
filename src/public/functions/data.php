
<?php include "../templates/header.php"; ?>

<h2>Monthly Usage</h2>
<br>
<form method="post">
	<label for="idNo">Customer ID</label>
	<input type="text" id="idNo" name="idNo">
	<input type="submit" name="submit" value="View Results">
</form>
<br>


<?php if (isset($_POST['submit'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT c.idNo, clientName, currTxt, textAmount, currMin, minAmount, currData, dataAmount
                FROM c9.Customer c, c9.Phone p, c9.Contract co, c9.Statement s, c9.Plan pl
                WHERE c.idNo = :idNo
                AND c.idNo = p.idNo
                AND c.idNo = co.idNo
                AND co.contractID = s.contractID
                AND s.planID = pl.planID
                GROUP BY c.idNo;";
				
		$serviceProviderID = $_POST['idNo'];
		
		$statement = $connection->prepare($sql);
        $statement->bindParam(':idNo', $serviceProviderID, PDO::PARAM_STR);
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
		<h2 align = "center">Results</h2>

		<table align = "center">
			<thead>
				<tr>
					<th>Customer ID</th>
					<th>Name</th>
					<th>Current Texts</th>
					<th>Text Limit</th>
					<th>Current Minutes</th>
					<th>Minutes Limit</th>
					<th>Data Usage</th>
					<th>Data Limit</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["idNo"]); ?></td>
				<td><?php echo escape($row["clientName"]); ?></td>
				<td><?php echo escape($row["currTxt"]); ?></td>
				<td><?php echo escape($row["textAmount"]); ?></td>
				<td><?php echo escape($row["currMin"]); ?></td>
				<td><?php echo escape($row["minAmount"]); ?></td>
				<td><?php echo escape($row["currData"]); ?> GB</td>
				<td><?php echo escape($row["dataAmount"]); ?> GB</td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<h3 align = "center">No valid ID found for <?php echo escape($_POST['idNo']); ?>.</h3>
	<?php } 
} ?> 
<br><br>

<?php include "../templates/footer.php"; ?>