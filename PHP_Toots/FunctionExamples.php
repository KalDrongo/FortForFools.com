<!-- Here input is taken from the user in the input tag
and put into the $_GET array-->
<html>
<head>
  <title>FunctionExamples.php</title>
  <meta charset="utf-8">
</head>
<body>
  <form action="FunctionExamples.php">
    <input name="search">
    <input type="checkbox" id="boolean" name="boolean" value=1>
     <label for="boolean">Check if True</label><br>
    <button>Send</button>
    <?php var_dump($_GET)?>
  </form>

<?php
/*This is a PHP Doc Comment
* These can be used to better understand whats happening in functions
* Usually you'd write a description of what the function would do here
* Then put in what its input variables and what it returns
* 
* @param string name contains a name
* 
* @return echoes out the name
*/
function showMessage($name){
    echo "Hello " . $name;
}
showMessage($_GET[search]);

/*This function shows how return is used
* 
* @param boolean boolean is true if checked in form, false if not
* 
* @return string that declares value of the boolean
*/
function returnMessage($boolean){
    if ($boolean){
        return "It's True!";
    }
    else{
        return "It's False!";
    }
}
echo returnMessage($_GET[boolean]);
?>

</body>
</html>
