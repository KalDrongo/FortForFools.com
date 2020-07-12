<?php
require "includes/db_connection.php";
if(!empty($_FILES)){
$fileLocations = array();
$fileExists = array();
foreach ($_FILES as $FileID => $file){
    //specifies the directory where the file is going to be placed
    $target_dir = "uploads/";
    //specifies the path of the file to be uploaded
    $target_file = $target_dir . basename($file["name"]);
    //replaces spaces with underscores so the images load properly
    $target_file = str_replace(" ","_",$target_file);
    //will be used to keep track if a file is okay to upload
    $uploadOk = 1;
    //holds the file extension of the file
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is an actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($file["tmp_name"]);
        if($check !== false) {
            //echo $FileID . "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo '<pre>' ,"File is not an image.", '</pre>';
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo '<pre>' ,"File ".$target_file." already exists but it'll be added to the post.", '</pre>';
        $uploadOk = 0;
        $fileLocations[$FileID] = $target_file;
    }
    // Check file size
    if ($file["size"] > 500000) {
        echo '<pre>' ,"Sorry, your file is too large.", '</pre>';
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo '<pre>' ,"Sorry, only JPG, JPEG, PNG & GIF files are allowed.", '</pre>';
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo '<pre>' ,"Sorry, your file was not uploaded.", '</pre>';
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            echo '<pre>' ,"The file ". basename( $file["name"]). " has been uploaded.", '</pre>';
            $fileLocations[$FileID] = $target_file;
            //Add image to IMAGES
            $sql = "SELECT max(IMG_ID) FROM IMAGES";
            $result = mysqli_fetch_all(mysqli_query($conn, $sql));
            $ImgID = ++$result[0][0];
            $ImgSql = "INSERT INTO `IMAGES` (`IMG_ID`, `IMG_LOCATION`)
                       VALUES (".$ImgID.",'".$target_file."')";
            if (mysqli_query($conn, $ImgSql)) {
                echo '<pre>' ,"New IMAGE record for ".$target_file." created successfully", '</pre>';
            } else {
                echo '<pre>' ,"IMAGE record for".$target_file." WASNT INSERTED: " . $sql . "<br>" . mysqli_error($conn), '</pre>';
            }
            
        } else {
            echo '<pre>' ,"Sorry, there was an error uploading your file.", '</pre>';
        }
    }
}
}
//First will need to make a new post with its associated values
//Get the last ID of the post and increment it by 1 for the new post
$sql = "SELECT max(POST_ID) FROM POSTS";
$result = mysqli_fetch_all(mysqli_query($conn, $sql));
$PostID = ++$result[0][0];
//Insert the post into the POSTS table
$sql = "
INSERT INTO `POSTS` (`POST_ID`, `POST_TITLE`, `POST_TIME_UPDATED`) 
VALUES (" . $PostID . ",'" . $_POST["PostTitle"] . "', now())";

if (mysqli_query($conn, $sql)) {
    echo '<pre>' ,"New POSTS record created successfully", '</pre>';
} else {
    echo '<pre>' ,"POSTS PART WASNT INSERTED: " . $sql . "<br>" . mysqli_error($conn), '</pre>';
}

//Get the last section ID
$sql = "SELECT max(SEC_ID) FROM SECTIONS";
$result = mysqli_fetch_all(mysqli_query($conn, $sql));
$SecID = ++$result[0][0];
$numberOfSections = 0;

//Conscructs the sql for the SECTIONS insert
$sql = "INSERT INTO `SECTIONS` (`SEC_ID`, `POST_ID`, `SEC_TEXT`) VALUES ";
foreach ($_POST as $section=>$secText){
    if(is_numeric($section[7])){
        $secText = mysqli_real_escape_string($conn, $secText);
        $sql = $sql . "(".$PostID.",".$SecID.",'".$secText."'),";
        $SecID++;
        $numberOfSections++;
    }
}
unset($section);
$sql = rtrim($sql,",");

//Insert the sections into the SECTIONS table
if (mysqli_query($conn, $sql)) {
    echo '<pre>' ,"New SECTIONS record created successfully", '</pre>';
} else {
    echo '<pre>' ,"SECTIONS PART WASNT INSERTED: " . $sql . "<br>" . mysqli_error($conn), '</pre>';
}
//Inserting Images and join table information, wont run if there's no images
if(!empty($_FILES)){
//Constructs sql for the SECTIONS_WITH_IMAGES insert
$SecWithImgSql = "INSERT INTO `SECTIONS_WITH_IMAGES` (`SEC_ID`, `IMG_ID`, `IMG_ORDER_NUM`) VALUES ";
$SecID = $SecID - $numberOfSections;
foreach ($fileLocations as $section => $location){
    $TempSecID = $SecID + $section[7];
    $OrderNum = substr($section, -1);
    $GetImgIdSql = "SELECT IMG_ID FROM IMAGES WHERE IMG_LOCATION = " . "'".$location."'";
    $results = mysqli_fetch_all(mysqli_query($conn, $GetImgIdSql), MYSQLI_ASSOC);
    if (!mysqli_query($conn, $GetImgIdSql)) {
        echo '<pre>' ,"sql to get img_id: " . $GetImgIdSql . "<br>" . mysqli_error($conn), '</pre>';
    }
    $SecWithImgSql = $SecWithImgSql . "(".$TempSecID.",".$results[0]["IMG_ID"].",".$OrderNum."),";
}
$SecWithImgSql = rtrim($SecWithImgSql,",");

if (mysqli_query($conn, $SecWithImgSql)) {
    echo '<pre>' ,"New SECTIONS_WITH_IMAGES record created successfully", '</pre>';
} else {
    echo '<pre>' ,"SECTIONS_WITH_IMAGES PART WASNT INSERTED: " . $SecWithImgSql . "<br>" . mysqli_error($conn), '</pre>';
}
}

//Inserting tag section, will only run if theres stuff in the tag input
if(!empty($_POST["Tags"])){
$TagSql = "SELECT * FROM TAGS";
$TagSqlResult = mysqli_fetch_all(mysqli_query($conn, $TagSql));
$TagArray = explode(',', $_POST["Tags"]);

//Processes tag input, capitalizing and removing whitespace
foreach ($TagArray as $key => $Tag){
    $TagArray[$key] = trim(strtoupper($Tag));
}

$ExistingTags = array();
$NewTags = array();
foreach ($TagSqlResult as $key => $result){
    if(in_array($result[1],$TagArray)){
        $ExistingTags[$result[0]] = $result[1];
    }
}
$count = 0;
foreach($ExistingTags as $key => $result){
    if(in_array($result,$TagArray)){
        unset($TagArray[$count]);
    }
    $count++;
}

if(!empty($TagArray)){
    $InsertNewTagsSql = "INSERT INTO `TAGS` (`TAG_ID`, `TAG_NAME`) VALUES ";
    $sql = "SELECT max(TAG_ID) FROM TAGS";
    $result = mysqli_fetch_all(mysqli_query($conn, $sql));
    $TagID = ++$result[0][0];
    foreach($TagArray as $key => $result){
        $InsertNewTagsSql = $InsertNewTagsSql . "('".$TagID."','".$result."'),";
        $ExistingTags[$TagID] = $result;
        $TagID++;
    }
    $InsertNewTagsSql = rtrim($InsertNewTagsSql,",");
    if (mysqli_query($conn, $InsertNewTagsSql)) {
        echo '<pre>' ,"New TAGS insert created successfully", '</pre>';
    } else {
        echo '<pre>' ,"TAGS PART WASNT INSERTED: " . $InsertNewTagsSql . "<br>" . mysqli_error($conn), '</pre>';
    }
}
$TagSql = "INSERT INTO `TAGGED_POSTS` (`POST_ID`, `TAG_ID`) VALUES ";
foreach($ExistingTags as $id => $result){
    $TagSql = $TagSql . "('".$PostID."','".$id."'),";
}
$TagSql = rtrim($TagSql,",");
if (mysqli_query($conn, $TagSql)) {
    echo '<pre>' ,"New TAGGED_POSTS inserted created successfully", '</pre>';
} else {
    echo '<pre>' ,"TAGGED_POSTS PART WASNT INSERTED: " . $InsertNewTagsSql . "<br>" . mysqli_error($conn), '</pre>';
}
}
mysqli_close($conn);
?>
<html>
<head>
<title>Upload Post Info</title>
<link rel="icon" href="FfF_favicon.ico">
</head>
</html>