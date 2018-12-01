<?php
	include('config.php');
	include('function.php');

	// get edit data
	if(isset($_GET['jenis'])) {
		$jenis	= $_GET['jenis'];
	}

	if (isset($_POST['add'])) {
		$jenis	= $_POST['jenis'];
		$name = $_POST['name'];

		AddData($jenis,$name);

		header('Location: '.$jenis.'.php');
	}

	include('header.php');
?>

<section class="content">
	<h2>ADD <?php echo $jenis?></h2>

	<form class="ui form" method="post" action="add.php">
		<div class="inline field">
			<label>Name <?php echo $jenis ?></label>
			<input type="text" name="name" placeholder="<?php echo $jenis?>Input">
			<input type="hidden" name="jenis" value="<?php echo $jenis?>">
		</div>
		<br>
		<input class="ui green button" type="submit" name="add" value="SUBMIT">
	</form>
</section>

<?php include('footer.php'); ?>