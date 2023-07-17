
<?php

$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
return $db->getConn();