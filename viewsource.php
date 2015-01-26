<?php 
include("incl/config.php");

$title = "Granska källkod";
$pageId = "source";

// Include code from source.php to display sourcecode-viewer
$sourceBasedir=dirname(__FILE__);
$sourceNoEcho=true;
include("src/source.php");
$pageStyle=$sourceStyle;
?>


<?php include("incl/header.php"); ?>

    <main class="main-container grid_12">
        <?php echo "$sourceBody"; ?>
    </main><!-- .content -->
<?php include("incl/footer.php"); ?>