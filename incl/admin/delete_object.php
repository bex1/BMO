<?php
include_once('incl/database.php');

$adDeleted = false;
if (isset($_POST['doDelete'])) {
    $stmt = $db->prepare("DELETE FROM Object WHERE id = :id");
    $adDeleted = $stmt->execute(array(
        ':id' => strip_tags($_POST['object']),
    ));
}

// Get all rows and fields from table Ads
$stmt = $db->prepare('SELECT * FROM Object;');
$stmt->execute();
$objects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Populate the select element
$select = "<select id='input1' name='object' onchange='form.submit();'>";
$select .= "<option value='-1'>Välj objekt</option>";
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
<h1>Ta bort objekt</h1>

<form method="post" action="">
    <fieldset>

        <label for="input1">Befintliga objekt:</label><br />
        <?=$select?><br />

        <input type="submit" name="doDelete" value="Radera" />

        <?php if($adDeleted == true): ?>
            <p class="success" style="margin-top: 20px;">Objekt borttaget!</p>
        <?php endif; ?>

    </fieldset>
</form> 