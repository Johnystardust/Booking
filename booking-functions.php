<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 11/25/2016
 * Time: 9:07 PM
 */

function tvds_find_terms($terms, $field, $value){
    foreach($terms as $key => $term){
        if($term[$field] === $value){
            return $key;
        }
    }
    return false;
}