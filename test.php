<?php
include "conn.php";
require('PHPMailer-master/PHPMailerAutoload.php');
require('PHPMailer-master/class.smtp.php');
require('PHPMailer-master/class.phpmailer.php');

 $insert=0;
 $update=0;

 $sql = "CREATE DATABASE IF NOT EXISTS wordpress";
 $pdo->exec($sql);



$sql = "CREATE TABLE IF NOT EXISTS test (
  id INT(6) Unique AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(300) NOT NULL,
  about VARCHAR(3000) NOT NULL,
  organizer VARCHAR(150) Not null,
  timestamp Datetime,
  isActive boolean,
  email VARCHAR(50) Not null,
  address VARCHAR(50) Not null,
  latitude double,
  longitude double,
  is_insert int
  )";
$pdo->exec($sql);


$sql1 = "CREATE TABLE IF NOT EXISTS tags (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tags_id int ,
  tags VARCHAR(100) NOT NULL
 )";
 
$pdo->exec($sql1);

    $url = "json.json";

    $json = file_get_contents($url);
    $data = json_decode($json, TRUE);
    /* print_r($data); */

    foreach ($data as $key => $value) {
      
      /* echo $value['title'].'<br>'; */
      $id = $value['id'];
     
      $sql = $pdo->prepare( "SELECT * FROM test WHERE id= ? ");
      $sql->execute([ $id ]);
      
      if ($sql->rowCount() < 1) {
        //insert
        
        $sql = "INSERT INTO test (id , title, about, organizer, timestamp, isActive, email, address,latitude, longitude, is_insert) values ( 
        :id , :title , :about  , :organizer , :timestamp  , :isActive , :email , :address, :latitude, :longitude , :insert )";

      $data1 = [
        'id' => $value['id'],
        'title' => $value['title'],
        'about' => $value["about"],
        'organizer' => $value["organizer"],
        'timestamp' => $value["timestamp"],
        'isActive' =>  $value["isActive"],
        'email' => $value["email"],
        'address' => $value["address"],
        'latitude' => $value["latitude"],
        'longitude' => $value["longitude"],
        'insert' => 0
        
    ];

    //tags

    $stmt= $pdo->prepare($sql);
    $stmt->execute($data1);

    foreach ($value['tags'] as $key1 => $value1) {
      $i=0;
        $sql = "INSERT INTO tags (tags_id, tags ) values ( 
            :tags_id , :tags )";

          $data1 = [
            'tags_id' => $id,
            'tags' => $value1
            
        ];
       /*  print_r($data1); */

        $stmt= $pdo->prepare($sql);
        $stmt->execute($data1);
        
        $i++;
      } 
      $insert++;

    }else{
        //upate


    $sql = "UPDATE test set "
    . "  title = ? , about= ?, organizer = ?, timestamp =?, isActive=?, email=?, address=?, latitude=?, longitude=?, is_insert=?  where id =  ? ";

    $sql= $pdo->prepare($sql);   
    $sql->execute([ $value['title'] , $value["about"], $value["organizer"], $value["timestamp"], $value["isActive"], $value["email"],
                  $value["address"] , $value["latitude"] ,  $value["longitude"], 1 , $value['id'] ]);
      
      $sql = "DELETE FROM tags WHERE tags_id =  ? ";
      $sql= $pdo->prepare($sql);
      $sql->execute([ $value['id'] ]); 
      
      foreach ($value['tags'] as $key1 => $value1) {
        $i=0;
          $sql = "INSERT INTO tags (tags_id, tags ) values ( 
              :tags_id , :tags )";
  
            $data1 = [
              'tags_id' => $id,
              'tags' => $value1
              
          ];
         /*  print_r($data1); */
  
          $stmt= $pdo->prepare($sql);
          $stmt->execute($data1);
          
          $i++;
        }
        $update++;  

    }
  }

 /*  echo $insert.' aaaaa';
  echo $update.' aaaaa'; */


//mail

/* $mail = "djogo.st@gmail.com"; */
$mail = "logging@agentur-loop.com";

$mailer = new PHPMailer();

$mailer->isSMTP();
$mailer->Host       = 'cpanel35.orion.rs';
$mailer->SMTPAuth = true;
$mailer->Port       = 587;
$mailer->Username   = "no-reply@amplitudo.me";
$mailer->Password   = "Amplitudo123";
$mailer->SMTPSecure = 'tls';
$mailer->CharSet = 'utf-8';
$mailer->isHTML(true);
$mailer->From       =  "djogo.st@gmail.com";

$mailer->FromName   = 'Stefan Djogo';
$mailer->addAddress($mail);

$mailer->Subject    = "Kontakt";
  $mailer->Body       =
          " Inserted data: <b>" . $insert . "</b><br>"
      . " Updated data: <b>" . $update . "</b><br>";
  
     
  if (!$mailer->send()) {
      echo 'Wrong entry';
      
  } else {
    echo 'Mail was sent';
      
  }
    
?>
