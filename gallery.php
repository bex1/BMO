<?php
include("incl/config.php");
include_once('incl/database.php');

$title = 'Galleri';
$pageId = "gallery";

$objects = null;
if (isset($_GET['search'])) {
    $objects = getObjectsByPattern($db, $_GET['search']);
} else {
    $stmt = $db->prepare('SELECT * FROM Object;');
    $stmt->execute();
    $objects = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$num_objects = count($objects);

$page = 0;
$objects_per_page = 9;

if (isset($_GET['increment'])) {
    $objects_per_page = intval($_GET['increment']);
}
if (isset($_GET["page"])) {
    $page = $_GET["page"];
}
$num_pages = floor(($num_objects - 1) / $objects_per_page) + 1;

if ($page >= $num_pages) {
    $page = 0;
}

$limit = (intval($page) + 1) * $objects_per_page;

$show_previous_page = $page == 0 ? false : true;
$show_next_page = $limit >= $num_objects ? false : true;



$previous_page = $page - 1;
$next_page = $page + 1;


$image_id = null;
$show_previous_image = null;
$show_next_image = null;
if (isset($_GET['view'])) {
    $image_id = $_GET['view'];
    $show_previous_image = $image_id <= 0 ? false : true;
    $show_next_image = $image_id >= $num_objects - 1 ? false : true;
}
?>

<?php include("incl/header.php"); ?>

<main class="main-container grid_16">
    <?php if (isset($_GET['view'])): ?>
        <section class="single-object-section">
            <div class="pagination-section">
                <div class="prev-div">
                    <?php if ($show_previous_image):?>
                        <a href="?view=<?=$image_id - 1?>" class="prev-a">&laquo; Föregående bild</a>
                    <?php endif; ?>
                </div>
                <?php if ($show_next_image):?>
                    <div class="next-div">
                        <a href="?view=<?=$image_id + 1?>" class="next-a">Nästa bild &raquo;</a>
                    </div>
                <?php endif; ?>
            </div>
            <h2> <?=$objects[$image_id]['title']?></h2>
            <img src="<?=$base_url?>/<?=$objects[$image_id]['image']?>" alt="Bilden kunde inte visas">
            <p><i><?=$objects[$image_id]['text']?></i></p>
        </section>
    <?php else: ?>

        <section class="grid_15 push_1 ">
            <div class="title">
                <div class="search-container">
                    <h1>Galleri</h1>
                    <form id="searchform" name="searchform" method="get">
                        <div class="fieldcontainer">
                            <input type="text" name="search" id="search" class="searchfield" placeholder="Sök.." tabindex="1">
                        </div><!-- @end .fieldcontainer -->
                    </form>
                </div>


                <form method="get" id="nbrPerPage">
                    <fieldset>
                        <?php if (isset($_GET['page'])): ?>
                            <input type="hidden" name="page" value="<?=$page?>" />
                        <?php endif; ?>
                        <?php if (isset($_GET['search'])): ?>
                            <input type="hidden" name="search" value="<?=$_GET['search']?>" />
                        <?php endif; ?>
                        <label for="increment">Antal bilder per sida: </label>
                        <select name="increment" id="increment" onchange='form.submit();'>
                            <option value="9"<?=$objects_per_page==9 ? ' selected' : null?>>9</option>
                            <option value="18"<?=$objects_per_page==18 ? ' selected' : null?>>18</option>
                            <option value="30"<?=$objects_per_page==30 ? ' selected' : null?>>30</option>
                        </select>
                    </fieldset>
                </form>
            </div>
            <div>
                <div class="pagination-section">
                    <div class="prev-div">
                        <?php if ($show_previous_page):?>
                            <a href="?page=<?=$previous_page?>&amp;increment=<?=$objects_per_page?><?=isset($_GET['search']) ? '&amp;search='.$_GET['search'] : null?>" class="prev-a">&laquo; Föregående sida</a>
                        <?php endif; ?>
                    </div>
                    <div class="page-list-div">
                        <?php for ($i = 0; $i < $num_pages; $i++): ?>
                            <a href="?page=<?=$i?>&amp;increment=<?=$objects_per_page?><?=isset($_GET['search']) ? '&amp;search='.$_GET['search'] : null?>"><?=$i + 1?></a>
                        <?php endfor; ?>
                    </div>
                    <?php if ($show_next_page):?>
                        <div class="next-div">
                            <a href="?page=<?=$next_page?>&amp;increment=<?=$objects_per_page?><?=isset($_GET['search']) ? '&amp;search='.$_GET['search'] : null?>" class="next-a">Nästa sida &raquo;</a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="gallery-wrapper">
                    <?php for ($i = $limit - $objects_per_page; $i < min($limit, $num_objects); $i++): ?>
                        <div class="gallery-object-wrapper">
                            <div class="gallery-text-section">
                                <a href="?view=<?=$i?>"><?=$objects[$i]['title']?></a>
                            </div>
                            <div class="gallery-image-section">
                                <a href="?view=<?=$i?>" class="gallery-image">
                                    <img src="<?=$base_url?>/<?=substr_replace($objects[$i]['image'], '550/', 8, 0);?>" alt="Bilden kunde inte visas">
                                </a>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </section>

    <?php endif; ?>




</main>

<?php include("incl/footer.php"); ?>

