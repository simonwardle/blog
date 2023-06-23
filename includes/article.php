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

/**
 * Validate the article properties
 * 
 * @param string $title The title, is required
 * @param string $content The content, is required
 * @param string $published_at The published date and time, yyyy-mm-dd hh:mm:ss
 * 
 * @return array An array of validation error messages
 */
function validateArticle($title, $content, $published_at)
{
    $errors = [];

    if ($title == '') {
        $errors[] = 'Title is require.';
    }
    if ($content == '') {
        $errors[] = 'Content is require.';
    }
    if ($published_at != '') {
        $dateTime = date_create_from_format('Y-m-d H:i:s', $published_at);

        if ($dateTime === false) {

            $errors[] = 'Invalid date and time';
        } else {
            // date_create_from_format will allow 30th Feb through so check again.
            $dateErrors = date_get_last_errors();

            //if ($dateErrors['warning_count'] > 0) {
            if ($dateErrors) {
                $errors[] = 'Invalid date and time';
            }
        }
    }
    return $errors;
}
