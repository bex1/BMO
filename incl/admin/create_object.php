<?php
include_once('incl/database.php');

$adCreated = false;
if (isset($_POST['doCreate'])) {
    $allowed_tags = "<b><i><p><img>";
    $title_stripped = strip_tags($_POST['title'], $allowed_tags);

    $stmt = $db->prepare("INSERT INTO Object (title) VALUES (?)");
    $adCreated = $stmt->execute(array($title_stripped));
    $newAd = $title_stripped;
}

// Get all rows and fields from table Ads
$stmt = $db->prepare('SELECT * FROM Object;');
$stmt->execute();
$objects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Populate the list element
$object_list = "<ul>";
foreach($objects as $object)
    $object_list .= "<li>{$object['title']} ({$object['id']})</li>";
$object_list .= "</ul>";
?>
<a href="<?=$base_url?>/admin.php">&laquo; tillbaka</a>
<h1>Lägg till objekt</h1>
<h4>Befintliga objekt</h4>
<?=$object_list?>

<form method="post" action="">
    <fieldset>

        <label for="input1">Titel på nytt objekt</label><br />
        <input type="text" name="title" /><br />

        <input type="submit" name="doCreate" value="Spara" />

        <?php if($adCreated == true): ?>
            <p class="success" style="margin-top: 20px;">Annons "<?=$newAd?>" tillagd.</p>
        <?php endif; ?>

    </fieldset>
</form> 