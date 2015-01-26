<?php

// -------------------------------------------------------------------------------------------
//
// Get current url
//
function getCurrentUrl() {
    $url = "http";
    $url .= (@$_SERVER["HTTPS"] == "on") ? 's' : '';
    $url .= "://";
    $serverPort = ($_SERVER["SERVER_PORT"] == "80") ? '' :
        (($_SERVER["SERVER_PORT"] == 443 && @$_SERVER["HTTPS"] == "on") ? '' : ":{$_SERVER['SERVER_PORT']}");
    $url .= $_SERVER["SERVER_NAME"] . $serverPort . htmlspecialchars($_SERVER["REQUEST_URI"]);
    return $url;
}


// -------------------------------------------------------------------------------------------
//
// Destroy a session
//
function destroySession() {
    // Unset all of the session variables.
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
}


// -------------------------------------------------------------------------------------------
//
// Function to open and read a directory, return its content as an array.
//
// $aPath: A path to the directory to scan for files. 
//
function readDirectory($aPath) {
    $list = Array();
    if(is_dir($aPath)) {
        if ($dh = opendir($aPath)) {
            while (($file = readdir($dh)) !== false) {
                if(is_file("$aPath/$file") && $file != '.htaccess') {
                    $list[$file] = "$file";
                }
            }
            closedir($dh);
        }
    }
    sort($list, SORT_STRING);
    return $list;
}


// -------------------------------------------------------------------------------------------
//
// Function to read a file and return its content.
//
// $aFilename: A filename with the whole path.
//  
function getFileContents($aFilename) {
    if(is_readable($aFilename)) {
        return file_get_contents($aFilename);
    } else {
        return "Filen finns ej.";
    }
}


// -------------------------------------------------------------------------------------------
//
// Function to save content to a file and return the status of the operation.
//
// $aFilename: A filename with the whole path. 
// $aContent: The content to save.
//  
function putFileContents($aFilename, $aContent) {
    if(is_writable($aFilename)) {
        file_put_contents($aFilename, $aContent);
        return "Filen sparades.";
    } else {
        return "Filen är inte skrivbar och kunde inte sparas.";
    }
}

// Search articles
function getArticlesByPattern($db, $pattern)
{
    $query = "SELECT * FROM Article WHERE title LIKE ? OR content LIKE ? OR author LIKE ?;";

    $stmt = $db->prepare($query);
    $stmt->execute(array("%$pattern%", "%$pattern%", "%$pattern%"));
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $articles;
}

// Search objects
function getObjectsByPattern($db, $pattern)
{
    $query = "SELECT * FROM Object WHERE title LIKE ? OR text LIKE ?";

    $stmt = $db->prepare($query);
    $stmt->execute(array("%$pattern%", "%$pattern%"));
    $objects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $objects;
}

// Get related objects
function getRelatedObjectsOfArticle($db, $article_title, $max_objects)
{
    switch ($article_title) {
        case 'Begravningskonfekt':
            $query = "SELECT * FROM Object WHERE category = 'Begravningskonfekt' LIMIT ?;";
            break;
        case 'Minnestavlor':
            $query = "SELECT * FROM Object WHERE category = 'Minnestavla' LIMIT ?;";
            break;
        case 'Pärlkransar':
            $query = "SELECT * FROM Object WHERE category = 'Pärlkrans' LIMIT ?;";
            break;
        case 'Begravningsfest och Gravöl - ett stort kalas':
            $query = "SELECT * FROM Object WHERE category = 'Begravningsfest' LIMIT ?;";
            break;
        default:
            return null;
            break;
    }

    $stmt = $db->prepare($query);
    $stmt->execute(array($max_objects));
    $objects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $objects;
}