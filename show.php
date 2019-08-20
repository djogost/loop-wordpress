<?php
include "conn.php";
require('test.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        #content_parent > *:nth-child(odd){
            /* background-color: #edf3fc; */
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>

</head>
<body>
<div id="parent" style="display: grid; column-gap: 35px">
<?php 
$sql = $pdo->query("SELECT t.id, t.title, t.about, t.organizer, t.timestamp, t.isActive, t.email, t.address, t.latitude, t.longitude
from test t
ORDER by t.timestamp desc
");
?>
    <div style="grid-column-end: 3;"></div>
<?php
while($rs = $sql->fetch()) {

$start_t = strtotime($rs["timestamp"]);
$current_t = time();
$time= $start_t-$current_t;
$time_remaning= secondsToTime($time);

 ?>

    <ul id="content_parent" style="border: 1px solid tomato; padding-top: 10px; padding-bottom: 10px;">
        <li><?php echo $rs["id"] ?></li>
        <li><?php echo $rs["title"] ?></li>
        <li><?php echo $rs["about"] ?></li>
        <li><?php echo $rs["organizer"] ?></li>
        <li><?php echo $rs["timestamp"] ?></li>
        <li><?php echo $rs["isActive"] ?></li>
        <li><?php echo $rs["email"] ?></li>
        <li><?php echo $rs["address"] ?></li>
        <li><?php echo $rs["latitude"] ?></li>
        <li><?php echo $rs["longitude"] ?></li>
        
        <?php
            $sql1 = $pdo->prepare("SELECT tags
            from tags 
            where tags_id= ?");
            $sql1->execute([ $rs["id"] ]);
            while($rs1 = $sql1->fetch()) {
        ?>
            <ul>
            <li><?php echo $rs1["tags"] ?></li>
        </ul>
        <?php
            }
        ?>
        <li><?php echo $time_remaning ?> left</<li>

    </ul>

 <?php 
}

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}
 ?>
    </div>
</body>
</html>