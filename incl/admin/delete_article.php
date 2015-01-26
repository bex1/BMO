<?php
include_once('incl/database.php');

$adDeleted = false;
if (isset($_POST['doDelete'])) {
    $stmt = $db->prepare("DELETE FROM Article WHERE id = :id");
    $adDeleted = $stmt->execute(array(
        ':id' => strip_tags($_POST['article']),
    ));
}

// Get all rows and fields from table Ads
$stmt = $db->prepare('SELECT * FROM Article;');
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Populate the select element
$select = "<select id='input1' name='article' onchange='form.submit();'>";
$select .= "<option value='-1'>Välj artikel</option>";
$current = null; // This will be the ad to update
foreach($articles as $article)
{
    $selected = "";
    if(isset($_POST['article']) && $_POST['article'] == $article['id'])
    {
        $selected = "selected";
        $current = $article;
    }
    $select .= "<option value='{$article['id']}' {$selected}>{$article['title']}</option>";
}
$select .= "</select>";

?>
<a href="<?=$base_url?>/admin.php">&laquo; tillbaka</a>
<h1>Ta bort artikel</h1>

<form method="post" action="">
    <fieldset>

        <label for="input1">Befintliga artiklar:</label><br />
        <?=$select?><br />

        <input type="submit" name="doDelete" value="Radera" />

        <?php if($adDeleted == true): ?>
            <div class="success" style="margin-top: 20px;"><p>Annons borttagen!</p></div>
        <?php endif; ?>

    </fieldset>
</form> 