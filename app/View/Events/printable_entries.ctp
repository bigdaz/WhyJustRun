<h2><?=$event["Event"]["name"]?> on <?=$event["Event"]["date"]?></h2>
<?
$courses = $event["Course"];
if(count($courses) > 0) {
    foreach ($courses as $course) {
    $users = $course["Result"];?>
    <h3>Course: <?= $course["name"] . " (" . count($users) ." participants)"?></h3>
    <table>
        <thead>
        <tr>
            <th width="1px">&nbsp;</th><th width="1px">Name</th><th>Member</th><th width="1px"><nobr>SI number</nobr></th><th width="20p">X</th><th width="33%">Start time</th><th width="33%">Finish time</th><th width="33%">Total time</th>
        </tr>
        </thead>
        <?
        $counter = 1;
        foreach ($users as $user) { ?>
        <tr>
            <td><?= $counter?></td>
            <td><nobr><?= $user["User"]["name"]?></nobr></td>
            <td><?= $user["User"]["is_member"] ? '✓': null ?></td>
            <td><?= $user["User"]["si_number"]?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <?
            $counter = $counter + 1;
        }
        // Draw extra blank rows
        for ($i=0; $i < Configure::read('Event.numBlankEntries'); $i++) {?>
        <tr>
            <td><?= $counter + $i?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?} ?>
    </table>
    <?}
}
else {?>
No courses defined
    
<?}?>
