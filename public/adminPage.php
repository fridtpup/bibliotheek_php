<?php 
include("../config/defines.php");
include("../src/query.php");
$query = new query();

$query->getBookList();
$query->logout();
$query->editPageRef();
$query->addBook();
$query->deleteBook();
$query->getBorrowedBooks();
$query->deleteBorrowedBook();


include("html/header.html");
?>
<div class="contentBox">
    <h2>Boeken</h2>
    <table class="bookTable">
        <tr>
            <th>Boeknmmer</th>
            <th>Titel</th>
            <th>Auteur</th>
            <th>Onderwerp</th>
            <th>ISBN</th>
            <th>Jaar van publicatie</th>
            <th>Aanwezig?</th>
            <th>Actie</th>
        </tr>
    <?php while ($bookData = $query->allBooks->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $bookData["id"] ?></td>
            <td><?php echo $bookData["titel"] ?></td> 
            <td><?php echo $bookData["auteur"] ?></td> 
            <td><?php echo $bookData["onderwerp"] ?></td> 
            <td><?php echo $bookData["isbn"] ?></td> 
            <td><?php echo $bookData["jaar"] ?></td> 
            <td><?php echo $bookData['aanwezig'] ?></td>
            <td>
                <form action="#" method="POST">
                    <input type="hidden" name="bookID" value="<?php echo $bookData['id'] ?>">
                    <input class="crudRefs" name="edit" type="submit" value="Bewerken">
                    <input class="crudRefs" name="deleteBook" type="submit" value="Verwijderen">
                </form>
            </td>
        </tr>
    <?php } ?>
    </table>
    <div class="bottomContent">
        <div class="crudForm">
            <p>Boek toevoegen of bewerken</p>
            <form class="AddBookForm" action="#" method="post">
                <label for="title">Titel</label>
                <input type="text" name="title">
                <label for="author">Auteur</label>
                <input type="text" name="author">
                <label for="subject">Onderwerp</label>
                <input type="text" name="subject">
                <label for="isbn">ISBN</label>
                <input type="text" name="isbn">
                <label for="year">Jaar</label>
                <input type="text" name="year">
                <label for="available">Aanwezig</label>
                <input type="text" name="available">
                <input class="submit" type="submit" value="Opslaan" name="addBook">
            </form>
        </div>

        <h3>Leningen</h3>
        <table class="borrowTable">
            <tr>
                <th>Nummer</th>
                <th>Boeknummer</th>
                <th>E-mailadres</th>
                <th>Actie</th>
            </tr>
            <?php while ($borrowList = $query->borrowListQuery->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $borrowList['id'] ?></td>
                <td><?php echo $borrowList['boek_id'] ?></td>
                <td><?php echo $borrowList['e-mailadres'] ?></td>
                <td>
                    <form action="#" method="post">
                        <input type="hidden" name="borrowID" value="<?php echo $borrowList['id'] ?>" >
                        <input class="crudRefs" name="deleteBorrow" type="submit" value="Verwjderen">
                    </form>    
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
    
</div>