<?php
include "getData.php";
function storeToDB()
{    
    $currentJson = getDB();
    if ($currentJson == null) {
        $currentJson = [];
    }
    ;
    $userData = [];
    $userData['id']=uniqid();
    if(isset($_POST['title'])){
        $userData['title']=$_POST['title'];
    }
    if (($_FILES['image']['name'] !== "")) {
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageTmp = $image['tmp_name'];
        $imageSize = $image['size'];
        $imageError = $image['error'];
        $imageType = $image['type'];
        $imageExtensionExploded = explode('.', $imageName);
        $imageExtension = strtolower(end($imageExtensionExploded));
        $imageNameNew = uniqid('', true) . "." . $imageExtension;
        $imageDestination = 'Images/' . $imageNameNew;
        move_uploaded_file($imageTmp, $imageDestination);
        $userData['image'] = $imageDestination;
    }
    ;

    if (isset($_POST['text'])) {
        $userData['text'] = $_POST['text'];
    }
    ;
    $currentJson[] = $userData;
    $storeData = json_encode($currentJson);
    file_put_contents("./postData.json", $storeData);
}
;
if (($_FILES['image']['name'] !== "") || $_POST['text'] !== "") {
    storeToDB();
}
header("location:/Blog/mainpage.php");

?>