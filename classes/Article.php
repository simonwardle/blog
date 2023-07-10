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
     * @var string
     */
    public $published_at;

    /**
     * The path to the image
     * @var string
     */
    public $image_file;

    /**
     * Validation errors
     * @var array
     */
    public $errors = [];


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
     * getPage Get just a page of results
     *
     * @param  object $conn Connection to database
     * @param  integer $limit Number of records to return
     * @param  integer $offset Number of records to skip
     * @return array An associative array of the page of article records
     */
    public static function getPage($conn, $limit, $offset)
    {
        $sql = "SELECT a.*, category.name AS category_name
                FROM (SELECT *
                FROM article
                ORDER BY published_at
                LIMIT :limit
                OFFSET :offset) AS a
                LEFT JOIN article_category
                ON a.id = article_category.article_id
                LEFT JOIN category
                ON article_category.category_id = category.id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $articles = [];

        $previous_id = null;

        foreach ($results as $row) {
            $article_id = $row['id'];

            if ($article_id != $previous_id) {
                //must be a new article
                $row['category_names'] = [];
                $articles[$article_id] = $row;
            }
            //add the existing category to the new category_names array for the article
            $articles[$article_id]['category_names'][] = $row['category_name'];
            $previous_id = $article_id;
        }

        return $articles;
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
     * getTotal Count total number of articles in the database
     *
     * @param  object $conn Connection to the database
     * @return integer Count of article records
     */
    public static function getTotal($conn)
    {
        return $conn->query("SELECT COUNT(*) FROM article")->fetchColumn();
    }

    
    /**
     * getWithCategories - Get articles and their categories, if any
     *
     * @param  object $conn The connection to the database
     * @param  integer $id The article id
     * @return array The article data with categories
     */
    public static function getWithCategories($conn, $id)
    {
        $sql = "SELECT article.*, category.name AS category_name
                FROM article
                LEFT JOIN article_category
                ON article.id = article_category.article_id
                LEFT JOIN category
                ON article_category.category_id = category.id
                WHERE article.id = :id;";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * getCategories
     *
     * @param  object $conn The connection to the database
     * @return array Article categories
     */
    public function getCategories($conn)
    {
        $sql = "SELECT category.*
                FROM category
                JOIN article_category
                ON category.id = article_category.category_id
                WHERE article_id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Insert a new article with its current property values
     * @param object $conn Connection to the database
     * @return boolean True if the insert was successful, false otherwise
     */
    public function create($conn)
    {
        if ($this->validate()) {
            $sql = "INSERT INTO article (title, content, published_at)
                    VALUES (:title, :content, :published_at)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);

            if ($this->published_at == '') {
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Update the article with its current property values
     * @param object $conn Connection to the database
     * @return boolean True if the update was successful, false otherwise
     */
    public function update($conn)
    {
        if ($this->validate()) {
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
        } else {
            return false;
        }
    }

    public function setCategories($conn, $ids)
    {
        if ($ids) {
            $sql = "INSERT IGNORE INTO article_category (article_id, category_id)
                    VALUES ";

            $values = [];

            foreach ($ids as $id) {
                $values[] = "({$this->id}, ?)";
            }

            $sql .= implode(", ", $values); 


            $stmt = $conn->prepare($sql);

            
            foreach ($ids as $i => $id) {
                $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
            }

            $stmt->execute();
            
        }
        //User un-checked all the categories so delete them all for this Article
        $sql = "DELETE FROM article_category
                WHERE article_id = {$this->id}";

        //Some categories left checked - delete the ones not checked
        if ($ids) {
            $placeholders = array_fill(0, count($ids), '?');
            $sql .= " AND category_id NOT IN (" . implode(", ", $placeholders) . ")";
        }

        //var_dump($sql); exit;

        $stmt = $conn->prepare($sql);

        foreach ($ids as $i => $id) {
            $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
        }

        $stmt->execute();
    }

    /**
     * Update the article with its current property values
     * @param object $conn Connection to the database
     * @return boolean True if the delete was successful, false otherwise
     */
    public function delete($conn)
    {
        $sql = "DELETE FROM article
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    /**
     * Validate the properties, putting any validation error messages in the $errors property
     *
     * @return boolean True if the current properties are valid, false otherwise
     */
    protected function validate()
    {
        if ($this->title == '') {
            $this->errors[] = 'Title is require.';
        }
        if ($this->content == '') {
            $this->errors[] = 'Content is require.';
        }
        if ($this->published_at != '') {
            $dateTime = date_create_from_format('Y-m-d H:i:s', $this->published_at);

            if ($dateTime === false) {

                $this->errors[] = 'Invalid date and time';
            } else {
                // date_create_from_format will allow 30th Feb through so check again.
                $dateErrors = date_get_last_errors();

                //if ($dateErrors['warning_count'] > 0) {
                if ($dateErrors) {
                    $this->errors[] = 'Invalid date and time';
                }
            }
        }
        return empty($this->errors);
    }


    /**
     * setImageFile - Update the image file property
     *
     * @param  object $conn Connection to the database
     * @param  string $filename The filename of the image
     * @return boolean True if it is successful, false otherwise
     */
    public function setImageFile($conn, $filename)
    {
        $sql = "UPDATE article
                SET image_file = :image_file
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        // if ($filename) {
        //     $stmt->bindValue(':image_file', $filename, PDO::PARAM_STR);
        // } else {
        //     $stmt->bindValue(':image_file', $filename, PDO::PARAM_NULL);
        // }

        //Use ternary operator instead
        $stmt->bindValue(':image_file', $filename, $filename == null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        return $stmt->execute();
    }
}
