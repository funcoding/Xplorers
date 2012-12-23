<?php
session_start();
require("dbconnect.php");
$whos = $_SESSION['xplo1'];
if ((!isset($_SESSION['xplo1'])) && ($_SESSION['xplo1'] == '')) {
    $conn->close();
    header("location:index.html");
} else {
    $user  = $_GET['user'];
    $table = $conn->prepare("SELECT `nstable` FROM xplomembers WHERE uname=(?)");
    $table->bind_param("s", $user);
    $table->execute();
    $table->store_result();
    $table->bind_result($usertable);
    while ($table->fetch()) {
    }
    $disptable = $conn->prepare("SELECT `nsense`,`xplotime`,`coname`,`id` FROM `$usertable` ORDER BY id DESC");
    $disptable->execute();
    $disptable->bind_result($non, $time, $userna, $idtable);
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
<div id="co">
<?php
        if ($userna == $whos) {
            echo ('<TABLE   border="0" cellpadding=6 style="background-color:#DBE7F9;" border=1 width=100% >' . '<tr>' . '<td>' . $dtime . '<strong>' . $userna . '
</strong>' . ':' . ' ' . htmlentities($non, ENT_QUOTES) . '<input style="float:right;" type="submit"  name="thuuku" value="Thuuki podu"/>' . '</td>' . '</tr>' . '</table>');
        } else {
            echo ('<TABLE   border="0" cellpadding=6 style="background-color:#DBE7F9;" border=1  width=100%>' . '<tr>' . '<td>' . $dtime . '<strong>' . $userna . '
</strong>' . ':' . ' ' . htmlentities($non) . '</td>' . '</tr>' . '</table>');
        }
        $concate = $idtable . $usertable;
        require('dbcomment.php');
        if ($comm->query("SELECT `whoo`,`whatt`,`time`,`id` FROM `$concate` ORDER BY `id` ASC")) {
            $querry2 = $comm->prepare("SELECT `whoo`,`whatt`,`time`,`id` FROM `$concate` ORDER BY `id` ASC");
            $querry2->execute();
            $querry2->bind_result($nam, $disp, $tim, $idea);
            while ($querry2->fetch()) {
                $dtime2 = date("d-m", strtotime($tim));
                $ttime2 = date("H:i", strtotime($tim . '+10:30 Hour_minute'));
                if ($nam == $whos) {
                    echo ('<TABLE  border="2" cellpadding=1 style="background-color:#DBE7F9; " border=1  width=100% >' . '<tr>' . '<td>' . $dtime2 . ' ' . '<strong>' . htmlspecialchars($nam) . ':' . $disp . '<input type="button" style="float:right;"  onclick="javascript:des(' . $idtable . ',' . $idea . ')" value="erase" />' . '</td>' . '</tr>' . '</table>');
                } else {
                    echo ('<TABLE   border="2" cellpadding=1 style="background-color:#DBE7F9;" border=1 width=100% >' . '<tr>' . '<td>' . $dtime2 . ' ' . '<strong>' . htmlspecialchars($nam) . ':' . $disp . '</td>' . '</tr>' . '</table>');
                }
            }
?>
 </div>
 <?php
        }
?>
</div> 
<input type="hidden" value="<?php
        echo ($idtable);
?>" name="valueup" />
<textarea rows="2" cols="15" name="commentss"></textarea>
<input  type="submit" value="thaaku" name="submit"/>
<input type="hidden" value=<?php
        echo (strip_tags($user));
?> name="id"/>
</form>
<?php
    }
}
?>
