<?php
if( Params::existParam('minify_enabled') ){
	$enabled = (int)Params::getParam('minify_enabled');
	if( osc_set_preference('minify_enabled', $enabled, 'minify', 'BOOLEAN') ){ 
		die(json_encode(array('status' => true)));
	}
	die(json_encode(array('status' => false, 'message' => 'a error ocurred during update!')));
}
die(json_encode(array('status' => false)));