<?php
class query extends DB
{
    public $bookList;
    public $count;
    public $allBooks;
    public $bookDataQuery;
    public $borrowListQuery;

    public $bookNum;
    public $title;
    public $author;
    public $year;

    // create shortcut for query function.
    private function queryFunct($sql)
    {
        return $this->connect()->query($sql);
    }

    // Get all the books from the book database
    public function getBookList()
    {
        $sql = "SELECT * FROM boeken";
        $this->allBooks = $this->queryFunct($sql);
    }
    
    // Checks which thing you search for.
    private function searchSelector($searchType)
    {
        $searchQuery = $_POST['searchBox'];

        $bookSql = "SELECT * FROM boeken WHERE $searchType LIKE '%$searchQuery%'";
        $this->bookList = $this->queryFunct($bookSql);     
        
        $countSql = "SELECT count(*) FROM boeken WHERE $searchType LIKE '%$searchQuery%'";
        $bookCountQuery = $this->queryFunct($countSql);

        while ($bookCountResult = $bookCountQuery->fetch_assoc())
        {
            $this->count = $bookCountResult['count(*)'];
        }
    }

    // Searches the search query in the text field.
    public function searchBooks()
    {
        if (isset($_POST['searchBtn']))
        {
            $searchQuery = "";

            // Check which radio button has been selected
            if (isset($_POST['title']))
            {
                $this->searchSelector("titel");
            }

            else if (isset($_POST['author']))
            {
                $this->searchSelector("auteur");
            }

            else if (isset($_POST['isbn']))
            {
                $this->searchSelector("isbn");
            }

            else if (isset($_POST['year']))
            {
                $this->searchSelector("jaar");
            }

            else if (isset($_POST['subject']))
            {
                $this->searchSelector("onderwerp");
            }

            // if none is selected make nothing be displayed
            else {
                $bookSql = "SELECT * FROM boeken where titel = ''";
                $this->bookList = $this->queryFunct($bookSql);
            }

            // Count the total amount of books that have been selected
        }
    }

    public function loginPageRef()
    {
        if (isset($_POST['login']))
        {
            header('location: adminLogin.php');
        }
    }

    // Prepare all session vars before you get redirected to next page.
    public function borrowPageRef()
    {
        if (isset($_POST['borrow']))
        {
            $bookID = $_POST['bookID'];

            $sql = "SELECT * FROM boeken WHERE id = '$bookID'";
            $selectedBook = $this->queryFunct($sql);

            // create session vars to use on other pages
            while ($bookInfo = $selectedBook->fetch_assoc())
            {
                $_SESSION['bookNum'] = $bookInfo['id'];
                $_SESSION['title'] = $bookInfo['titel'];
                $_SESSION['author'] = $bookInfo['auteur'];
                $_SESSION['year'] = $bookInfo['jaar']; 
            }

            header("location: lenen.php");
        }
    }

    // Redirects you to edit page after creating required session variable.
    public function editPageRef()
    {
       if (isset($_POST['edit']))
       {
        $_SESSION['bookID'] = $_POST['bookID'];
        header("location: editPage.php");
       }
    }

    // Delete book with delete button using the hidden inputs value as id.
    public function deleteBook()
    {
        if (isset($_POST['deleteBook']))
        {
            $bookID = $_POST['bookID'];

            $deleteBookSQL = "DELETE FROM boeken WHERE id = '$bookID'";
            $deleteBookQuery = $this->queryFunct($deleteBookSQL);
            
            if ($deleteBookQuery)
            {
                header('location: adminPage.php');
            }
        }
    }

    // Get all items from the 'leningen' database table.
    public function getBorrowedBooks()
    {
        $borrowListSQL = "SELECT * FROM leningen";
        $this->borrowListQuery = $this->queryFunct($borrowListSQL);
    }

    // Delete borrowed book query using the hidden inputs value as id.
    public function deleteBorrowedBook()
    {
        if (isset($_POST["deleteBorrow"]))
        {
            $borrowID = $_POST['borrowID'];

            $deleteBorrowSQL = "DELETE FROM leningen WHERE id = $borrowID";
            $deleteBorrowQuery = $this->queryFunct($deleteBorrowSQL);

            if ($deleteBorrowQuery)
            {
                header("location: adminPage.php");
            }
        }
    }

    // Edit a book specified by using a session variable created from hidden input as id
    public function editBook()
    {
        $bookID = $_SESSION['bookID'];

        $bookDataSQL = "SELECT * FROM boeken WHERE id = '$bookID'";
        $this->bookDataQuery = $this->queryFunct($bookDataSQL);

        if (isset($_POST['editBook']))
        {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $subject = $_POST['subject'];
            $isbn = $_POST['isbn'];
            $year = $_POST['year'];
            $available = $_POST['available'];

            $editBookSql = "UPDATE boeken SET  titel = '$title', auteur = '$author', onderwerp = '$subject', isbn = '$isbn', jaar = '$year', aanwezig = '$available' WHERE id = '$bookID'";
            $editBookQuery = $this->queryFunct($editBookSql);

            if ($editBookQuery)
            {
                header("location: adminPage.php");
            }
        }
    }

    // Add book to database
    public function addBook()
    {
       if (isset($_POST['addBook']))
       {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $subject = $_POST['subject'];
        $isbn = $_POST['isbn'];
        $year = $_POST['year'];
        $available = $_POST['available'];

        $addBookSQL = "INSERT INTO boeken (titel, auteur, onderwerp, isbn, jaar, aanwezig)
            VALUES ('$title', '$author', '$subject', '$isbn', '$year', '$available')";
        $addBookQuery = $this->queryFunct($addBookSQL);

        if ($addBookQuery)
        {
            header("location: adminPage.php");
        }
       }
    }

    // Borrow the book chosen with session variable
    public function borrowBook()
    {
        if (isset($_POST['borrow']))
        {
            $email = $_POST['email'];
            $bookID = $_SESSION['bookNum'];

            $sqlCount = "SELECT count(*) FROM leningen WHERE `e-mailadres` = '$email'";
            $borrowCountQuery = $this->queryFunct($sqlCount);
            
            while ($countResult = $borrowCountQuery->fetch_assoc())
            {
                $count = $countResult['count(*)'];

                if ($count < 3)
                {
                    $sqlInsert = "INSERT INTO leningen (boek_id, `e-mailadres`)
                        VALUES ('$bookID', '$email')";
                    $insertQuery = $this->queryFunct($sqlInsert);

                    $sqlAvailability = "UPDATE boeken SET aanwezig = '0' WHERE id = '$bookID'";
                    $availabilityUpdate = $this->queryFunct($sqlAvailability);
                }

                else 
                {
                    header("location: index.php");
                }
            }
        }   
    }


    // Login query
    public function login()
    {
        if (isset($_POST['loginBtn']))
        {
            $email = $_POST['email'];
            $password = $_POST['pass'];

            $sql = "SELECT * FROM gebruikers WHERE `e-mailadres` = '$email'";
            $this->sqlQuery = $this->connect()->query($sql);

            if (mysqli_num_rows($this->sqlQuery) > 0)
            {
                while ($accountInfo = $this->sqlQuery->fetch_assoc())
                {
                    // Check whether email and password match with the account.
                    if ($email == $accountInfo['e-mailadres'] && $password == $accountInfo['wachtwoord'])
                    {
                        $_SESSION['username'] = $user;

                        header("location: adminPage.php");
                    }

                    // If login fails get error.
                    else 
                    {
                        echo ("<div class='failedLogin'>
                            <h3>Login failed</h3>
                            <a href='#'>Forgot your password?</a>
                            </div>" );
                    }
                }
            }
        }
    }

    // Log out function.
    public function logout()
    {
        if (isset($_POST['logOut']))
        {
            session_destroy();
            header("location: adminLogin.php");
        }
    }
    
}
?>