<?php //This file is subject to copyright - contact swampservers@gmail.com for more information. ?>
<?=Page("Staff", "/s/screenshots/chinese.jpg")?>

<?php
$staff = SQL_Query("SELECT * FROM users WHERE rank > 0 AND stafftitle!='HIDDEN' ORDER BY rank DESC", [])->rows;
?>

<?php
function SteamCardWrap($row)
{
    $title = htmlspecialchars($row->stafftitle);
    if ($title == "") {$title = "Cyber Police";}

    $title .= "<br>" . array(1=>"Junior Mod", 2=>"Moderator", 3=>"Developer", 4=>"Administrator", 9=>"Owner & Lead Developer")[$row->rank];

    if (Login(1)) {
        $title .= "<br>Last login: " . date("F j", $row->login_t) . "<br>" . SteamIDString($row->id);
    }
    SteamCard($row->id, $title);
}
?>
<?php /*
<div class="text-center"> <?php SteamCardWrap(array_shift($staff));    ?> </div>
<div class="text-center" style="zoom:0.875;"> <?php SteamCardWrap(array_shift($staff));    ?> </div>
 */?>
	<div class="row" style="zoom:0.75;">
	<div class="col-xs-6 text-right">
		<?php
$do = true;
foreach ($staff as $user) {
    if ($do) {
        SteamCardWrap($user);
    }
    $do = !$do;
}
?>
	</div>
	<div class="col-xs-6 text-left">
		<?php
$do = false;
foreach ($staff as $user) {
    if ($do) {
        SteamCardWrap($user);
    }
    $do = !$do;
}
?>
</div>
</div>

<h3 class="text-center">Want to join staff?</h3>
<p class="text-center">
    If you want to develop (code, model, map etc.) ask the owner. Pay is available.<br>
    <?php if (count($staff) >= 22) {?>
        <strong>Moderator positions are currently full.</strong>
    <?php } else {?>
        If you want to moderate (enforce rules), ask any staff. No pay.
    <?php }?>
</p>
