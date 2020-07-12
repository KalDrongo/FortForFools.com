<?php
require "includes/db_connection.php";

$sql = "SELECT S.SEC_ID
        FROM POSTS P
        JOIN SECTIONS S ON S.POST_ID = P.POST_ID
        LEFT JOIN SECTIONS_WITH_IMAGES SI ON SI.SEC_ID = S.SEC_ID
        LEFT JOIN IMAGES I ON SI.IMG_ID = I.IMG_ID
        WHERE P.POST_ID = " . $_GET['id'];

$results = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

//Get rid of the sections with images first
foreach($results as $result){
    $sql = "DELETE FROM SECTIONS_WITH_IMAGES WHERE SEC_ID = ".$result["SEC_ID"];
    mysqli_query($conn, $sql);
}
//then get rid of the sections
$sql = "DELETE FROM SECTIONS WHERE POST_ID = ".$_GET['id'];
mysqli_query($conn, $sql);
//then the tagged_posts
$sql = "DELETE FROM TAGGED_POSTS WHERE POST_ID = ".$_GET['id'];
mysqli_query($conn, $sql);
//then finally from the post table itself
$sql = "DELETE FROM POSTS WHERE POST_ID = ".$_GET['id'];
mysqli_query($conn, $sql);

//clean up by deleting images from server that arent on any sections
$sql = "SELECT I.IMG_ID, I.IMG_LOCATION, SI.SEC_ID
        FROM IMAGES I
        LEFT JOIN SECTIONS_WITH_IMAGES SI ON I.IMG_ID = SI.IMG_ID";

$imageRemoveResults = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
//puts all the img_locations into an array that have a sec_ID
$imagesInSections = array();
foreach($imageRemoveResults as $result){
    if($result["SEC_ID"] != NULL){
       array_push($imagesInSections, $result["IMG_LOCATION"]); 
    }
}
//deletes images that dont appear in any sections
foreach($imageRemoveResults as $result){
    if(!in_array($result["IMG_LOCATION"], $imagesInSections)){
        if (file_exists($result["IMG_LOCATION"])) {
            unlink($result["IMG_LOCATION"]);
            echo "File". $result["IMG_LOCATION"] ."Successfully Deleted."; 
        }else{
            echo "File does not exists"; 
        }
    }
}
//removes now unused rows from image table
foreach($imageRemoveResults as $result){
    if($result["SEC_ID"] == NULL){
       $sql = "DELETE FROM IMAGES WHERE IMG_ID = ".$result["IMG_ID"]; 
    }
}
?>