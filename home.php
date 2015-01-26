<?php include("incl/config.php");
include_once('incl/database.php');

$title = "Begravningsmuseum Online";
$pageId = "home";

$stmt = $db->prepare('SELECT * FROM Homepage WHERE id = 1;');
$stmt->execute();
$hompage_content = $stmt->fetch(PDO::FETCH_ASSOC);
?>



<?php include("incl/header.php"); ?>
    <div class="home-img">
        <img src="img/<?=$hompage_content['imageFile']?>" class="background" alt="">
        <h2><?=str_replace(PHP_EOL, '<br />', $hompage_content['content']);?></h2>
    </div>
<?php include("incl/footer.php"); ?>