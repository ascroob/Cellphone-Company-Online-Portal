
<?php include "../templates/header.php"; ?>


<h2>View All Customer Statements</h2>

<form method="post">
	<label for="spID">Service Provider ID</label>
	<input type="text" id="spID" name="spID">
	<input type="submit" name="submit" value="View Results">
</form>
<br>

<p>Note: There may be an additional charge added to the final transaction amount for customers who have left the country.</p>

<?php if (isset($_POST['submit'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $username, $password, $options);
		
		$sql = "SELECT cu.idNo, clientName, s.contractID, planID, startDate, endDate, monthlyFee, overChargeFee
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


<?php  
if (isset($_POST['submit'])) {
	if ($result && $statement->rowCount() > 0) { ?>
		<h2>Results</h2>
		<table>
			<thead>
				<tr>
					<th>Customer ID</th>
					<th>Name</th>
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
				<td><?php echo escape($row["clientName"]); ?></td>
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
		<blockquote>No results found for <?php echo escape($_POST['spID']); ?>.</blockquote>
	<?php } 
} ?> 


<?php include "../templates/footer.php"; ?>