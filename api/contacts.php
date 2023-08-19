<?php

class Contact {

  function getContacts($json){
    include "connection-pdo.php";

    //{"userId":"1"}
    $decodedJson = json_decode($json, true);
    $userId = $decodedJson["userId"];
  
    $sql = "SELECT a.* FROM tblcontacts a INNER JOIN tblusers b ON a.contact_userId = b.usr_id ";
    $sql .= "WHERE a.contact_userId = :userId ";
    $sql .= "ORDER BY a.contact_name";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":userId", $userId);
    $stmt->execute();
    $returnValue = $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : 0;
    $stmt = null;
    $conn = null;
    return json_encode($returnValue);
  }

  function getContact($json){
    include "connection-pdo.php";

    //{"userId":"1"}
    $decodedJson = json_decode($json, true);
    $userId = $decodedJson["userId"];
    $contactId = $decodedJson["contactId"];
  
    $sql = "SELECT a.* FROM tblcontacts a INNER JOIN tblusers b ON a.contact_userId = b.usr_id ";
    $sql .= "WHERE a.contact_userId = :userId AND contact_id=:contactId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":userId", $userId);
    $stmt->bindParam(":contactId", $contactId);
    $stmt->execute();
    $returnValue = $stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : 0;
    $stmt = null;
    $conn = null;
    return json_encode($returnValue);
  }

  function update($json){
    include "connection-pdo.php";
  
    $decodedJson = json_decode($json, true);
    $contactId = $decodedJson["contactId"];
    $name = $decodedJson["name"];
    $address = $decodedJson["address"];
    $number = $decodedJson["number"];
  
    $sql = "UPDATE tblcontacts SET contact_name	=:name,  contact_phone=:number,  contact_address=:address ";
    $sql .= "WHERE contact_id=:contactId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":number", $number);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":contactId", $contactId);
    $stmt->execute();
    $returnValue = $stmt->rowCount() > 0 ? 1 : 0;
    $stmt = null;
    $conn = null;
    return $returnValue;
  }
}

$json = $_POST['json'];
$job = $_POST['job'];

$contact = new Contact();
switch($job){
  case "getContacts":
    echo $contact->getContacts($json);
    break;
  case "getContact":
    echo $contact->getContact($json);
    break;
  case "update":
    echo $contact->update($json);
    break;
    }



?>