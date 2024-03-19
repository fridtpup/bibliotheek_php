<?php
include("html/header.html");
include("../config/defines.php");
include("../src/query.php");

$query = new query();

$_SESSION['bookNum'] = "";
$_SESSION['title'] = "";
$_SESSION['author'] = "";
$_SESSION['year'] = "";

$query->loginPageRef();
$query->searchBooks();
$query->borrowPageRef();

?>
<div class="contentBox">
    <form class="searchForm" action="#" method="post">
        <div class="searchOpts">
            <input type="radio" name="title">
            <label for="title">Titel</label>
            <input type="radio" name="author">
            <label for="author">Auteur</label>
            <input type="radio" name="isbn">
            <label for="isb">ISBN</label>
            <input type="radio" name="year">
            <label for="year">Jaar van uitgave</label>
            <input type="radio" name="subject">
            <label for="subject">Onderwerp</label>
        </div>
        <div class="searchQuery">
            <label for="searchBox">Zoekterm:</label>
            <input type="text" name="searchBox">
        </div>
        <div class="searchBtn">
            <input name="searchBtn" type="submit" value="Zoeken">
        </div>
    </form>

    <div class="booksFound">
        <?php
         if (isset($_POST['searchBtn'])) { 
             echo "$query->count boeken gevonden" ;
         }
        ?>
    </div>

    <table class="bookTable">
        <tr>
            <th>Boeknmmer</th>
            <th>Titel</th>
            <th>Auteur</th>
            <th>Onderwerp</th>
            <th>ISBN</th>
            <th>Jaar van publicatie</th>
            <th>Aanwezig?</th>
            <th>Lenen</th>
        </tr>
    <?php 
    if (isset($_POST['searchBtn'])) { 
        while ($bookData = $query->bookList->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $bookData["id"] ?></td>
            <td><?php echo $bookData["titel"] ?></td> 
            <td><?php echo $bookData["auteur"] ?></td> 
            <td><?php echo $bookData["onderwerp"] ?></td> 
            <td><?php echo $bookData["isbn"] ?></td> 
            <td><?php echo $bookData["jaar"] ?></td> 
            <td>
                <?php 
                $availability = $bookData['aanwezig'];

                if ($availability == 0) 
                {
                    echo "Nee";
                }

                else 
                {
                    echo "Ja";
                }
                ?>
            </td>
            <td>
                <form action="#" method="POST">
                    <input type="hidden" name="bookID" value="<?php echo $bookData['id'] ?>">
                    <?php
                    
                    if ($availability == 1) 
                    {
                        echo "<input class='borrow' type='submit' value='Lenen' name='borrow'>";
                    }
                    
                    ?>
                 </form>
            </td>
        </tr>
    <?php } 
    }?>
    </table>
</div>