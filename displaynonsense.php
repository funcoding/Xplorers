<?php
session_start();
require("dbconnect.php");
$whos=$_SESSION['xplo1'];
if((!isset($_SESSION['xplo1'])) && ($_SESSION['xplo1']==''))
{mysql_close($conn);
header("location:index.html");}
else
{$ass = $_GET['user'];
	$ass1=mysql_query("SELECT * FROM xplomembers WHERE uname='$ass'");
while($som=mysql_fetch_array($ass1))
{$fet=$som['nstable'];}

$assdisp=mysql_query("SELECT * FROM `{$fet}` ORDER BY id DESC");
while($assrow=mysql_fetch_array($assdisp))
{?>
<form id="judge" method="POST" action="judgement.php">

<input type="hidden" value="<?php echo($fet);  ?>" name="tna"/>

<?php 

$non=$assrow['nsense'];
$time=$assrow['xplotime'];
$userna=$assrow['coname'];
$dtime=date("d-m",strtotime($time));
$ttime=date("H:i",strtotime($time.'+10:30 Hour_minute'));
$idtable=$assrow['id'];
?>
<div id="co">
<?php
if($userna==$whos)
{
echo('<TABLE   border="0" cellpadding=6 style="background-color:#DBE7F9;" border=1 width=100% >'.'<tr>'.'<td>'.$dtime.'<strong>'.htmlspecialchars($userna).'
</strong>'.':'.' '.$non
.
'<input style="float:right;" type="submit" src="deleteicon.gif" name="thuuku" value="Thuuki podu"/>'.'</td>'.'</tr>'.'</table>');
}
else
{echo('<TABLE   border="0" cellpadding=6 style="background-color:#DBE7F9;" border=1  width=100%>'.'<tr>'.'<td>'.$dtime.'<strong>'.htmlspecialchars($userna).'
</strong>'.':'.' '.$non.'</td>'.'</tr>'.'</table>');}
//starting
$concate=$idtable.$fet;
require('dbcomment.php');
if(mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$concate."'")))
{$querry2=mysql_query("SELECT * FROM `{$concate}` ORDER BY id ASC");
 //if 1
while($roow3=mysql_fetch_array($querry2))
{$nam=$roow3['whoo']; //while3
$disp=$roow3['whatt'];
$tim=$roow3['time'];
$idea=$roow3['id'];
$dtime2=date("d-m",strtotime($tim));
$ttime2=date("H:i",strtotime($tim.'+10:30 Hour_minute'));

if($nam==$whos)
{
echo('<TABLE  border="2" cellpadding=1 style="background-color:#DBE7F9; " border=1  width=100% >'.
'<tr>'.'<td>'.$dtime2.' '.'<strong>'.htmlspecialchars($nam).':'.$disp.
'<input type="button" style="float:right;"  onclick="javascript:des('.$idtable.','.$idea.')" value="erase" />'.
'</td>'.'</tr>'.'</table>');
}
else
{echo('<TABLE   border="2" cellpadding=1 style="background-color:#DBE7F9;" border=1 width=100% >'.'<tr>'.'<td>'.
$dtime2.' '.'<strong>'.htmlspecialchars($nam).':'.$disp.'</td>'.'</tr>'.'</table>');}

}
 ?>
 </div>
 <?php //#while3
mysql_close($conn1);
} //#if 1//#while 2

?>
</div> 
<input type="hidden" value="<?php echo($idtable) ?>" name="valueup" />
<textarea rows="2" cols="15" name="commentss"></textarea>
<input  type="submit" value="thaaku" name="submit"/>
<input type="hidden" value="<?php echo($ass)?>" name="id"/>
</form>
<?php

}mysql_close($conn);}

?>