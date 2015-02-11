<?php
function pvp_global_stats($mysqli,$prefix){
	if ($stmt = $mysqli->prepare("SELECT * FROM `{$prefix}pvp`")) {
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$output[]=$row;
		}
		$stmt->close();
		if (!empty($output))return $output;
	}
}
function death_global_stats($mysqli,$prefix){
	if ($stmt = $mysqli->prepare("SELECT * FROM `{$prefix}death`")) {
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$output[]=$row;
		}
		$stmt->close();
		if (!empty($output))return $output;
	}
}
function kill_global_stats($mysqli,$prefix){
	if ($stmt = $mysqli->prepare("SELECT * FROM `{$prefix}kill`")) {
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$output[]=$row;
		}
		$stmt->close();
		if (!empty($output))return $output;
	}
}