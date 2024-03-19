<?php
class DB
{
    public function connect()
    {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (!$conn)
        {
            die ("<h4>Connection failed.</h4>");
        }
        
        return $conn;
    }
}
?>