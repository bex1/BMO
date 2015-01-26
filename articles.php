<?php include("incl/config.php");
include_once('incl/database.php');

$title = "Artiklar";
$pageId = "articles";

$articles = null;
if (isset($_GET['search'])) {
    $articles = getArticlesByPattern($db, $_GET['search']);
} else {
    $stmt = $db->prepare('SELECT * FROM Article;');
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$nbr_articles = count($articles);


// Check if the url contains a querystring with a article-part.
$art_id = null;
if(isset($_GET["article"])) {
    $art_id = $_GET["article"];
    $article = $articles[$art_id - 1];
    $objects = getRelatedObjectsOfArticle($db, $article['title'], 3);

    $show_previous_article = $art_id <= 1 ? false : true;
    $show_next_article = $art_id >= $nbr_articles ? false : true;
}

?>


<?php include("incl/header.php"); ?>


<main class="main-container grid_16">

    <?php if (isset($article)): ?>
        <section class="grid_12 push_1">
            <div class="title">
                <h1><?=$article['title']?></h1>
            </div>
            <div class="pagination-section">
                <div class="prev-div">
                    <?php if ($show_previous_article):?>
                        <a href="?article=<?=$art_id - 1?>" class="prev-a">&laquo; Föregående artikel</a>
                    <?php endif; ?>
                </div>
                <?php if ($show_next_article):?>
                    <div class="next-div">
                        <a href="?article=<?=$art_id + 1?>" class="next-a">Nästa artikel &raquo;</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="long-articles-container">
                <article<?=isset($objects) ? ' class="with-objects"' : null?>>
                    <div class="article-content">
                        <section>
                            <?=$article['content']?>
                            <footer id="article_footer">
                                <p style="margin: 0;"><?=$article['author']?></p>
                                <p style="margin: 0;"><?=$article['pubdate']?></p>
                            </footer>
                        </section>
                        <?php if (isset($objects)): ?>
                            <aside>
                                <?php foreach ($objects as $object): ?>
                                    <a href="<?=$base_url?>/gallery.php?view=<?=$object['id'] - 1?>">
                                    <img src="<?=$base_url?>/<?=substr_replace($object['image'], '550/', 8, 0);?>" alt="Bilden kunde inte visas">
                                    </a>
                                    <a class="aside-article-img-link" href="<?=$base_url?>/gallery.php?view=<?=$object['id'] - 1?>""><?=$object['title']?></a>
                                <?php endforeach; ?>
                            </aside>
                        <?php endif; ?>
                    </div>
                </article>
            </div>
        </section>
    <?php else: ?>
        <section class="grid_12 push_1 ">
            <div class="title">
                <div class="search-container">
                    <h1>Artiklar</h1>
                    <form id="searchform" name="searchform" method="get">
                        <div class="fieldcontainer">
                            <input type="text" name="search" id="search" class="searchfield" placeholder="Sök.." tabindex="1">
                        </div><!-- @end .fieldcontainer -->
                    </form>
                </div>
            </div>
            <div class="short-articles-container">
                <?php foreach ($articles as $article): ?>
                    <article class="short-article">
                        <header>
                            <h2><?=$article['title']?></h2>
                        </header>

                        <section>
                            <?=substr(strip_tags($article['content']), 0, 300) . '...'?>
                            <p><a href="?article=<?=$article['id']?>">Läs artikel</a></p>
                        </section>
                        <footer>
                            <p><?=$article['author']?></p>
                            <p><?=$article['pubdate']?></p>
                        </footer>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</main><!-- .content -->
<?php include("incl/footer.php"); ?>
