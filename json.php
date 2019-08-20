<?php
include "conn.php";


$sql = $pdo->query("SELECT t.id, t.title, t.about, t.organizer, t.timestamp, t.isActive, t.email, t.address, t.latitude, t.longitude, t.is_insert
from test t
ORDER by t.timestamp desc");

$outp = [];
while($rs = $sql->fetch()) {
    $action = ($rs["is_insert"] == 0) ? "insert" : "update";

            $sql1 = $pdo->prepare("SELECT tags from tags where tags_id= ?");
            $sql1->execute([ $rs["id"] ]);
                    $tags = array();
                    
                    while($rss = $sql1->fetch()) {
                        array_push($tags, $rss["tags"]);
                    }

    $outp[] = array(
                    "action" =>$action,
                    "id" => $rs["id"],
                    "title" => $rs["title"],
                    "about" => $rs["about"],
                    "organizer" =>$rs["organizer"],
                    "timestamp" => $rs["timestamp"],
                    "isActive" =>$rs["isActive"],
                    "address" =>$rs["address"],
                    "latitude" =>$rs["latitude"],
                    "longitude" =>$rs["longitude"],
                    "tags" => $tags 
        );
}
/* $conn->close(); */

header("Content-Type: application/json");
echo json_encode($outp);
$cleanOutput =  ob_get_clean();  
echo $cleanOutput;
?>