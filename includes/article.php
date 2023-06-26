<?php

/**
 * Get the article record based on the passed in id
 * 
 * @param object $conn Connection to the database
 * @param integer $id the article id
 * @param string $columns Optional list of columns to select, default is *
 * 
 * @return mixed An associative array containing the article with that id or null if not found
 */
function getArticle($conn, $id, $columns = '*')
{
    $sql = "SELECT $columns
            FROM article
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


