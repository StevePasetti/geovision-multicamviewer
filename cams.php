<?php
 if (isset($_POST["ip"]))
 {
 $ch = curl_init(); 

 $url = 'http://' . $_POST["ip"] . '/phoneinfo';
 $fields = array(
    'id' => $_POST["username"],
    'pwd' => $_POST["password"],
    'ImageType' => '1'
 );
 foreach ($fields as $key=>$value) { $fields_string .= $key .'='.$value.'&'; }

 rtrim($fields_string, '&');

 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_POST, count($fields));
 curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 $result = curl_exec($ch);
 $err = "";
 if (substr_count($result, "IDKey") === 0)
 {
   $err = "Unable to get login GUID.  Camera system may not be supported.";
 }
 if (substr_count($result, "Access denied") > 0)
 {
   $err = "Camera system denied access. Check your username and password.";
 }

 $matches = array();
 preg_match('/IDKey=([^&]+)/',$result,$matches);
 $guid = $matches[1];

//cam indexes
 $camindexmatches = array();
 preg_match_all('/CamIndex=(\d+)/',$result,$camindexmatches);
 
 curl_close($ch);
 }
?>

<!doctype html>
<html>
<head>
</head>
<body>
<form method="post">
<table>
<tr>
<td>Camera IP:</td>
<td><input type="text" id="ip" name="ip" value="<?php echo $_POST["ip"]?>"></input></td>
</tr>
<tr>
<td>Username:</td>
<td><input type="text" id="username" name="username" value="<?php echo $_POST["username"]?>"></input></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="password" id="password" name="password"></input></td>
</tr>
<tr>
<td colspan=2><input type="submit" value="Log in!"></td>
</tr>
</table>
</form>
<?php
if ($err!="")
{
  print("<span style=\"color:red\">" . $err . "</span>");
} 
if (isset($_POST["ip"]) && $err==="")
{ 
foreach ($camindexmatches[1] as $val)
  print("<button id=\"btn" . $val . "\" type=\"button\" onclick=\"toggleCam(" . $val . ")\">Camera " . ($val+1) . "</button> ");

?><br/><br/>
<?php
foreach ($camindexmatches[1] as $val)
  print("<img id=\"cam" . $val . "\" src=\"\" style=\"display:none\"/>");
?>
<br/>
<br/>
<br/>
<script type="text/javascript">
var timers = {};

function iframeload(loc)
{
  alert("Location: " + loc);
}
function toggleCam(camNumber)
{
  var cam = document.getElementById("cam" + camNumber);
  if (cam.style.display === "none")
  {
     cam.style.display="inline";
     timers["cam" + camNumber.toString()] = setInterval(function(){
       var randomNo = getRandomNumber().toString();
       var guid = "<?php echo $guid;?>";
       var ip = "<?php echo $_POST["ip"];?>";
       cam.src = "http://" + ip + "/" + guid + "_" + randomNo + "/cam" + camNumber + ".jpg";
     }, 500);
  }
  else
  {
     cam.style.display="none";
     clearInterval(timers["cam" + camNumber.toString()]);
  }
}

function getRandomNumber() { return Math.floor(Math.random()*9000000) + 1000000; }

</script>
<?php } ?>
</body>

</html>
