<?php
	include('config.php');
	include('function.php');

	include('header.php');
?>
<section class="content">
	<h2 class="ui header">Comparison of Criteria</h2>
	<?php showTableComparison('criteria','criteria'); ?>
</section>

<?php include('footer.php'); ?>