<?php
include 'getData.php';

$posts=getDB();
$posts=array_filter($posts, function ($currentPost){
    return $currentPost['id']!=$_POST['postId'];
});
$storeNewData = json_encode($posts);
file_put_contents("./postData.json", $storeNewData);
header('location:./mainpage.php')
?>