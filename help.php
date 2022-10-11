<?=Page("Help")?>

<?php
$commands = [
    'General' => [
        ['/help', '', 'Open this help page'],
        ['/join', '', 'Join our Steam group'],
        ['/rules', '', 'View the server rules'],
        ['/donate', '', 'Open the donation page, where you can support the server and recieve points for it'],
        ['/tp', 'PLAYER', 'Requests a teleport to a player'],
        ['/tpa', '', 'Accepts a requested teleport to you'],
        ['/editpony', '', 'Edit your pony player model'],
        ['/kill', '', 'Kills your player so you respawn'],
        ['/drop', '', 'Deletes your current weapon'],
        ['/8ball', 'QUESTION', 'Ask the magic 8-ball a question'],
    ],
    'Chat' => [
        ['/vote', '', 'Opens a menu that allows you to start a vote'],
        ['/image', ' QUERY', 'Search and display an image'],
        ['/gif', ' QUERY', 'Search and display a GIF'],
        ['[url:URL]', '', 'Post a specific image in chat'],
    ],
    'Stats' => [
        ['/deaths', '', 'Shows your death count in chat'],
        ['/kills', '', 'Shows your kill count in chat'],
        ['/playtime', '', 'Shows your playtime in global chat'],
    ],
    'Points' => [
        ['/roll', 'AMOUNT', 'Gamble points (points lost will NOT be reimbursed)'],
        ['/coinflip', 'PLAYER AMOUNT', 'Coinflip another player'],
        ['/lotto', '', 'Bet points in the lottery'],
        ['/givepoints', 'PLAYER AMOUNT', 'Gives a player a specified amount of points'],
        ['/points', '', 'Shows your points in global chat'],
        ['/bounty', 'PLAYER AMOUNT', 'Places a bounty on a player (you can bounty yourself)'],
        ['/bountyrandom', 'AMOUNT', 'Places a bounty on a random player'],
        ['/bountyall', 'AMOUNT', 'Places a bounty on everyone'],
    ],
];
?>

<?php
foreach ($commands as $category => $list) {
    ?>
    <h3><?=$category?></h3>
    <ul style="line-height:150%;">
    <?php
    foreach ($list as $command) {
        ?>
    <li>
        <strong><?=$command[0]?></strong>
        <em><?=$command[1]?></em>
        &nbsp; - &nbsp;
        <?=$command[2]?>
    </li>
    <?php
    }
    ?>
    </ul>
    <hr>
<?php
}
?>
