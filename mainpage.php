<?php
session_start();
include "./getData.php"
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./mainpage.css">
    <title>Blog</title>
</head>

<body>
    <header class='sticky-top'>
        <div class='menuContainer'>
            <hr class="hrTop">
            <div class="menu">
                <div class="homepage">
                    <a class="homepageButton btn btn-light" href='/Blog/mainpage.php' ;>Homepage</a>
                </div>
                <div class="searchDiv">
                    <form action="./mainpage.php" method="get">
                        <input class="searchField" type="text" name="term">
                        <button type="submit" class='searchButton'><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </form>
                    <a class="btn btn-light" href="/Blog" class="logOut">Log Out</a>
                </div>
            </div>
            <hr class="hrBottom">
        </div>
    </header>
    <div class="newPostButtonDiv">
        <button class="newPostButton btn btn-outline-secondary" onclick="newPostDivToggle()">New Post</button>
    </div>
    <div class="newPostDiv">
        <button class="closeNewPostDiv btn btn-outline-danger" onclick="closeDiv()">X </button>
        <form action="./storeData.php" class="formDiv" method="POST" enctype="multipart/form-data">
            <div class='titleDiv'>
                <label for='title' class="form-label" style="font-size:20px"> Title</label>
                <input type="text" class='form-control' name="title" id='title' required>
            </div>
            <textarea class='form-control' name="text" id="text" cols="30" rows="10" placeholder="Add description"
                onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}"></textarea>
            <label for="images" class="uploadImage btn btn-outline-secondary">Add Image</label>
            <input name="image" type="file" accept="image/*" style="visibility:hidden; display:none" id="images">
            <button type="submit" class="submitButton btn btn-outline-success">Post</button>
        </form>
    </div>
    <div class="postsContainer">
        <?php
        $data = getDB();
        $dateOfPost = date('d/m/y');
        if (key_exists('term', $_GET)) {
            if ($data != null) {
                $term = strtolower($_GET['term']);
                $data = array_filter($data, function ($currentData) use ($term) {
                    if (str_contains(strtolower($currentData['text']), $term)) {
                        return $currentData;
                    }
                });
            }
            if ($data == []) {
                echo "<div class='noPostsFound'>No posts found</div>";
            }
        }
        ;
        if ($data != null) {
            //array filtering puts gaps in array indexes, array values is needed to reset indexes in numerical order so that loop doesn't break
            $data = array_values($data);
            for ($i = 0; $i < count($data); $i++) {
                $numOfInputs = 0;
                foreach ($data[$i] as $key => $value) {
                    if (count($data[$i]) > 3) {
                        $numOfInputs = count($data[$i]);
                        if ($key == "text") {
                            // if(substr_count($value,"\r\n")>7){
                            //     function shortText($string){
                            //         $valueArray=preg_split("/^\\r\\n$/", $string, 0, PREG_SPLIT_DELIM_CAPTURE);
                            //         return $valueArray;
                            //     }
                            //     $text=var_dump(shortText($value));
                            // }else{
        
                            $text = $value;
                        } else if ($key == "image") {
                            $image = $value;
                        } else if ($key == "title") {
                            $title = $value;
                        } else {
                            $id = $value;
                        }
                    } else {
                        if ($key == 'title') {
                            $title = $value;
                        }
                        if ($key == 'id') {
                            $id = $value;
                        }
                        if ($key == 'text') {
                            $userKey = $key;
                            $text = $value;
                        } else {
                            $userKey = $key;
                            $image = $value;
                        }
                    }
                }
                if ($numOfInputs > 2) {
                    echo "<div class=\"card posts\" style=\"width: 20rem;\">
                    <div class='imgContainer'>
                        <img src=\"$image\" class=\"card-img-top image\">
                        </div>
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">$title</h5>
                            <span style='white-space:pre' class=\"card-text\">$text</span>
                            <p class='postDate'>$dateOfPost</p>
                            <br>
                            <div class='postButtons'>
                            <form action='deletePost.php' method='POST'>
                            <input name='postId' type='hidden' value=\"$id\"</input>
                            <button class=\"btn btn-outline-danger\">Delete post</button>
                            </form>
                            <button class='btn btn-outline-secondary'>Edit</button>
                            </div>
                        </div>
                        </div>";
                } else {
                    if ($userKey == "text") {
                        echo "<div class=\"card posts\" style=\"width: 20rem;\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">$title</h5>
                            <span style='white-space:pre' class=\"card-text\">$text</span>
                            <p class='postDate'>$dateOfPost</p>
                            <br>
                            <div class='postButtons'>
                            <form action='deletePost.php' method='POST'>
                            <input name='postId' type='hidden' value=\"$id\"</input>
                            <button class=\"btn btn-outline-danger\">Delete post</button>
                            </form>
                            <button class='btn btn-outline-secondary'>Edit</button>
                            </div>
                        </div>
                        </div>";
                    } else {
                        echo "<div class=\"card posts\" style=\"width: 20rem;\">
                        <img src=\"$image\" class=\"card-img-top image\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">$title</h5>
                            <p class='postDate'>$dateOfPost</p>
                            <br>
                            <div class='postButtons'>
                            <form action='deletePost.php' method='POST'>
                            <input name='postId' type='hidden' value=\"$id\"</input>
                            <button class=\"btn btn-outline-danger\">Delete post</button>
                            </form>
                            <button class='btn btn-outline-secondary'>Edit</button>
                            </div>
                        </div>
                        </div>";
                    }
                }
            }
        }
        ?>
    </div>
    <style>
        <?php include "mainpage.css";
        ?>
    </style>
    <script type="text/javascript" src="mainpage.js"></script>
</body>

</html>