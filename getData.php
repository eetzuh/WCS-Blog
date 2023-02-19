<?php
    function getDB(){
        $json= file_get_contents("./postData.json");
        return json_decode($json, true);
    }
?>