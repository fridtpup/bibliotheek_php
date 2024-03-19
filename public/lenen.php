<?php
include("html/header.html");
include("../config/defines.php");
include("../src/query.php");

$query = new query();
$query->borrowBook();
?>
<div class="contentBox">
    <div class="borrowInfo">
        <p>U staat op het punt dit te lenen</p>
        <p>Boeknummer: <b><?php echo $_SESSION['bookNum']?></b> </p>
        <p>Titel: <b><?php echo $_SESSION['title']?></b> </p>
        <p>Auteur: <b><?php echo $_SESSION['author']?></b> </p>
        <p>Jaar van uitgave: <b><?php echo $_SESSION['year']?></b> </p>
    </div>

    <form class="emailForm" action="#" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email">
        <input class="submit" type="submit" value="Leen boek" name="borrow">
    </form>
</div>