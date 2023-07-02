<?php
require '../includes/init.php';

Auth::requiresLogin();

$conn = require '../includes/db.php';

//This is the id passed in, is it actually set to something?
if (isset($_GET['id'])) {
    $article = Article::getById($conn, $_GET['id']);

    if (!$article) {
        die("article not found!");
    }
} else {

    die("id not supplied, article not found!");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    var_dump($_FILES);

    try {

        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new Exception("No file uploaded");
                break;
            case UPLOAD_ERR_INI_SIZE:
                throw new Exception("File is too large");
                break;
            default:
                throw new Exception("An error occurred processing your request");
        }

        if ($_FILES['file']['size'] > 10000000) {
            throw new Exception("File is too large");
        }

        $ok_mime_types = ['image/gif', 'image/png', 'image/jpeg'];

        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_mime_type = finfo_file($fileinfo, $_FILES['file']['tmp_name']);

        if (! in_array($file_mime_type, $ok_mime_types)) {
            throw new Exception("Invalid file type");
        }

        
        // Move the uploaded file
        $pathinfo = pathinfo($_FILES['file']['name']);
        
        $base = $pathinfo['filename'];
        
        $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);
        
        $filename = $base . '.' . $pathinfo['extension'];
        
        $destination = "../uploads/$filename";

        $i = 1;

        while (file_exists($destination)) {
            
            $filename = $base . "-$i." . $pathinfo['extension'];
            $destination = "../uploads/$filename";
            $i++;

        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination))
        {
            echo "File uploaded successfully";
        } else {
            throw new Exception("Unable to move uploaded file");
        }
 
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
}

?>
<?php require '../includes/header.php'; ?>

<h2>Edit article image</h2>

<form method="post" enctype="multipart/form-data">
    <div>
        <label for="fileControl">Image file</label>
        <input type="file" name="file" id="fileControl">
    </div>
    <button>Upload</button>
</form>

<?php require '../includes/footer.php'; ?>