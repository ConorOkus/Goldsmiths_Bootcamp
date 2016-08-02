<?php

$required = ['name', 'email', 'phonenumber'];

//Check $_POST Array
foreach ($_POST as $key => $value) {
	if (in_array($key, $required)) {
		if (!is_array($value)) {
			$value = trim($value);
		}
		if (empty($value) && in_array($key, $required)) {
			$$key = '';
			$missing[] = $key;
		} else {
			$$key = $value;
		}
	}
} 


?>
