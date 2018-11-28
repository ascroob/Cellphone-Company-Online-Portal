<?php
/**
 * Use an HTML form to edit an entry in the
 * users table.
 *
 */
    require "../../connect.php";
    require "../../common.php";
    if (isset($_POST['submit'])) {
      try {
        $connection = new PDO($dsn, $host, $pass, $options);
        $customer =[
          "idNo"        => $_POST['idNo'],
          "clientName" => $_POST['clientName'],
          "clientAddress"  => $_POST['clientAddress'],
          "clientEmail"     => $_POST['clientEmail'],
          "birthDate"       => $_POST['birthDate']
        ];
    
        $sql = "UPDATE c9.Customer 
                SET idNo = :idNo, 
                  clientName = :clientName, 
                  clientAddress = :clientAddress, 
                  clientEmail = :clientEmail, 
                  birthDate = :birthDate
                WHERE idNo = :idNo";
      
      $statement = $connection->prepare($sql);
      $statement->execute($customer);
      } catch(PDOException $error) {
          echo $sql . "<br>" . $error->getMessage();
      }
    }
      
    if (isset($_GET['idNo'])) {
      try {
        $connection = new PDO($dsn, $host, $pass, $options);
        $idNo = $_GET['idNo'];
        $sql = "SELECT * FROM c9.Customer WHERE idNo = :idNo";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':idNo', $idNo);
        $statement->execute();
        
        $customer = $statement->fetch(PDO::FETCH_ASSOC);
      } catch(PDOException $error) {
          echo $sql . "<br>" . $error->getMessage();
      }
    } else {
        echo "Something went wrong!";
        exit;
    }
?>

<?php require "../templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote><?php echo escape($_POST['clientName']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit</h2>
<p>Note: Customer ID, Date Joined, and Service Provider ID cannot be edited.</p>

<form method="post">
    <?php  foreach ($customer as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <input type="submit" name="submit" value="Submit"><br>
    <?php endforeach; ?> 
    
</form>

<?php require "../templates/footer.php"; ?>