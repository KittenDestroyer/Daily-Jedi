<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Form Fields</title>
<script type="text/javascript">
    function changeBg(){
        var userName = document.forms[0].userName.value;
        var bgColor = document.colorForm.color.value;
 
        document.bgColor = bgColor;
        alert(userName + ", the background color is " + bgColor + ".");
    }
</script>
</head>
<body>
<h1>Change Background Color</h1>
<form name="colorForm">
    Your Name: <input type="text" name="userName"><br>
    Background Color: <input type="text" name="color"><br>
    <input type="button" value="Change Background" onclick="changeBg();">
</form>
</body>
</html>