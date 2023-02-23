<?php

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
                    <a class="btn btn-light" href='./mainpage.php' ;>Homepage</a>
                </div>
                <div class="searchDiv">
                    <!-- add theme switch -->
                    <!-- <button class='theme'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-sun-fill" viewBox="0 0 16 16">
                            <path
                                d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                        </svg></button> -->
                    <form action="./mainpage.php" method="get">
                        <input class="searchField" type="text" name="term">
                        <button type="submit" class='searchButton'><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </form>
                    <a class="btn btn-light" href="./" class="logOut">Log Out</a>
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
            <input name="image" type="file" accept="image/*" onchange='showImage()' style="display:none" id="images">
            <img id='previewImage' />
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
                    if (str_contains(strtolower($currentData['text']), $term) || str_contains(strtolower($currentData['title']), $term)) {
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
            $data = array_values($data);
            function shortText($string)
            {
                $valueArray = preg_split('/(\\r\\n)/', $string, -1, PREG_SPLIT_DELIM_CAPTURE);
                return implode(array_slice($valueArray, 0, 7));
            }
            for ($i = 0; $i < count($data); $i++) {
                $numOfInputs = 0;
                foreach ($data[$i] as $key => $value) {
                    if (count($data[$i]) > 4) {
                        $numOfInputs = count($data[$i]);
                        if ($key == "text") {
                            if (substr_count($value, "\r\n") > 7) {
                                $textValue = $value;
                                $text = shortText($value) . "...";
                            } else {
                                $text = $value;
                                $textValue = $value;
                            }
                            $image = $data[$i]['image'];
                            $title = $data[$i]['title'];
                            $id = $data[$i]['id'];
                        }
                    } else {
                        $title = $data[$i]['title'];
                        $id = $data[$i]['id'];
                        if ($key == 'text') {
                            $userKey = $key;
                            if (substr_count($value, "\r\n") > 7) {
                                $textValue = $value;
                                $text = shortText($value) . "...";
                            } else {
                                $text = $value;
                                $textValue = $value;
                            }
                        } else {
                            $userKey = $key;
                            $image = $value;
                        }
                    }
                }
                if ($numOfInputs > 4) {
                    echo "<div class=\"card posts\" style=\"width: 20rem;\">
                    <div class='imgContainer'>
                        <img src=\"$image\" id='image_$id' value=\"$image\" class=\"card-img-top image\">
                        </div>
                        <div class=\"card-body\">
                            <h5 class=\"card-title\" value=\"$title\" id='title_$id'>$title</h5>
                            <span style='white-space:pre' class=\"card-text\" value=\"$textValue\" id='text_$id'>$text</span>
                            <p class='postDate'id='date_$id'>$dateOfPost</p>
                            <br>
                            <div class='postButtons'>
                            <form action='deletePost.php' method='POST'>
                            <input name='postId' type='hidden' value=\"$id\"</input>
                            <button class=\"btn btn-outline-danger\">Delete post</button>
                            </form>
                            <button data-bs-toggle='modal' data-bs-target=\"#exampleModal\" class='btn btn-outline-secondary' onclick=\"getPostData('$id')\">Edit</button>
                            </div>
                        </div>
                        </div>";
                } else {
                    if ($userKey == "text") { 
                        echo "<div class=\"card posts\" style=\"width: 20rem;\">
                        <div class=\"card-body\"
                            <h5 class=\"card-title\" value=\"$title\" id='title_$id'>$title</h5>
                            <span style='white-space:pre' class=\"card-text\" value=\"$textValue\" id='text_$id'>$text</span>
                            <p class='postDate' id='date_$id'>$dateOfPost</p>
                            <br>
                            <div class='postButtons'>
                            <form action='deletePost.php' method='POST'>
                            <input name='postId' type='hidden' value=\"$id\"</input>
                            <button class=\"btn btn-outline-danger\">Delete post</button>
                            </form>
                            <button data-bs-toggle='modal' data-bs-target=\"#exampleModal\" class='btn btn-outline-secondary' onclick=\"getPostData('$id')\">Edit</button>
                            </div>
                        </div>
                        </div>";
                    } else {
                        echo "<div class=\"card posts\" style=\"width: 20rem;\">
                        <img src=\"$image\" value=\"$textValue\" id='image_$id' class=\"card-img-top image\">
                        <div class=\"card-body\">
                        <h5 class=\"card-title\" value=\"$title\" id='title_$id'>$title</h5>
                            <p class='postDate' id='date_$id'>$dateOfPost</p>
                            <br>
                            <div class='postButtons'>
                            <form action='deletePost.php' method='POST'>
                            <input name='postId' type='hidden' value=\"$id\"</input>
                            <button class=\"btn btn-outline-danger\">Delete post</button>
                            </form>
                            <button data-bs-toggle='modal' data-bs-target=\"#exampleModal\" class='btn btn-outline-secondary' onclick=\"getPostData('$id')\">Edit</button>
                            </div>
                            </div>
                            </div>";
                    }
                }
            }
        }
        ?>
        <!-- MODAL -->
        <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id='modalBody'>
                        ...
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        <?php include "mainpage.css";
        ?>
    </style>
    <script type="text/javascript" src="./mainpage.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>