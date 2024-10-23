<?php

if (isset($errors) && is_array($errors)) {
	$html->div('class="alert alert-danger" role="alert"');
	foreach ($errors as $key => $error) {
		foreach ($error as $message) {
			$html->div();
				echo $message;
			$html->div;
		}
	}
	$html->div;
}

if (isset($errors) && !is_array($errors)) {
	$html->div('class="alert alert-danger" role="alert"');
		echo $errors;
	$html->div;
}

if (isset($success) && is_array($success)) {
	$html->div('class="alert alert-success" role="alert"');
	foreach ($success as $key => $success) {
		foreach ($success as $message) {
			$html->div();
				echo $message;
			$html->div;
		}
	}
	$html->div;
}

if (isset($success) && !is_array($success)) {
	$html->div('class="alert alert-success" role="alert"');
		echo $success;
	$html->div;
}