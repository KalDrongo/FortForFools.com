<?php
require "includes/db_connection.php";

$sql = "SELECT P.POST_TITLE, S.SEC_ID, S.SEC_TEXT, 
        I.IMG_ID, I.IMG_LOCATION, SI.IMG_ORDER_NUM
        FROM POSTS P
        JOIN SECTIONS S ON S.POST_ID = P.POST_ID
        LEFT JOIN SECTIONS_WITH_IMAGES SI ON SI.SEC_ID = S.SEC_ID
        LEFT JOIN IMAGES I ON SI.IMG_ID = I.IMG_ID
        WHERE P.POST_ID = " . $_GET['id'] . " 
        ORDER BY S.SEC_ID, SI.IMG_ORDER_NUM";

$results = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
var_dump($results);
//Puts Images into an array on the end of the Sections array
$sections = [];
$previous_SEC_ID = null;

foreach ($results as $row) {

    $SEC_ID = $row['SEC_ID'];

    if ($SEC_ID != $previous_SEC_ID) {

        $firstValue = $row['IMG_LOCATION'];
        
        $row['IMG_LOCATION'] = [];
        
        $sections[$SEC_ID] = $row;

        $sections[$SEC_ID]['IMG_LOCATION'][] = $firstValue;
    }

    $sections[$SEC_ID]['IMG_LOCATION'][] = $row['IMG_LOCATION'];

    $previous_SEC_ID = $SEC_ID;
}

$sql = "SELECT T.TAG_NAME 
        FROM TAGS T
        JOIN TAGGED_POSTS TP ON TP.TAG_ID = T.TAG_ID 
        JOIN POSTS P ON P.POST_ID = TP.POST_ID
        WHERE P.POST_ID = " . $_GET['id'];
        
$tagResults = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

$tags = "";
foreach ($tagResults as $row) {
    $tags = $tags . $row['TAG_NAME'];
}

?>
<html>
<head>
    <title><?= htmlspecialchars($results[0]["POST_TITLE"]) ?></title>
    <link rel="stylesheet" type="text/css" href="includes/FfF_display_post.css">
    <link rel="icon" href="FfF_favicon.ico">
</head>
<body>
    <form id="PostForm" method="post" action="edit_upload_post.php" enctype="multipart/form-data">
    <input name="PostTitle" value="<?= $results[0]["POST_TITLE"] ?>">
    <br>
    <input name="Tags" value="<?= $tags ?>">
    <?php foreach($sections as $section): ?>
        <br>
        <div id="<?= $section["SEC_ID"]; ?>">
        <?php if ($section['IMG_LOCATION']): ?>
            <?php foreach ($section['IMG_LOCATION'] as $img) : ?>
                <?php if (is_string($img)): ?>
                    <input id="<?=var_dump($img) ?>" type="text" readonly value="<?= $img; ?>">
                <?php endif; ?>
            <?php endforeach; ?>
            <br>
            <button id="addImageButton" type="button" onclick="addImage()">Add Image</button>
            <button id="removeImageButton" type="button" onclick="removeImage()">Remove Image</button>
        <?php endif; ?>
        <br>
        <textarea id="Sec<?= $section['SEC_ID']; ?>"><?= $section['SEC_TEXT']; ?></textarea>
        <button id="removeSectionButton" type="button" onclick="removeSection()">Remove Section</button>
        </div>
    <?php endforeach; ?>
    <br>
    <button id="addSectionButton" type="button" onclick="addSection()">Add Section</button>

    </form>
</body>
<script>
"use strict";

</script>
</html>