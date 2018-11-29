<?php include '../templates/header.php'; ?>


<h2>Plan Statistics</h2>
<br>

<form method = "post">
Plans by Data Limit
<select name="formData" >
  <option value="">Select...</option>
  <option value="1">1 GB</option>
  <option value="3">3 GB</option>
  <option value="5">5 GB</option>
    <input type="submit" name="submitData" value="View Results">
</select>
</form>
<br>

<form method = "post">
Plans by Minutes Limit
<select name="formMin" >
  <option value="">Select...</option>
  <option value="100">100</option>
  <option value="500">500</option>
  <option value="1000">1000</option>
    <input type="submit" name="submitMin" value="View Results">
</select>
</form>
<br>

<form method = "post">
Plans by Text Limit
<select name="formText" id = "formText" method = "post">
  <option value="">Select...</option>
  <option value="1000">1000</option>
  <option value="5000">5000</option>
  <option value="10000">10000</option>
    <input type="submit" name="submitText" value="View Results">
</select>
</form>
<br>

<!-- view all plans by data usage-->
<?php if (isset($_POST['submitData'])) {
	try {
		require "../../connect.php";
		require "../../common.php";
		include "../../authen_login.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$selected_val = $_POST['formData'];
		
		$sql = "SELECT serviceProviderID, COUNT(dataAmount) as numPlans, dataAmount
                FROM c9.Customer cu, c9.Contract co, c9.Statement s, c9.Plan p
                WHERE cu.idNo = co.idNo
                AND co.contractID = s.contractID
                AND s.planID = p.planID
                AND dataAmount = $selected_val
                GROUP BY serviceProviderID";
				
		$dataAmount = $_POST['formData'];
		
		$statement = $connection->prepare($sql);
        $statement->bindParam(':formData', $dataAmount, PDO::PARAM_STR);
        $statement->execute();
        
        $result = $statement->fetchAll();
        
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>


<!-- view all plans by min usage-->
<?php if (isset($_POST['submitMin'])) {
	try {
		require "../../connect.php";
		require "../../common.php";
		include "../../authen_login.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$selected_val = $_POST['formMin'];
		
		$sql = "SELECT serviceProviderID, COUNT(minAmount) as numPlans, minAmount
                FROM c9.Customer cu, c9.Contract co, c9.Statement s, c9.Plan p
                WHERE cu.idNo = co.idNo
                AND co.contractID = s.contractID
                AND s.planID = p.planID
                AND minAmount = $selected_val
                GROUP BY serviceProviderID";
				
		$minAmount = $_POST['formMin'];
		
		$statement = $connection->prepare($sql);
        $statement->bindParam(':formMin', $minAmount, PDO::PARAM_STR);
        $statement->execute();
        
        $result = $statement->fetchAll();
        
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>


<!-- view all plans by min usage-->
<?php if (isset($_POST['submitText'])) {
	try {
		require "../../connect.php";
		require "../../common.php";
		include "../../authen_login.php";

		$connection = new PDO($dsn, $host, $pass, $options);
		
		$selected_val = $_POST['formText'];
		
		$sql = "SELECT serviceProviderID, COUNT(textAmount) as numPlans, textAmount
                FROM c9.Customer cu, c9.Contract co, c9.Statement s, c9.Plan p
                WHERE cu.idNo = co.idNo
                AND co.contractID = s.contractID
                AND s.planID = p.planID
                AND textAmount = $selected_val
                GROUP BY serviceProviderID";
				
		$textAmount = $_POST['formText'];
		
		$statement = $connection->prepare($sql);
        $statement->bindParam(':formText', $textAmount, PDO::PARAM_STR);
        $statement->execute();
        
        $result = $statement->fetchAll();
        
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>

<?php  
if (isset($_POST['submitData'])) {
	if ($result && $statement->rowCount() > 0) { ?>
		<h2 align = "center">Result</h2>
		<table align = "center">
			<thead>
				<tr>
					<th>Service Provider ID</th>
					<th>Number of Plans</th>
					<th>Data Limit</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["serviceProviderID"]); ?></td>
				<td><?php echo escape($row["numPlans"]); ?> </td>
				<td><?php echo escape($row["dataAmount"]); ?> GB</td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<h3 align = "center">No results found. Please enter a valid input.</blockquote>
	<?php } 
} ?> 


<?php  
if (isset($_POST['submitMin'])) {
	if ($result && $statement->rowCount() > 0) { ?>
		<h2 align = "center">Result</h2>
		<table align = "center">
			<thead>
				<tr>
					<th>Service Provider ID</th>
					<th>Number of Plans</th>
					<th>Minute Limit</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["serviceProviderID"]); ?></td>
				<td><?php echo escape($row["numPlans"]); ?> </td>
				<td><?php echo escape($row["minAmount"]); ?> min</td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<h3 align = "center">No results found. Please enter a valid input.</blockquote>
	<?php } 
} ?> 

<?php  
if (isset($_POST['submitText'])) {
	if ($result && $statement->rowCount() > 0) { ?>
		<h2 align = "center">Result</h2>
		<table align = "center">
			<thead>
				<tr>
					<th>Service Provider ID</th>
					<th>Number of Plans</th>
					<th>Text Limit</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["serviceProviderID"]); ?></td>
				<td><?php echo escape($row["numPlans"]); ?> </td>
				<td><?php echo escape($row["textAmount"]); ?> </td>
			</tr>
		<?php } ?> 
			</tbody>
	</table>
	<?php } else { ?>
		<h3 align = "center">No results found. Please enter a valid input.</blockquote>
	<?php } 
} ?> 


<br><br>

<center><?php include '../templates/footer.php'; ?></center>
