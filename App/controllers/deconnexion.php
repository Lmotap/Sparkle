<?php 
    session_name("admin");
    session_start();

    session_destroy();

    header("Location: ../../pages/admin/connexion_form.php");