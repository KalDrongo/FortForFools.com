<?php
//There are multiple ways to declare arrays
$Toot_Array = ["First","Second","Third"];
$ArrayWithFunction = array("First","Second","Third");

var_dump($Toot_Array);

//The seperate values of the arrays can then be called like this
var_dump($Toot_Array[0]); //This will print out the first element

//You can even make associative arrays with string indexes
//This happens with php input from forms
$Associative_Array = [
    "99" => 99,
    "Hello" => "Howdy",    
    "MyBoi" => $Toot_Array
    ];

//The last one is a multidimensional array, as it is an array within an array
//These can be very useful for representing data in tables, like within databases

$USERS = [
    [ "USER_ID" => 0,
      "USER_NAME" => "BigBoi",
      "USER_PASS" => "ZIPZAP"],
      
    [ "USER_ID" => 1,
      "USER_NAME" => "SmolBoi",
      "USER_PASS" => "zoom"],
      
    [ "USER_ID" => 2,
      "USER_NAME" => "DatBoi",
      "USER_PASS" => "hellyeah"]
      ];
      
//To get the first users name you would access it like so
var_dump($USERS[0]["USER_NAME"]);

//To iterate through each element in an array you can use a foreach loop
foreach ($USERS as $USER) {
    foreach ($USER as $data){
        echo $data. ", ";
    }
}

//You can also make a foreach loop that uses the index an another variable
foreach($USERS as $OuterIndex => $user){
    echo $OuterIndex . " = [";
    foreach($user as $InnerIndex => $data){
        echo $InnerIndex . " = " . $data . ', ';
    }
    echo "]";
}

?>