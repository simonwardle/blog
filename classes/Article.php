<?php

/**
 * Article
 * 
 * A piece of writing for publication
 */
class Article
{
    /**
     * Unique identifier
     * @var integer
     */
    public $id;
    /**
     * The article title
     * @var string
     */
    public $title;
    /**
     * The article content
     * @var string
     */
    public $content;
    /**
     * The publication date and time
     * @var datetime
     */
    public $published_at;
    /**
     * Get all articles
     * 
     * @param object $conn Connection to the database
     * 
     * @return array An associative array of all the article records
     */
    public static function getAll($conn)
    {

        $sql = "SELECT * 
                FROM article
                ORDER BY published_at;";

        $results = $conn->query($sql);

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Get the article record based on the passed in id
     * 
     * @param object $conn Connection to the database
     * @param integer $id the article id
     * @param string $columns Optional list of columns to select, default is *
     * 
     * @return mixed An object of this class, null if not found
     */
    public static function getById($conn, $id, $columns = '*')
    {
        $sql = "SELECT $columns
            FROM article
            WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');

        if ($stmt->execute()) {

            return $stmt->fetch();
        }
    }

    /**
     * Update the article with its current property values
     * 
     * @param object $conn Connection to the database
     * @return boolean True if the update was successful, false otherwise
     */
    public function update($conn)
    {
        $sql = "UPDATE article
                SET title = :title, 
                    content = :content, 
                    published_at = :published_at
                WHERE id = :id";
        
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);

        if ($this->published_at == '') { 
            $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
        }

        return $stmt->execute();
    }
}
