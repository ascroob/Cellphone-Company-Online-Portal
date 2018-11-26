
<?php include "../templates/header.php";  ?>


<h2>View Plans</h2>

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
		include "../../authen_login.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT cu.idNo, p.planID, textAmount, minAmount, dataAmount
                FROM c9.Customer cu, c9.Contract co, c9.Statement s, c9. Plan p
                WHERE cu.idNo = co.idNo
                AND co.contractID = s.contractID
                AND s.planID = p.planID
                AND cu.serviceProviderID = $spID
              
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
		<h2>Result</h2>
		<table>
			<thead>
				<tr>
					<th>Customer ID</th>
					<th>Plan ID</th>
					<th>Text Limit</th>
					<th>Minutes Limit</th>
					<th>Data Limit</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["idNo"]); ?></td>
				<td><?php echo escape($row["planID"]); ?></td>
				<td><?php echo escape($row["textAmount"]); ?></td>
				<td><?php echo escape($row["minAmount"]); ?></td>
				<td><?php echo escape($row["dataAmount"]); ?> GB</td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<blockquote>No results found for <?php echo escape($_POST['spID']); ?>.</blockquote>
	<?php } 
} ?> 


<?php include "../templates/footer.php"; ?>