<?php

include 'getData.php';

function storeEditedData(){
 $title=$_POST['title'];
 if(isset($_POST['text'])){
    $text=$_POST['text'];
 }
 if(isset($_POST['image'])){
    $image=$_POST['image'];
 }
};
header('location:./mainpage.php')
?>