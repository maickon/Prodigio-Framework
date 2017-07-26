<?php
class Form_Core{
	
	function input($parameters){
		$tag = '<input';
		foreach($parameters as $key => $p):
			 $tag .= " {$key}=\"{$p}\" ";
		endforeach;
		$tag .= '>';
		echo $tag;
	}
	
	function label($name, $parameters = false){
		$tag = '<label';
		if($parameters):
			foreach($parameters as $key => $p):
				 $tag .= " {$key}=\"{$p}\" ";
			endforeach;
			$tag .= '>'.$name.'</label>';
		else:
			$tag .= '>'.$name.'</label>';
		endif;
		echo $tag;	
	}
	
	function _form($parameters){
		$tag = '<form';	
		foreach($parameters as $key => $p):
			 $tag .= " {$key}=\"{$p}\" ";
		endforeach;
		$tag .= '>';
		echo $tag;	
	}
	
	function form_(){
		echo '</form>';
	}
	
	function _div($parameters){
		$tag = '<div';
			foreach($parameters as $key => $p):
			$tag .= " {$key}=\"{$p}\" ";
		endforeach;
		$tag .= '>';
		echo $tag;
	}
	
	function div_(){
		echo '</div>';
	}
	
	function br(){
		echo '<br />';
	}
	
	function bold($string){
		return "<b>{$string}</b>";
	}
	
	function h1($text, $parameters = null){
		$tag = '<h1';
		if($parameters):
			foreach($parameters as $key => $p):
				$tag .= " {$key}=\"{$p}\" ";
			endforeach;
		endif;
		$tag .= '>'.$text.'</h1>';
		echo $tag;
	}
	
	function h2($text, $parameters = null){
		$tag = '<h2';
		if($parameters):
		foreach($parameters as $key => $p):
			$tag .= " {$key}=\"{$p}\" ";
			endforeach;
		endif;
		$tag .= '>'.$text.'</h2>';
		echo $tag;
	}
	
	function h3($text, $parameters = null){
		$tag = '<h3';
		if($parameters):
			foreach($parameters as $key => $p):
				$tag .= " {$key}=\"{$p}\" ";
			endforeach;
		endif;
		$tag .= '>'.$text.'</h3>';
		echo $tag;
	}
	
	function h4($text, $parameters = null){
		$tag = '<h4';
		if($parameters):
			foreach($parameters as $key => $p):
				$tag .= " {$key}=\"{$p}\" ";
			endforeach;
		endif;
		$tag .= '>'.$text.'</h4>';
		echo $tag;
	}
	
	function hr($parameters = null){
		$tag = '<hr';
		if($parameters):
			foreach($parameters as $key => $p):
				$tag .= " {$key}=\"{$p}\" ";
			endforeach;
		endif;
		$tag .= '>';
		echo $tag;
	}
	
	function pre($text, $parameters = null){
		$tag = '<pre';
		if($parameters):
			foreach($parameters as $key => $p):
				$tag .= " {$key}=\"{$p}\" ";
			endforeach;
		endif;
		$tag .= '>'.$text.'</pre>';
		echo $tag;
	}
	
	function _ul($parameters = null){
		$tag = '<ul';
		if($parameters):
			foreach($parameters as $key => $p):
				$tag .= " {$key}=\"{$p}\" ";
			endforeach;
		endif;
		$tag .= '>';
		echo $tag;
	}
	
	function ul_(){
		echo '</ul>';
	}
	
	function _li($parameters = null){
		$tag = '<li';
		if($parameters):
			foreach($parameters as $key => $p):
				$tag .= " {$key}=\"{$p}\" ";
			endforeach;
		endif;
		$tag .= '>';
		echo $tag;
	}
	
	function li_(){
		echo '</li>';
	}
	
	function p($text, $parameters = null){
		$tag = '<p';
		if($parameters):
			foreach($parameters as $key => $p):
				$tag .= " {$key}=\"{$p}\" ";
			endforeach;
		endif;
		$tag .= '> '.$text.'</p>';
		echo $tag;
	}
	
	function th($text, $parameters = null){
		$tag = '<th';
		if($parameters):
			foreach($parameters as $key => $p):
				$tag .= " {$key}=\"{$p}\" ";
			endforeach;
		endif;
		$tag .= '> '.$text.'</th>';
		echo $tag;
	}
	
	function td($text, $parameters = null){
		$tag = '<td';
		if($parameters):
			foreach($parameters as $key => $p):
				$tag .= " {$key}=\"{$p}\" ";
			endforeach;
		endif;
		$tag .= '> '.$text.'</td>';
		echo $tag;
	}
	/*
	 * Metodos para twitter bootstrap
	 */
	
	function _row(){
		echo '<div class="row">';
	}
	
	function row_(){
		echo '</div>';
	}
	
	function _container($fluid = false){
		if($fluid):
			echo '<div class="container-fluid">';
		else:
			echo '<div class="container">';
		endif;
	}
	
	function container_(){
		echo '</div>';
	}
	
	function _col($mdx){
		echo '<div class="col-md-'.$mdx.'">';
	}
	
	function col_(){
		echo '</div>';
	}
	
	/*
	 * Modela os botoes do bootstrap
	 * 
	 */
	function link_button($name, $href, $class="btn btn-default"){
		echo '<a class="'.$class.'" href="'.$href.'" role="button">'.$name.'</a>';
	}
	
	function button($name, $parameters){
		$input = '<button';
		foreach($parameters as $key => $p):
			$input .= " {$key}=\"{$p}\" ";
		endforeach;
		$input .= '>'.$name.'</button>';
		echo $input;
	}
	
	function _button($parameters){
		$input = '<button';
			foreach($parameters as $key => $p):
			$input .= " {$key}=\"{$p}\" ";
		endforeach;
		$input .= '>';
		echo $input;
	}
	
	function button_(){
		echo '</button>';
	}
	
	function input_button($parameters){
		$input = '<input';
			foreach($parameters as $key => $p):
			$input .= " {$key}=\"{$p}\" ";
		endforeach;
		$input .= '>';
		echo $input;
	}
	
	function input_submit($parameters){
		$input = '<input';
			foreach($parameters as $key => $p):
			$input .= " {$key}=\"{$p}\" ";
		endforeach;
		$input .= '>';
		echo $input;
	}
	
	function select($parameters, $options){
		$input = '<select';
		foreach($parameters as $key => $p):
			$input .= " {$key}=\"{$p}\" ";
		endforeach;
		$input .= '>';
		
		foreach($options as $key => $o)
			$input .= "<option value=\"{$o}\"> {$o} </option>";
		
		$input .= "</select>";
		echo $input;
	}
	
	function area($parameters, $content=""){
		if(array_key_exists('ckeditor', $parameters)):
			$input = '<textarea';
		else:
			$input = '<textarea class="ckeditor" ';
		endif;
		foreach($parameters as $key => $p):
			$input .= " {$key}=\"{$p}\" ";
		endforeach;
		$input .= '>';
		$input .= $content.'</textarea>';
		echo $input;
	}
	
	function _table($parameters){
		$input = '<table ';
		foreach($parameters as $key => $p):
			$input .= " {$key}=\"{$p}\" ";
		endforeach;
		$input .= '>';
		echo $input;
	}
	
	function table_(){
		echo '</table>';
	}
}