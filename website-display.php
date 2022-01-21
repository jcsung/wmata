#!/usr/bin/php
<?php
require 'get.php'; 

function prettifyTime($value) {
	if ($value === "ARR" || $value === "BRD" || $value === "---" || $value === "") return $value;
	return $value . " MIN";
}
?>
<html>
<head>
<title>Clarendon Station WMATA Arrivals</title>
<style>
body {
	font-family: Sans-serif;
}
.container {
	display: flex;
	justify-content: space-between;
	width: 100%;
}
.container-centered-text {
	align-items: center;
	display: flex;
	flex-direction: column;
}
.half {
	width: 50%;
}
.half + .half {
	border-left: 1px solid black;
}
.container span {
	font-size: 30px;
	font-weight: bold;
	text-align: left;
}
.container .time {
	text-align: right;
	width: 25%;
}
.container .accessibility {
	width: 25%;
}
h1 {
	font-size: 56px;
}
h2 {
	font-size: 40px;
}

@media only screen and (max-width: 1200px) {
	.container.outer {
		display: flex;
		flex-direction: column;
		justify-content: flex-start;	
	}
	.half {
		width: 100%;
	}
	.half + .half {
		border-left: 0;
		border-top: 1px solid black;
	}
}
</style>
</head>
<body>
<div class="container-centered-text"><h1>Clarendon Station</h1></div>
<div class="container outer">
<?php
	for ($i = 1; $i <= 2; $i++) {
?>
		<div class="half container-centered-text">
			<h2><?php echo $DIRECTION[$i]; ?></h2>
<?php
			for ($j = 0; $hasData && $j < sizeOf($options[$i]); $j++) {
?>
				<div class="container" style="background-color: #<?php echo $LINEBGCOLORS[$options[$i][$j]['line']]; ?>;">
					<span class="accessibility" style="background-color: #<?php echo $LINEBGCOLORS[$options[$i][$j]['line']]; ?>; color: #<?php echo $LINETXCOLORS[$options[$i][$j]['line']]; ?>;"><?php echo $options[$i][$j]['line']; ?></span>
					<span class="destination" style="background-color: #<?php echo $LINEBGCOLORS[$options[$i][$j]['line']]; ?>; color: #<?php echo $LINETXCOLORS[$options[$i][$j]['line']]; ?>;"><?php echo $options[$i][$j]['dest']; ?></span>
					<span class="time" style="background-color: #<?php echo $LINEBGCOLORS[$options[$i][$j]['line']]; ?>; color: #<?php echo $LINETXCOLORS[$options[$i][$j]['line']]; ?>;"><?php echo prettifyTime($options[$i][$j]['time']); ?></span>
				</div>
<?php
			}

			if (!$hasData) {
?>
				<div class="conatiner">
					No Data
				</div>
<?php
			}
?>
		</div>		
<?php
	}
?>
</div>
</body>
</html>
