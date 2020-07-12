<?php
require "includes/db_connection.php";

$sql = "SELECT P.POST_TITLE, S.SEC_ID, S.SEC_TEXT, I.IMG_ID, I.IMG_LOCATION, SI.IMG_ORDER_NUM
        FROM POSTS P
        JOIN SECTIONS S ON S.POST_ID = P.POST_ID
        LEFT JOIN SECTIONS_WITH_IMAGES SI ON SI.SEC_ID = S.SEC_ID
        LEFT JOIN IMAGES I ON SI.IMG_ID = I.IMG_ID
        WHERE P.POST_ID = " . $_GET['id'] . " 
        ORDER BY S.SEC_ID, SI.IMG_ORDER_NUM";

$results = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

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

?>
<html>
<head>
    <title><?= htmlspecialchars($results[0]["POST_TITLE"]) ?></title>
    <link rel="stylesheet" type="text/css" href="includes/FfF_display_post.css">
    <link rel="icon" href="FfF_favicon.ico">
</head>
<body>
    <h1><?= htmlspecialchars($results[0]["POST_TITLE"]) ?></h1>
    <?php foreach($sections as $section): ?>
        <?php if ($section['IMG_LOCATION']): ?>
            <?php foreach ($section['IMG_LOCATION'] as $img) : ?>
                <?php if (is_string($img)): ?>
                    <img src=<?= htmlspecialchars($img); ?>></img>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <p><?= htmlspecialchars($section['SEC_TEXT']); ?></p>

    <?php endforeach; ?>
</body>
</html>