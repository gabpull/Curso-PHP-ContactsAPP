<?php
   
   require "database.php";

   session_start();

   if (!isset($_SESSION["user"])) {
    header("Location: Login.php");
    return;
  }

   $id = $_GET["id"];

   $statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id");
   $statement->execute([":id" => $id]);

   if ($statement->rowCount() == 0){
     http_response_code(404);
     echo("HTTP 404 NOT FOUND");
     return;
   }

   $contact = $statement->fetch(PDO::FETCH_ASSOC);

   if ($contact["user_id"] !== $_SESSION["user"]["id"]) {
     http_response_code(403);
     echo("HTTP 403 UNAUTORIZED");
     return;
   }

   $conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

   header("Location: home.php");

?>
