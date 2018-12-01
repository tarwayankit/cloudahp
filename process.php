<?php

include('config.php');
include('function.php');


if (isset($_POST['submit'])) {
	$jenis = $_POST['jenis'];

	// total criteria
	if ($jenis == 'criteria') {
		$n		= getTotalCriteria();
	} else {
		$n		= getTotalAlternative();
	}
	$matrik = array();
	$urut 	= 0;

	for ($x=0; $x <= ($n-2) ; $x++) {
		for ($y=($x+1); $y <= ($n-1) ; $y++) {
			$urut++;
			$pilih	= "pilih".$urut;
			$bobot 	= "bobot".$urut;
			if ($_POST[$pilih] == 1) {
				$matrik[$x][$y] = $_POST[$bobot];
				$matrik[$y][$x] = 1 / $_POST[$bobot];
			} else {
				$matrik[$x][$y] = 1 / $_POST[$bobot];
				$matrik[$y][$x] = $_POST[$bobot];
			}


			if ($jenis == 'criteria') {
				inputDataComparisonCriteria($x,$y,$matrik[$x][$y]);
			} else {
				inputDataComparisonAlternative($x,$y,($jenis-1),$matrik[$x][$y]);
			}
		}
	}


	for ($i = 0; $i <= ($n-1); $i++) {
		$matrik[$i][$i] = 1;
	}

	// initialize the number of each column and row criteria
	$jmlmpb = array();
	$jmlmnk = array();
	for ($i=0; $i <= ($n-1); $i++) {
		$jmlmpb[$i] = 0;
		$jmlmnk[$i] = 0;
	}

	// calculate the number in the paired comparison table criteria column
	for ($x=0; $x <= ($n-1) ; $x++) {
		for ($y=0; $y <= ($n-1) ; $y++) {
			$value		= $matrik[$x][$y];
			$jmlmpb[$y] += $value;
		}
	}


	// calculate the number in the criterion criteria table value row
	// matrix is ​​a normalized matrix
	for ($x=0; $x <= ($n-1) ; $x++) {
		for ($y=0; $y <= ($n-1) ; $y++) {
			$matrikb[$x][$y] = $matrik[$x][$y] / $jmlmpb[$y];
			$value	= $matrikb[$x][$y];
			$jmlmnk[$x] += $value;
		}

		// value of  priority vektor
		$pv[$x]	 = $jmlmnk[$x] / $n;

		// 	enter the priority vector value into the pv_kriteria and pv_alternative tables
		if ($jenis == 'criteria') {
			$id_criteria = getCriteriaID($x);
			inputCriteriaPV($id_criteria,$pv[$x]);
		} else {
			$id_criteria	= getCriteriaID($jenis-1);
			$id_alternative	= getAlternativeID($x);
			inputAlternativePV($id_alternative,$id_criteria,$pv[$x]);
		}
	}

	// check consistency
	$eigenvektor = getEigenVector($jmlmpb,$jmlmnk,$n);
	$consIndex   = getConsIndex($jmlmpb,$jmlmnk,$n);
	$consRatio   = getConsRatio($jmlmpb,$jmlmnk,$n);

	if ($jenis == 'criteria') {
		include('output.php');
	} else {
		include('weight_result.php');
	}

}


?>
