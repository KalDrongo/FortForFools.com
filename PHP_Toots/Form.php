<!-- Here input is taken from the user in the input tag
and put into the $_GET array-->
<html>
<head>
  <title>Form.php</title>
  <meta charset="utf-8">
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
  <script>

$(document).ready(function(){
    var firstSection = $('<input type="text" value="First Section Text" name="section1"><br>');
    var firstImage = $('<input name="image1" type="file" id="file">');
    $("#PostMaker").prepend(firstSection);
    $("#PostMaker").prepend(firstImage);
        

    $("#addSection").on('click',function(){
        addedSection = '<br><input type="text" value="New Section Text" name=section' + sectionNumber + '><br>'
        $("#PostMaker").append(addedSection);
        sectionNumer = sectionNumber + 1;
    });
});
</script>
</head>
<body>
  <!--action describes where it will redirect upon form submission-->
  <form action="Form.php"  method="post" id="PostMaker" enctype='multipart/form-data'>
        <input id="addSection" type="button" value="Add Section" />
    <!-- The value in a checkbox can be any string 
    <input type="checkbox" id="boolean" name="boolean" value="1">
    <label for="boolean">Check if True</label><br> -->
    <button>Send</button>
    <?php var_dump($_POST)?>
  </form>
</body>
</html>
