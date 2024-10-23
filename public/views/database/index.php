<div class="container">
	<?php if (isset($responses) && is_array($responses)) : ?>
		<h1>Configuração de banco de dados</h1>
		<ul>
		<?php
		foreach ($responses as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $key => $value) {
					echo '<li>' . $value . '</li>';
				}
			} else {
				echo '<li>' . $value . '</li>';
			}
		}
		?>
		</ul>
	<?php endif; ?>
		
	<?php if (isset($fakeData) && is_array($fakeData)) : ?>
		<h1>Dados fake</h1>
		<ul>
		<?php
		foreach ($fakeData as $key => $value) {
			echo '<li>' . $value . '</li>';
		}
		?>
		</ul>
	<?php endif; ?>
</div>

<style>
	.container {
		max-width: 600px;
		margin: 0 auto;
		background-color: #f0f0f0;
		padding: 20px;
		border-radius: 10px;
	}
	h1 {
		color: #333;
	}
	ul {
		list-style: none;
		padding: 0;
		background-color: #fff;
		border-radius: 10px;
	}
	li {
		padding: 10px;
		border-bottom: 1px solid #ddd;
	}
</style>