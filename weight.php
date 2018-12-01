<?php
	include('config.php');
	include('function.php');

	$jenis = $_GET['c'];

	include('header.php');
?>
<section class="content">
	<h2 class="ui header">Alternative comparison &rarr; <?php echo getCriteriaName($jenis-1) ?></h2>
	<?php showTableComparison($jenis,'alternative'); ?>
</section>

<?php include('footer.php'); ?>