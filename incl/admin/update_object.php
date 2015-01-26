<?php
include_once('incl/database.php');

if (isset($_POST['doSave'])) {
    $tags = "<b><i><p><img>";

    $query = "UPDATE Object
        SET title = :title, category = :category, image = :image, text = :text, owner = :owner
        WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':id'           => strip_tags($_POST['id'], $tags),
        ':title'        => strip_tags($_POST['title'], $tags),
        ':image'        => strip_tags($_POST['image'], $tags),
        ':text'         => strip_tags($_POST['text'], $tags),
        ':category'     => strip_tags($_POST['category'], $tags),
        ':owner'        => strip_tags($_POST['owner'], $tags),
    ));
}

// Get all rows and fields from table Ads
$stmt = $db->prepare('SELECT * FROM Object;');
$stmt->execute();
$objects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Populate the select element
$select = "<select id='input1' name='object' onchange='form.submit();'>";
$select .= "<option value='-1'>Välj annons</option>";
$current = null; // This will be the ad to update
foreach($objects as $object)
{
    $selected = "";
    if(isset($_POST['object']) && $_POST['object'] == $object['id'])
    {
        $selected = "selected";
        $current = $object;
    }
    $select .= "<option value='{$object['id']}' {$selected}>{$object['title']}</option>";
}
$select .= "</select>";

?>
<a href="<?=$base_url?>/admin.php">&laquo; tillbaka</a>
<h1>Uppdatera objekt</h1>

<form method="post" action="">
    <fieldset>

        <label for="input1">Välj objekt:</label>
        <?php echo $select; ?><br />
        <br /><br />
        <?php if(isset($_POST['object']) || isset($_POST['doSave'])): ?>
            <input type="hidden" name="id" value="<?=$current['id']?>">
            <label for="title">Titel</label><br />
            <input type="text" name="title" value="<?=$current['title']?>" />
            <br /><br />
            <label for="title">Kategori</label><br />
            <input type="text" name="category" value="<?=$current['category']?>" />
            <br /><br />
            <label for="image">Bildlänk</label><br />
            <input type="text" name="image" value="<?=$current['image']?>" />
            <br /><br />
            <label for="description">Text</label><br />
            <textarea rows="10" name="text"><?=$current['text']?></textarea>
            <br /><br />
            <label for="owner">Ägare</label><br />
            <input type="text" name="owner" value="<?=$current['owner']?>" />
            <br /><br />
            <input type="submit" name="doSave" value="Spara" />
        <?php endif; ?>

    </fieldset>
</form>

<?php if(isset($adUpdated) || isset($_POST['doSave'])): ?>
    <div class="success" style="margin-top: 20px;"><p>Annonsen har blivit uppdaterad!</p></div>
<?php endif; ?> 