<?php
include './getData.php';

$posts=getDB();
foreach($posts as $post){
    if($_POST['postId']==$post['id']){
        unlink($post['image']);
    }
}
$posts=array_filter($posts, function ($currentPost){
    return $currentPost['id']!=$_POST['postId'];
});
$storeNewData = json_encode(array_values($posts));
file_put_contents("./postData.json", $storeNewData);
header('location:./mainpage.php')

?>