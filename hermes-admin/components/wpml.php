<?php
/*----------------------------------------------------------------------------------*/
/*  Hermes: WPML Support	
/*  Author: http://www.hermesthemes.com
/*----------------------------------------------------------------------------------*/

function hermes_wpml_pageid($id){
	if(function_exists('icl_object_id')) {
		$type = get_post_type($id);
		return icl_object_id($id,$type,true);
	} else {
		return $id;
	}
}

function hermes_wpml_categoryid($id){
	if(function_exists('icl_object_id')) {
		return icl_object_id($id,'category',true);
	} else {
		return $id;
	}
}