<?php
require "includes/db_connection.php";
//If there is search data in the url compose modified SQL
if($_GET){
$sql = "SELECT P.*, T.TAG_NAME AS TAG_NAMES
        FROM POSTS P
        LEFT JOIN TAGGED_POSTS TP
        ON P.POST_ID = TP.POST_ID
        LEFT JOIN TAGS T
        ON TP.TAG_ID = T.TAG_ID";
    if($_GET["keywordType"] == "title"){
        $sql = $sql . " WHERE P.POST_TITLE LIKE '%" .$_GET["keyword"]. "%'";
    }
    if($_GET["keywordType"] == "tag"){
        $sql = $sql . " WHERE T.TAG_NAME LIKE '%" .$_GET["keyword"]. "%'";
    }
    if($_GET["orderBy"] == "updatedOn"){
        $sql = $sql . " ORDER BY " . "P.POST_TIME_UPDATED";
    }
    if($_GET["orderBy"] == "title"){
        $sql = $sql . " ORDER BY " . "P.POST_TITLE";
    }
    if($_GET["ascending"] == "on"){
        $sql = $sql . " ASC";
    }else{
        $sql = $sql . " DESC";
    }
}else{
//Gets the post data and their tags
$sql = "SELECT P.*, T.TAG_NAME AS TAG_NAMES
        FROM POSTS P
        LEFT JOIN TAGGED_POSTS TP
        ON P.POST_ID = TP.POST_ID
        LEFT JOIN TAGS T
        ON TP.TAG_ID = T.TAG_ID
        ORDER BY P.POST_TIME_UPDATED DESC";
}
$results = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

//Puts Tags into an array on the end of the posts array

$posts = [];
$previous_POST_ID = null;

foreach ($results as $row) {
    
    $POST_ID = $row['POST_ID'];
    
    if ($POST_ID != $previous_POST_ID) {
        
        $firstValue = $row['TAG_NAMES'];
        
        $row['TAG_NAMES'] = [];

        $posts[$POST_ID] = $row;
        
        $posts[$POST_ID]['TAG_NAMES'][] = $firstValue;
    }

    $posts[$POST_ID]['TAG_NAMES'][] = $row['TAG_NAMES'];

    $previous_POST_ID = $POST_ID;
}
?>
<html>
<head>
    <title>Fort for Fools</title>
    <link rel="stylesheet" type="text/css" href="includes/FfF_index.css">
    <link rel="icon" href="FfF_favicon.ico">
</head>
<body>
    <h1>Fort for Fools</h1>
    <p>Welcome to this humble website. Its meager purpose is to archive information
    useful, relevant, or interesting to information technology in all its forms.
    Feel free to peruse at your leisure.</p>
     <button type="button" class="collapsible">Search</button>
        <div class="content">
            <form method="get" id="searchForm" action="index.php">
             <table class="search">
              <tr class="search">   
                <td class="search">By Keyword</td>
                <td class="search">Order By</td>
              </tr>
              <tr class="search">
                <td><input type="radio" id="keywordTitle" name="keywordType" value="title">
                <label for="keywordTitle">in a Title</label></td>
                <td><input type="radio" id="orderByUpdated" name="orderBy" value="updatedOn"  checked="checked">
                <label for="orderByUpdated">Updated On</label></td>
              </tr>
              <tr class="search">
                <td><input type="radio" id="keywordTag" name="keywordType" value="tag">
                <label for="keywordTag">in a Tag</label></td>
                <td><input type="radio" id="orderByTitle" name="orderBy" value="title">
                <label for="orderByTitle">Title</label></td>
              </tr>
              <tr class="search">
                <td><input type="text" name="keyword"></td>
                <td><input type="checkbox" name="ascending" value="on"><label for="ascending">Ascending</label></td>
              </tr>
              <tr class="search">
                <td><input type=submit></td>
              </tr>
              </table>
            </form>
        </div>
    <table class="posts">
      <tr class="posts">   
        <th class="posts">Title</th>
        <th class="posts">Last Updated On</th>
        <th class="posts">Tags</th>
      </tr>
      <?php foreach($posts as $post): ?>
      <tr class="posts">
        <td class="posts"><a href="display_post.php?id=<?= $post['POST_ID']; ?>"><?= htmlspecialchars($post['POST_TITLE']); ?></a></td>
        <td class="posts"><time datetime="<?= $post['POST_TIME_UPDATED'] ?>"><?php
                        $datetime = new DateTime($post['POST_TIME_UPDATED']);
                        echo $datetime->format("j F, Y");
                    ?></time></td>
        <td class="posts">
        <?php if ($post['TAG_NAMES']) : ?>    
            <?php foreach ($post['TAG_NAMES'] as $name) : ?>
                <?= htmlspecialchars($name); ?>
            <?php endforeach; ?>
        <?php else: echo "No Tags"; ?>
        <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
</body>
<script src="includes/index.js"></script>
</html>