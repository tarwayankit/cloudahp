<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Cloud AHP</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
</head>

<body>
<header>
	<h1>Decision Support System with AHP method</h1>
</header>

<div class="wrapper">
	<nav id="navigation" role="navigation">
		<ul>
			<li><a class="item" href="index.php">Home</a></li>
			<li>
				<a class="item" href="criteria.php">Criteria
					<div class="ui blue tiny label" style="float: right;"><?php echo getTotalCriteria(); ?></div>
				</a>
			</li>
			<li>
				<a class="item" href="alternative.php">Alternative
					<div class="ui blue tiny label" style="float: right;"><?php echo getTotalAlternative(); ?></div>
				</a>
			</li>
			<li><a class="item" href="weight_criteria.php">Comparison of Criteria</a></li>
			<li><a class="item" href="weight.php?c=1">Comparison of Alternative</a></li>
				<ul>
					<?php

						if (getTotalCriteria() > 0) {
							for ($i=0; $i <= (getTotalCriteria()-1); $i++) { 
								echo "<li><a class='item' href='weight.php?c=".($i+1)."'>".getCriteriaName($i)."</a></li>";
							}
						}

					?>
				</ul>
			<li><a class="item" href="result.php">Result</a></li>
		</ul>
	</nav>