<?php
include("incl/config.php");
$pageId = "admin";

if (! userIsAuthenticated()) {
    header("Location: {$base_url}/login.php?p=login");
    exit;
}

// Check if the url contains a querystring with a page-part.
$p = null;
if(isset($_GET["p"]))
{
    $p = $_GET["p"];
}

$title = "Admin";
// Is the action a known action?
$path = "incl/admin";
if ($p == "object_create") {
    $title = "Lägg till nytt objekt";
    $file = "create_object.php";
} elseif ($p == "object_update") {
    $title = "Uppdatera befintligt objekt";
    $file = "update_object.php";
} elseif ($p == "object_delete") {
    $title = "Ta bort objekt";
    $file = "delete_object.php";
} elseif ($p == "article_update") {
    $title = "Uppdatera befintlig artikel";
    $file = "update_article.php";
} elseif ($p == "article_delete") {
    $title = "Ta bort artikel";
    $file = "delete_article.php";
} elseif ($p == "article_create") {
    $title = "Lägg till ny artikel";
    $file = "create_article.php";
} elseif ($p == "homepage_update") {
    $title = "Uppdatera startsidan";
    $file = "update_homepage.php";
} else {
    $file = "default.php";
}
?>

<?php include("incl/header.php"); ?>

<main class="main-container grid_12 admin">
    <?php include("$path/$file"); ?>
</main>
<?php include("incl/footer.php"); ?> 