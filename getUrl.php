<?php
/**
 * Created by PhpStorm.
 * User: arsha
 * Date: 9/30/2016
 * Time: 1:22 AM
 */
header( 'Content-type: text/html; charset=utf-8' );

$url = 'URL';

$result = callUrl($url);
ob_start();
foreach($result[0][0] as $mainCat){
    $url = $url . '?category_id=' . $mainCat['id'];
    callUrl($url);
    echo $url . '?category_id=' . $mainCat['id'] . ' - DONE <br />';
    flush_buffers();
    getChild($mainCat);
}

function getChild($mainCat){
    if(isset($mainCat['children'])){
        foreach($mainCat['children'] as $childCat){
            $url = $url . '?category_id=' . $childCat['id'];
            callUrl($url);
            echo $url . '?category_id=' . $childCat['id'] . ' - DONE <br />';
            flush_buffers();
            getChild($childCat);
        }
    }
}

function callUrl($url){
    $ch = curl_init($url);
    $fields = array();
    $data_string = json_encode($fields);
    curl_setopt($ch, CURLOPT_POST, false); // true for post
    curl_setopt($ch, CURLOPT_HTTPGET, true); // For get
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); // Use if post then for posting body
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        )
    );
    $responses = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $result=json_decode($responses,true);
    return $result;
}

function flush_buffers(){
    ob_end_flush();
    ob_flush();
    flush();
    ob_start();
}