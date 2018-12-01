<?php

include('config.php');
include('function.php');


// calculate rank
$jmlKriteria 	= getTotalCriteria();
$jmlAlternatif	= getTotalAlternative();
$value		= array();

// get the value of each alternative
for ($x=0; $x <= ($jmlAlternatif-1); $x++) {
	// initialization
	$value[$x] = 0;

	for ($y=0; $y <= ($jmlKriteria-1); $y++) {
		$id_alternative	= getAlternativeID($x);
		$id_criteria	= getCriteriaID($y);

		$pv_alternative	= getAlternativePV($id_alternative,$id_criteria);
		$pv_criteria	= getCriteriaPV($id_criteria);

		$value[$x]	 	+= ($pv_alternative * $pv_criteria);
	}
}

// update Value ranking
for ($i=0; $i <= ($jmlAlternatif-1); $i++) { 
	$id_alternative = getAlternativeID($i);
	$query = "INSERT INTO ranking VALUES ($id_alternative,$value[$i]) ON DUPLICATE KEY UPDATE value=$value[$i]";
	$result = mysqli_query($shobhit,$query);
	if (!$result) {
		echo "	Failed to update ranking";
		exit();
	}
}

include('header.php');

?>

<section class="content">
	<h2 class="ui header">The calculation results</h2>
	<table class="ui celled table">
		<thead>
		<tr>
			<th>Overall Composite Height</th>
			<th>Priority Vector</th>
			<?php
			for ($i=0; $i <= (getTotalAlternative()-1); $i++) { 
				echo "<th>".getAlternativeName($i)."</th>\n";
			}
			?>
		</tr>
		</thead>
		<tbody>

		<?php
			for ($x=0; $x <= (getTotalCriteria()-1) ; $x++) { 
				echo "<tr>";
				echo "<td>".getCriteriaName($x)."</td>";
				echo "<td>".round(getCriteriaPV(getCriteriaID($x)),5)."</td>";

				for ($y=0; $y <= (getTotalAlternative()-1); $y++) { 
					echo "<td>".round(getAlternativePV(getAlternativeID($y),getCriteriaID($x)),5)."</td>";
				}


				echo "</tr>";
			}
		?>
		</tbody>

		<tfoot>
		<tr>
			<th colspan="2">Total</th>
			<?php
			for ($i=0; $i <= ($jmlAlternatif-1); $i++) { 
				echo "<th>".round($value[$i],5)."</th>";
			}
			?>
		</tr>
		</tfoot>

	</table>


	<h2 class="ui header">Ranking</h2>
	<table class="ui celled collapsing table">
		<thead>
			<tr>
				<th>Rating</th>
				<th>Alternative</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query  = "SELECT id,name,id_alternative,value FROM alternative,ranking WHERE alternative.id = ranking.id_alternative ORDER BY value DESC";
				$result = mysqli_query($shobhit, $query);

				$i = 0;
				while ($row = mysqli_fetch_array($result)) {
					$i++;
				?>
				<tr>
					<?php if ($i == 1) {
						echo "<td><div class=\"ui ribbon label\">WINNER</div></td>";
					} else {
						echo "<td>".$i."</td>";
					}

					?>

					<td><?php echo $row['name'] ?></td>
					<td><?php echo $row['value'] ?></td>
				</tr>

				<?php	
				}


			?>
		</tbody>
	</table>
</section>

<?php include('footer.php'); ?>