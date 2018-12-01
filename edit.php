<?php
	include('config.php');
	include('function.php');

	// get edit data
	if(isset($_GET['jenis']) && isset($_GET['id'])) {
		$id 	= $_GET['id'];
		$jenis	= $_GET['jenis'];

		// delete record
		$query 	= "SELECT name FROM $jenis WHERE id=$id";
		$result	= mysqli_query($shobhit, $query);
		
		while ($row = mysqli_fetch_array($result)) {
			$name = $row['name'];
		}
	}

	if (isset($_POST['update'])) {
		$id 	= $_POST['id'];
		$jenis	= $_POST['jenis'];
		$name 	= $_POST['name'];

		$query 	= "UPDATE $jenis SET name='$name' WHERE id=$id";
		$result	= mysqli_query($shobhit, $query);

		if (!$result) {
			echo "Update failed";
			exit();
		} else {
			header('Location: '.$jenis.'.php');
			exit();
		}
	}

	include('header.php');
?>

<section class="content">
	<h2>Edit <?php echo $jenis?></h2>

	<form class="ui form" method="post" action="edit.php">
		<div class="inline field">
			<label>Name<?php echo $jenis ?></label>
			<input type="text" name="name" value="<?php echo $name?>">
			<input type="hidden" name="id" value="<?php echo $id?>">
			<input type="hidden" name="jenis" value="<?php echo $jenis?>">
		</div>
		<br>
		<input class="ui green button" type="submit" name="update" value="UPDATE">
	</form>
</section>

<?php include('footer.php'); ?>