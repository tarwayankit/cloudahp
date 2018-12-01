<?php

// Look For Criteria ID
// According to order (C1, C2, C3)
function getCriteriaID($no_urut) {
	include('config.php');
	$query  = "SELECT id FROM criteria ORDER BY id";
	$result = mysqli_query($shobhit, $query);

	while ($row = mysqli_fetch_array($result)) {
		$listID[] = $row['id'];
	}

	return $listID[($no_urut)];
}

// Look for Alternative ID
//According to what order (A1, A2, A3)
function getAlternativeID($no_urut) {
	include('config.php');
	$query  = "SELECT id FROM alternative ORDER BY id";
	$result = mysqli_query($shobhit, $query);

	while ($row = mysqli_fetch_array($result)) {
		$listID[] = $row['id'];
	}

	return $listID[($no_urut)];
}

// Search for Criteria Names
function getCriteriaName($no_urut) {
	include('config.php');
	$query  = "SELECT name FROM criteria ORDER BY id";
	$result = mysqli_query($shobhit, $query);

	while ($row = mysqli_fetch_array($result)) {
		$name[] = $row['name'];
	}

	return $name[($no_urut)];
}

// Search for Alternative Names
function getAlternativeName($no_urut) {
	include('config.php');
	$query  = "SELECT name FROM alternative ORDER BY id";
	$result = mysqli_query($shobhit, $query);

	while ($row = mysqli_fetch_array($result)) {
		$name[] = $row['name'];
	}

	return $name[($no_urut)];
}

// Look for Priority Vector of Alternatives
function getAlternativePV($id_alternative,$id_criteria) {
	include('config.php');
	$query = "SELECT value FROM pv_alternative WHERE id_alternative=$id_alternative AND id_criteria=$id_criteria";
	$result = mysqli_query($shobhit, $query);
	while ($row = mysqli_fetch_array($result)) {
		$pv = $row['value'];
	}

	return $pv;
}

// Look for Priority Vector of Criterias
function getCriteriaPV($id_criteria) {
	include('config.php');
	$query = "SELECT value FROM pv_criteria WHERE id_criteria=$id_criteria";
	$result = mysqli_query($shobhit, $query);
	while ($row = mysqli_fetch_array($result)) {
		$pv = $row['value'];
	}

	return $pv;
}

// Look for Total alternative Values
function getTotalAlternative() {
	include('config.php');
	$query  = "SELECT count(*) FROM alternative";
	$result = mysqli_query($shobhit, $query);
	while ($row = mysqli_fetch_array($result)) {
		$totaldata = $row[0];
	}

	return $totaldata;
}

// Total Criteria
function getTotalCriteria() {
	include('config.php');
	$query  = "SELECT count(*) FROM criteria";
	$result = mysqli_query($shobhit, $query);
	while ($row = mysqli_fetch_array($result)) {
		$TotalData = $row[0];
	}

	return $TotalData;
}

// add new member of criteria/alternative
function AddData($table,$name) {
	include('config.php');

	$query 	= "INSERT INTO $table (name) VALUES ('$name')";
	$add	= mysqli_query($shobhit, $query);

	if (!$add) {
		echo "Failed to add data".$table;
		exit();
	}
}

// delete criteria
function deleteCriteria($id) {
	include('config.php');

	// delete record dari tabel kriteria
	$query 	= "DELETE FROM criteria WHERE id=$id";
	mysqli_query($shobhit, $query);

	// hapus record dari tabel pv_kriteria
	$query 	= "DELETE FROM pv_criteria WHERE id_criteria=$id";
	mysqli_query($shobhit, $query);

	// hapus record dari tabel pv_alternatif
	$query 	= "DELETE FROM pv_alternative WHERE id_criteria=$id";
	mysqli_query($shobhit, $query);

	$query 	= "DELETE FROM comparison_criteria WHERE criteria1=$id OR criteria2=$id";
	mysqli_query($shobhit, $query);

	$query 	= "DELETE FROM comparison_alternative WHERE comparison=$id";
	mysqli_query($shobhit, $query);
}

// Delete ALternative
function deleteAlternative($id) {
	include('config.php');

	// Delete alternative
	$query 	= "DELETE FROM alternative WHERE id=$id";
	mysqli_query($shobhit, $query);

	// Delete Alternative from ranking table
	$query 	= "DELETE FROM pv_alternative WHERE id_alternative=$id";
	mysqli_query($shobhit, $query);

	// Delete record from ranking table
	$query 	= "DELETE FROM ranking WHERE id_alternative=$id";
	mysqli_query($shobhit, $query);

	$query 	= "DELETE FROM comparison_alternative WHERE alternative1=$id OR alternative2=$id";
	mysqli_query($shobhit, $query);
}

// enter the priority vector criteria value
function inputCriteriaPV ($id_criteria,$pv) {
	include ('config.php');

	$query = "SELECT * FROM pv_criteria WHERE id_criteria=$id_criteria";
	$result = mysqli_query($shobhit, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

	// if the result is empty then enter the new data
	//  if it is already there it is updated
	if (mysqli_num_rows($result)==0) {
		$query = "INSERT INTO pv_criteria (id_criteria, value) VALUES ($id_criteria, $pv)";
	} else {
		$query = "UPDATE pv_criteria SET value=$pv WHERE id_criteria=$id_criteria";
	}


	$result = mysqli_query($shobhit, $query);
	if(!$result) {
		echo "Failed to enter / update priority vector criteria ";
		exit();
	}

}

// enter an alternative priority vector value
function inputAlternativePV ($id_alternative,$id_criteria,$pv) {
	include ('config.php');

	$query  = "SELECT * FROM pv_alternative WHERE id_alternative = $id_alternative AND id_criteria = $id_criteria";
	$result = mysqli_query($shobhit, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

	// if the result is empty then enter the new data
	// if it is already there it is updated
	if (mysqli_num_rows($result)==0) {
		$query = "INSERT INTO pv_alternative (id_alternative,id_criteria,value) VALUES ($id_alternative,$id_criteria,$pv)";
	} else {
		$query = "UPDATE pv_alternative SET value=$pv WHERE id_alternative=$id_alternative AND id_criteria=$id_criteria";
	}

	$result = mysqli_query($shobhit, $query);
	if (!$result) {
		echo "Failed to enter / update alternative priority vector values";
		exit();
	}

}


// enter the comparison value weighting criteria
function inputDataComparisonCriteria($criteria1,$criteria2,$value) {
	include('config.php');

	$id_criteria1 = getCriteriaID($criteria1);
	$id_criteria2 = getCriteriaID($criteria2);

	$query  = "SELECT * FROM comparison_criteria WHERE criteria1 = $id_criteria1 AND criteria2 = $id_criteria2";
	$result = mysqli_query($shobhit, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

	// if the result is empty then enter the new data
	//if it is already there it is updated
	if (mysqli_num_rows($result)==0) {
		$query = "INSERT INTO comparison_criteria (criteria1,criteria2,value) VALUES ($id_criteria1,$id_criteria2,$value)";
	} else {
		$query = "UPDATE comparison_criteria SET value=$value WHERE criteria1=$id_criteria1 AND criteria2=$id_criteria2";
	}

	$result = mysqli_query($shobhit, $query);
	if (!$result) {
		echo "Failed to enter comparison data";
		exit();
	}

}

// enter the value of alternative comparison weights
function inputDataComparisonAlternative($alternative1,$alternative2,$comparison,$value) {
	include('config.php');


	$id_alternative1 = getAlternativeID($alternative1);
	$id_alternative2 = getAlternativeID($alternative2);
	$id_comparison  = getCriteriaID($comparison);

	$query  = "SELECT * FROM comparison_alternative WHERE alternative1 = $id_alternative1 AND alternative2 = $id_alternative2 AND comparison = $id_comparison";
	$result = mysqli_query($shobhit, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

//if the result is empty then enter the new data
	// if it is already there it is updated
	if (mysqli_num_rows($result)==0) {
		$query = "INSERT INTO comparison_alternative (alternative1,alternative2,comparison,value) VALUES ($id_alternative1,$id_alternative2,$id_comparison,$value)";
	} else {
		$query = "UPDATE comparison_alternative SET value=$value WHERE alternative1=$id_alternative1 AND alternative2=$id_alternative2 AND comparison=$id_comparison";
	}

	$result = mysqli_query($shobhit, $query);
	if (!$result) {
		echo "Failed to enter comparison data";
		exit();
	}

}

// look for the comparison weight of  criteria
function getValueComparisonCriteria($criteria1,$criteria2) {
	include('config.php');

	$id_criteria1 = getCriteriaID($criteria1);
	$id_criteria2 = getCriteriaID($criteria2);

	$query  = "SELECT value FROM comparison_criteria WHERE criteria1 = $id_criteria1 AND criteria2 = $id_criteria2";
	$result = mysqli_query($shobhit, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

	if (mysqli_num_rows($result)==0) {
		$value = 1;
	} else {
		while ($row = mysqli_fetch_array($result)) {
			$value = $row['value'];
		}
	} 

	return $value;
}

// look for the comparison weight of alternatives
function getValueComparisonAlternative($alternative1,$alternative2,$comparison) {
	include('config.php');

	$id_alternative1 = getAlternativeID($alternative1);
	$id_alternative2 = getAlternativeID($alternative2);
	$id_comparison  = getCriteriaID($comparison);

	$query  = "SELECT value FROM comparison_alternative WHERE alternative1 = $id_alternative1 AND alternative2 = $id_alternative2 AND comparison = $id_comparison";
	$result = mysqli_query($shobhit, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}
	if (mysqli_num_rows($result)==0) {
		$value = 1;
	} else {
		while ($row = mysqli_fetch_array($result)) {
			$value = $row['value'];
		}
	}

	return $value;
}

//  display the IR value
function getValueIR($jmlKriteria) {
	include('config.php');
	$query  = "SELECT value FROM ir WHERE total=$jmlKriteria";
	$result = mysqli_query($shobhit, $query);
	while ($row = mysqli_fetch_array($result)) {
		$valueIR = $row['value'];
	}

	return $valueIR;
}

// GetEigen Vector
function getEigenVector($matrik_a,$matrik_b,$n) {
	$eigenvektor = 0;
	for ($i=0; $i <= ($n-1) ; $i++) {
		$eigenvektor += ($matrik_a[$i] * (($matrik_b[$i]) / $n));
	}

	return $eigenvektor;
}

// Find Consistency Index
function getConsIndex($matrik_a,$matrik_b,$n) {
	$eigenvektor = getEigenVector($matrik_a,$matrik_b,$n);
	$consindex = ($eigenvektor - $n)/($n-1);

	return $consindex;
}

// Mencari Consistency Ratio
function getConsRatio($matrik_a,$matrik_b,$n) {
	$consindex = getConsIndex($matrik_a,$matrik_b,$n);
	$consratio = $consindex / getValueIR($n);

	return $consratio;
}

// Show FInal Table of Comparison
function showTableComparison($jenis,$criteria) {
	include('config.php');

	if ($criteria == 'criteria') {
		$n = getTotalCriteria();
	} else {
		$n = getTotalAlternative();
	}

	$query = "SELECT name FROM $criteria ORDER BY id";
	$result	= mysqli_query($shobhit, $query);
	if (!$result) {
		echo "Error connecting Database!!!";
		exit();
	}

	
	while ($row = mysqli_fetch_array($result)) {
		$pilihan[] = $row['name'];
	}

	// show table
	?>

	<form class="ui form" action="process.php" method="post">
	<table class="ui celled selectable collapsing table">
		<thead>
			<tr>
				<th colspan="2">choose more important</th>
				<th>comparison value</th>
			</tr>
		</thead>
		<tbody>

	<?php

	//initialization
	$urut = 0;

	for ($x=0; $x <= ($n - 2); $x++) {
		for ($y=($x+1); $y <= ($n - 1) ; $y++) {

			$urut++;

	?>
			<tr>
				<td>
					<div class="field">
						<div class="ui radio checkbox">
							<input name="pilih<?php echo $urut?>" value="1" checked="" class="hidden" type="radio">
							<label><?php echo $pilihan[$x]; ?></label>
						</div>
					</div>
				</td>
				<td>
					<div class="field">
						<div class="ui radio checkbox">
							<input name="pilih<?php echo $urut?>" value="2" class="hidden" type="radio">
							<label><?php echo $pilihan[$y]; ?></label>
						</div>
					</div>
				</td>
				<td>
					<div class="field">

	<?php
	if ($criteria == 'criteria') {
		$value = getValueComparisonCriteria($x,$y);
	} else {
		$value = getValueComparisonAlternative($x,$y,($jenis-1));
	}

	?>
						<input type="text" name="bobot<?php echo $urut?>" value="<?php echo $value?>" required>
					</div>
				</td>
			</tr>
			<?php
		}
	}

	?>
		</tbody>
	</table>
	<input type="text" name="jenis" value="<?php echo $jenis; ?>" hidden>
	<br><br><input class="ui submit button" type="submit" name="submit" value="SUBMIT">
	</form>

	<?php
}

?>
