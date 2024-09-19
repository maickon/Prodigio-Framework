<?php

if (isset($errors)) {
	$html->div('class="alert"');
	if(is_array($errors)) {
		foreach ($errors as $key => $error) {
			foreach ($error as $message) {
				$html->div('class="error"');
					echo $message;
				$html->div;
			}
		}
	} elseif(isset($errors)) {
		$html->div('class="error"');
			echo $errors;
		$html->div;
	}
	$html->div;
}

if (isset($success)) {
	$html->div('class="alert"');
	if(is_array($success)) {
		foreach ($success as $key => $success) {
			foreach ($success as $message) {
				$html->div('class="success"');
					echo $message;
				$html->div;
			}
		}
	} elseif(isset($success)) {
		$html->div('class="success"');
			echo $success;
		$html->div;
	}
	$html->div;
}