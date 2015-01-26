<?php
include_once('incl/database.php');

if (isset($_POST['doSave'])) {
    $tags = "<b><i><p><img>";
    $now  = new DateTime;

    $query = "UPDATE Article
        SET title = :title, category = :category, content = :content, author = :author
        WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':id'           => strip_tags($_POST['id'], $tags),
        ':title'        => strip_tags($_POST['title'], $tags),
        ':content'         => strip_tags($_POST['content'], $tags),
        ':category'     => strip_tags($_POST['category'], $tags),
        ':author'       => strip_tags($_POST['author'], $tags),
    ));
}

// Get all rows and fields from table Ads
$stmt = $db->prepare('SELECT * FROM Article;');
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Populate the select element
$select = "<select id='input1' name='object' onchange='form.submit();'>";
$select .= "<option value='-1'>Välj annons</option>";
$current = null; // This will be the ad to update
foreach($articles as $article)
{
    $selected = "";
    if(isset($_POST['object']) && $_POST['object'] == $article['id'])
    {
        $selected = "selected";
        $current = $article;
    }
    $select .= "<option value='{$article['id']}' {$selected}>{$article['title']}</option>";
}
$select .= "</select>";

?>
<a href="<?=$base_url?>/admin.php">&laquo; tillbaka</a>
<h1>Uppdatera artikel</h1>

<form method="post" action="">
    <fieldset>

        <label for="input1">Välj artikel:</label>
        <?php echo $select; ?><br /><br />

        <?php if(isset($_POST['object']) || isset($_POST['doSave'])): ?>
            <input type="hidden" name="id" value="<?=$current['id']?>">
            <label for="title">Titel</label><br />
            <input type="text" name="title" value="<?=$current['title']?>" />
            <br /><br />
            <label for="title">Kategori</label><br />
            <input type="text" name="category" value="<?=$current['category']?>" />
            <br /><br />
            <label for="description">Text</label><br />
            <textarea rows="10" name="content"><?=$current['content']?></textarea>
            <br /><br />
            <label for="author">Författare</label><br />
            <input type="text" name="author" value="<?=$current['author']?>" />
            <br /><br />
            <input type="submit" name="doSave" value="Spara" />
        <?php endif; ?>

    </fieldset>
</form>

<?php if(isset($adUpdated) || isset($_POST['doSave'])): ?>
    <div class="success" style="margin-top: 20px;"><p>Annonsen har blivit uppdaterad!</p></div>
<?php endif; ?> 