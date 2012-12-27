<?php
session_start();
require("dbconnect.php");
$whos = $_SESSION['xplo1'];
if ((!isset($_SESSION['xplo1'])) && ($_SESSION['xplo1'] == '')) {
    $conn->close();
    header("location:index.html");
} else {
    $user  = $_GET['user'];
    $table = $conn->prepare("SELECT `nstable` FROM xplomembers WHERE uname=?");
    $table->bind_param("s", $user);
    $table->execute();
    $table->store_result();
    $table->bind_result($usertable);
    while ($table->fetch()) {
        $usertable = $usertable;
    }
    $disptable = $conn->prepare("SELECT `nsense`,`xplotime`,`coname`,`id`,`posttime` FROM `$usertable` ORDER BY id DESC");
    $disptable->execute();
    $disptable->bind_result($non, $time, $userna, $idtable, $time_join);
    $disptable->store_result();
    while ($disptable->fetch()) {
?>
<form id="judge" method="POST" action="judgement.php">

<input type="hidden" value="<?php
        echo ($usertable);
?>" name="tna"/>

<?php
        $dtime = date("d-m", strtotime($time));
        $ttime = date("H:i", strtotime($time . '+10:30 Hour_minute'));
?>
<?php
        if ($userna == $whos) {
            echo ('<div class="media"><img  class="pull-left" style="width: 50px; height: 50px;" alt="http://www.xplorers.host56.com/xplmemb/'.$userna.'/'.$userna.'.gif" src="http://www.xplorers.host56.com/xplmemb/'.$userna.'/'.$userna.'.jpg"/>'.  '<div class="media-body"><h4 class="media-heading"> '. $userna . '<input  class="btn" style="float:right" type="submit"  name="thuuku" value="Thuuki podu"/>'.'
</h4>' .'<p>' . htmlentities($non, ENT_QUOTES) .'<p style="font-size:12px;color:#3B5998;">'.$dtime .'</p>'.'</p></p></div></div>' );
        } else {
            echo ('<div class="media"><img  class="pull-left" style="width: 50px; height: 50px;" alt="http://www.xplorers.host56.com/xplmemb/'.$userna.'/'.$userna.'.gif" src="http://www.xplorers.host56.com/xplmemb/'.$userna.'/'.$userna.'.jpg"/>'.  '<div class="media-body"><h4 class="media-heading"> '. $userna . '
</h4>' . '<p>' . htmlentities($non, ENT_QUOTES) . '<p style="font-size:12px;color:#3B5998;">'.$dtime .'</p>'.'</p></div></div>');
        }
       
        echo ($conn->error);
        if ($conn->query("SELECT `posttime` FROM `userreplies` WHERE `posttime`=$time_join")) {
            
            $querry2 = $conn->prepare("SELECT userreplies.whoo,userreplies.whatt,userreplies.time,userreplies.reply_id FROM userreplies WHERE userreplies.posttime=$time_join");
            echo ($conn->error);
            $querry2->execute();
            $querry2->bind_result($nam, $disp, $tim, $id1);
            $querry2->store_result();
            while ($querry2->fetch()) {
                $dtime2 = date("d-m", strtotime($tim));
                $ttime2 = date("H:i", strtotime($tim . '+10:30 Hour_minute'));
                if ($nam == $whos) {
                    echo ('<li class="media" style=" margin-bottom: 1px;background-color:#EDEFF4;margin-left: 50px;margin-top: 0px;"><img  style="width: 32px; height: 32px; padding-top: 5px; padding-left: 5px; padding-right: 0px; margin-right: 5px;" class="pull-left" style="width: 32px; height: 32px;" alt="http://www.xplorers.host56.com/xplmemb/'.$userna.'/'.$userna.'.gif" src="http://www.xplorers.host56.com/xplmemb/'.$userna.'/'.$userna.'.jpg"/>'.  '<div class="media-body"><h6 class="media-heading"> </h6><p style="font-size:12px;word-wrap:break-word;padding-right: 10px;">'  .'<strong>' .htmlspecialchars($nam) .'</strong>'." ". htmlentities($disp) . '<input type="button" class="btn" style="float:right;"  onclick="javascript:des(' . $idtable . ',' . $id1 . ')" value="erase" /></p><p style="font-size:12px;color:#3B5998;">'.$dtime2 .'</p></div></li>' );
                } else {
                    echo ('<li class="media" style=" margin-bottom: 1px;background-color:#EDEFF4;margin-left: 50px;margin-top: 0px;"><img  style="width: 32px; height: 32px; padding-top: 5px; padding-left: 5px; padding-right: 0px; margin-right: 5px;" class="pull-left" style="width: 32px; height: 32px;" alt="http://www.xplorers.host56.com/xplmemb/'.$userna.'/'.$userna.'.gif" src="http://www.xplorers.host56.com/xplmemb/'.$userna.'/'.$userna.'.jpg"/>'.  '<div class="media-body"><h6 class="media-heading"> </h6><p style="font-size:12px;word-wrap:break-word;padding-right: 10px;">'  .'<strong>' .htmlspecialchars($nam) .'</strong>'." ". htmlentities($disp) . '</p><p style="font-size:12px;color:#3B5998;">'.$dtime2 .'</p></div></li>' );
                }
            }

?>

 <?php
        
        $querry2->free_result();
         }
       
?>

<input type="hidden" value="<?php
        echo ($idtable);
?>" name="valueup" />
<textarea placeholder="Thaaku"  style="resize: none;margin-bottom: 1px; margin-left: 50px; margin-top: 0px; height: 40px; width: 572px;" name="commentss"></textarea>
<input  style="float:right" class="btn" type="submit" value="thaaku" name="submit"/>
<input type="hidden" value=<?php
        echo (strip_tags($user));
?> name="id"/>
</form>
<br>
<hr>
<?php

    }
}
?>
