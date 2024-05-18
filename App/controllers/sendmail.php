<?php
if($_POST){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['textarea'];
    $to = 'votre-email@example.com'; 
    $subject = 'Nouveau message de ' . $name;
    $headers = 'From: ' . $email;
    mail($to, $subject, $message, $headers);
}
?>