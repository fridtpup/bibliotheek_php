<?php 
include("../config/defines.php");
include("../src/query.php");
$query = new query();


include("html/header.html");

$_SESSION['username'] = "";

$query->login();
?>

<div class="container">
    <form class="loginForm" action="#" method="post">
        <label for="email">Email adress:</label>
        <input type="email" name="email">
        <label for="pass">Password:</label>
        <input type="password" name="pass">
        <input class="login" type="submit" name="loginBtn" value="Login">
    </form>
</div>
