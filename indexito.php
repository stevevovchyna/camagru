<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['login'])) { //user logging in
        require 'login.php';
    }
    elseif (isset($_POST['register'])) { //user registering   
        require 'register.php';
    }
}
?>
