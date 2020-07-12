<?php
//Declare variables you'll use in the webpage up here
$Title = "HTML & PHP";
$number = 3;
?>
<html>
    <head>
        <title><?php echo $Title; ?></title>
        <meta charset="utf-8">
    </head>
    <body>
        <!--Control Structures and HTML 
        Notice how the if statements have :
        and the if statement must be ended with elseif;-->
        
        <?php if($number == 1): ?>
        The number is 1
        <?php elseif($number == 2): ?>
        The number is 2
        <?php elseif($number == 3): ?>
        The number is 3
        <?php endif; ?>
    </body>
</html>