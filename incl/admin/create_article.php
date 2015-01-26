<?php
include_once('incl/database.php');

$adCreated = false;
if (isset($_POST['doCreate'])) {
    $allowed_tags = "<b><i><p><img>";
    $title_stripped = strip_tags($_POST['title'], $allowed_tags);

    $stmt = $db->prepare("INSERT INTO Article (title) VALUES (?)");
    $adCreated = $stmt->execute(array($title_stripped));
    $newAd = $title_stripped;
}

// Get all rows and fields from table Ads
$stmt = $db->prepare('SELECT * FROM Article;');
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Populate the list element
$article_list = "<ul>";
foreach($articles as $article)
    $article_list .= "<li>{$article['title']} ({$article['id']})</li>";
$article_list .= "</ul>";
?>
<a href="<?=$base_url?>/admin.php">&laquo; tillbaka</a>
<h1>Lägg till artikel</h1>
<h4>Befintliga artiklar</h4>
<?=$article_list?>

<form method="post" action="">
    <fieldset>

        <label for="input1">Titel på ny artikel</label><br />
        <input type="text" name="title" /><br />

        <input type="submit" name="doCreate" value="Spara" />

        <?php if($adCreated == true): ?>
            <p class="success" style="margin-top: 20px;">Annons "<?=$newAd?>" tillagd.</p>
        <?php endif; ?>

    </fieldset>
</form> 