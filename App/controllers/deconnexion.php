<?php 
    session_name("admin");
    session_start();

    session_destroy();

    header("Location: connexion_form.php");