<?php 
include("../config/defines.php");
include("../src/query.php");
$query = new query();

$query->editBook();

include("html/header.html");
?>

<div class="contentBox">
    <div class="editform">
        <p>Boek toevoegen of bewerken</p>
        <?php while ($bookInfo = $query->bookDataQuery->fetch_assoc()) { ?>
            <form class="editBookForm" action="#" method="post">
                <label for="title">Titel</label>
                <input type="text" name="title" value="<?php echo $bookInfo['titel']?>">
                <label for="author">Auteur</label>
                <input type="text" name="author" value="<?php echo $bookInfo['auteur']?>">
                <label for="subject">Onderwerp</label>
                <input type="text" name="subject" value="<?php echo $bookInfo['onderwerp']?>">
                <label for="isbn">ISBN</label>
                <input type="text" name="isbn" value="<?php echo $bookInfo['isbn']?>">
                <label for="year">Jaar</label>
                <input type="text" name="year" value="<?php echo $bookInfo['jaar']?>">
                <label for="available">Aanwezig</label>
                <input type="text" name="available" value="<?php echo $bookInfo['aanwezig']?>">
                <input class="submit" type="submit" value="Opslaan" name="editBook">
            </form>
        <?php } ?>
    </div>
</div>