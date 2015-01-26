<?php
include_once('incl/database.php');

if (isset($_POST['doSave'])) {
    $tags = "<b><i><p><img>";

    $query = "UPDATE Homepage
        SET content = :content, imageFile = :imageFile
        WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':id'           => strip_tags($_POST['id'], $tags),
        ':content'        => strip_tags($_POST['content'], $tags),
        ':imageFile'      => strip_tags($_POST['imageFile'], $tags),
    ));
}

$stmt = $db->prepare('SELECT * FROM Homepage WHERE id = 1;');
$stmt->execute();
$homepage_content = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<a href="<?=$base_url?>/admin.php">&laquo; tillbaka</a>
<h1>Uppdatera startsidan</h1>

<form method="post" action="">
    <fieldset>
        <input type="hidden" name="id" value="1">
        <label for="imageFile">Bildfil</label><br />
        <input type="text" name="imageFile" value="<?=$homepage_content['imageFile']?>" />
        <br /><br />
        <label for="content">Text</label><br />
        <textarea rows="10" name="content"><?=$homepage_content['content']?></textarea>
        <br>
        <input type="submit" name="doSave" value="Spara" />
        <br>
    </fieldset>
</form>

<?php if(isset($adUpdated) || isset($_POST['doSave'])): ?>
    <div class="success" style="margin-top: 20px;"><p>Startsidan har blivit uppdaterad!</p></div>
<?php endif; ?> 