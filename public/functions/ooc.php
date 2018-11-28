
<?php include "../templates/header.php"; ?>

<h2>Customers Out of the Country</h2>
<br>
<form method="post">
	<label for="spID">Service Provider ID</label>
	<input type="text" id="spID" name="spID">
	<input type="submit" name="submit" value="View Results">
</form>
<br>
<p>Or search by:</p>
<br>
<form method="post">
	<label for="daysOut">Number of days out of the country</label>
	<input type="text" id="daysOut" name="daysOut">
	<input type="submit" name="submitDO" value="View Results">
</form>
<br>

<!-- view all customers currently out of the country-->
<?php if (isset($_POST['submit'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT c.idNo, clientName, phoneNo, daysOut
                FROM c9.Customer c
                INNER JOIN c9.Phone p 
                	ON c.idNo = p.idNo
                WHERE inCntry = 0 
                AND daysOut > 0 
                AND serviceProviderID = :spID
                GROUP BY c.idNo";
				
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


<!-- view all customers currently out of the country by number of days-->
<?php if (isset($_POST['submitDO'])) {
	try {
		require "../../connect.php";
		require "../../common.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$sql = "SELECT c.idNo, clientName, phoneNo, daysOut
                FROM c9.Customer c
                INNER JOIN c9.Phone p 
                	ON c.idNo = p.idNo
                WHERE inCntry = 0 
                AND daysOut = :daysOut
                GROUP BY c.idNo";
				
		$daysOut = $_POST['daysOut'];
		
		$statement = $connection->prepare($sql);
        $statement->bindParam(':daysOut', $daysOut, PDO::PARAM_STR);
        $statement->execute();
        
        $result = $statement->fetchAll();
        
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>


<?php  
if (isset($_POST['submit']) || isset($_POST['submitDO'])) {
	if ($result && $statement->rowCount() > 0) { ?>
		<h2 align = "center">Results</h2>

		<table align = "center">
			<thead>
				<tr>
					<th>Customer ID</th>
					<th>Name</th>
					<th>Phone Number</th>
					<th>Days out of Country</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["idNo"]); ?></td>
				<td><?php echo escape($row["clientName"]); ?></td>
				<td><?php echo escape($row["phoneNo"]); ?></td>
				<td><?php echo escape($row["daysOut"]); ?></td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<blockquote align = "center">Hmm...it doesn't appear that anyone has left the country for that long.</blockquote>
	<?php } 
} ?> 

<br><br>

<?php include "../templates/footer.php"; ?>