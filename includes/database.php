<?php
/**
 * Get the database connection
 * 
 * @return object Connection to MySQL server
 */
function getDB()
{
    $db_host = "localhost";
    $db_user = "simon";
    $db_pass = "Nal149--";
    $db_name = "cms";

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit;
    }

    return $conn;
}

?>
