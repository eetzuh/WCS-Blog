<?php
include "./getData.php";
function storeToDB()
{    
    $currentJson = getDB();
    if ($currentJson == null) {
        $currentJson = [];
    }
    ;
    $userData = [];
    $userData['id']=uniqid();
    $userData['title']=$_POST['title'];
    $userData['date']=date('d/m/y');
    if (($_FILES['image']['name'] !== "")) {
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageTmp = $image['tmp_name'];
        //add image size limit
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
    array_unshift($currentJson, $userData);
    $storeData = json_encode($currentJson);
    file_put_contents("./postData.json", $storeData);
}
;
if (($_FILES['image']['name'] !== "") || $_POST['text'] !== "") {
    storeToDB();
}
header("location:./mainpage.php");

?>