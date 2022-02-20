<?php //This file is subject to copyright - contact swampservers@gmail.com for more information. 

// <div class="text-center">
// <h1>We use <a href="https://s.team/chat/LzFgkFD4">Steam Chat</a> instead of Discord.<br>&nbsp;</h1>
// <p>We do have a Discord guild as well, but we only use it for voice/video chat. The link can be found in the "VOICE" section of our Steam Chat.<br>&nbsp;</p>
// <p>The reason we avoid Discord is because of their endless unreasonable takedowns. We can't run a Discord because any time anybody says anything even slightly offensive, we have to be paranoid that it will result in our group (and personal accounts) being banned for the 10th time, despite our best attempts to keep our group in compliance with their ToS.<br>&nbsp;</p>
// <!-- <br>&nbsp; -->
// <!-- <a href="/discordmoderators"> -->
// <!-- of our accounts and groups -->
// </div>

$link = "https://discord.gg/J4yyeW5evy";
header('Location: '.$link, true, 302);
?>


<?=common_top("Discord", "/s/screenshots/discordmoderator.jpg")?>

<p>
    <a href="<?=$link?>">Click here to join</a>
</p>

<?=common_bottom()?>