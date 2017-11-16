<?php


$obj = get_queried_object();
$id = $obj->term_id;

if ( is_numeric($id) ){
    header( "Location: " . home_url() . "/#/category/" . $id );
} else {
    header( "Location: ".home_url() );
}
