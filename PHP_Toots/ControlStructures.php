<?php
//The simplest of control structures is the if statement

$posts = [];

if (empty($posts)) {
    echo "The array is empty";
}

//an else can be added onto this to run something if it is false

if (empty($posts)) {
    echo "The array is empty";
} else {
    echo "The array is NOT empty";
}

//can use else if for more than another condition to check
if (empty($posts)) {
    echo "The array is empty";
}elseif (1>2){
    echo "Nope";
}else {
    echo "The array is NOT empty";
}

//This can be a switch statement if you have many different values to compare to
switch($i){
    case 0:
        echo "This will happen if $i = 0";
    case 1:
        echo "This will happen if $i = 1";
    case 2:
        echo "This will happen if $i = 2";
    default:
        echo "This will run if no casesmatch";
}

//Values can be compared in all kinds of ways
//Check if something is equal ==
//If it is not equal !=
//If it is less or more < , > , <= , >=

//While loops will run until they are not true
$counter = 10;
while ($counter > 0){
    echo $counter;
    $counter--;
}

//For loops will run a specific number of times
for($i = 1;$i <= 10;$i++){
    echo "The value of counter is $i";
}
//-- & ++ can be put before or after the value depending on if
//you want the value to change before or after it is returned
?>