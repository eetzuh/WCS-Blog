<?php

include './getData.php';

function storeEditedData()
{
   $oldData = getDB();
   foreach($oldData as $key => $value ){
      if($value==""){
         unset($oldData[$key]);
      }
   }
   $title = $_POST['title'];
   $id = $_POST['postId'];
   if (isset($_POST['text'])) {
      $text = $_POST['text'];
   }
   if ($_FILES['image']['name'] !== "") {
      $image = $_FILES['image'];
      $imageName = $image['name'];
      $imageTmp = $image['tmp_name'];
      $imageExtensionExploded = explode('.', $imageName);
      $imageExtension = strtolower(end($imageExtensionExploded));
      $imageNameNew = uniqid('', true) . "." . $imageExtension;
      $imageDestination = 'Images/' . $imageNameNew;
      move_uploaded_file($imageTmp, $imageDestination);
      var_dump("name value");
   }
   $editedPost=[];
   $postIndex=0;
   foreach ($oldData as &$selectedPost) {
      $postIndex++;
      if ($selectedPost['id'] == $id) {
         if(($_POST['title']==$selectedPost['title'])&& ($_POST['text']==$selectedPost['text'])&& $_FILES['image']['name']==""){
            header('location:./mainpage.php');
            return;
         }
         $selectedPost['id'] = $id;
         $selectedPost['text'] = $text;
         $selectedPost['title'] = $title;
         if ($_FILES['image']['name'] !== "") {
            $selectedPost['image'] = $imageDestination;
         } else {
            if ($_POST['previousImage'] !== "null") {
               $selectedPost['image'] = $_POST['previousImage'];
            }else{
               unlink($selectedPost['image']);
               unset($selectedPost['image']);
            }
         }
         $selectedPost['date'] = date('d/m/y');
         $editedPost=$selectedPost;
         break;
      }
   }
   array_unshift($oldData, $editedPost);
   array_splice($oldData, $postIndex, 1);
   $storeNewData = json_encode($oldData);
   file_put_contents("./postData.json", $storeNewData);
}
;
storeEditedData();
header('location:./mainpage.php')
?>