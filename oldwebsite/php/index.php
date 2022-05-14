<?php
defined('SOLI_DEO') || die();

require_once(__DIR__.'/lib/Profiler.php');
require_once(__DIR__.'/lib/CacheManager.php');
require_once(__DIR__.'/lib/CachedFilesystem.php');



require __DIR__.'/old-website-redirects.php';

Profiler::setEnabled(isset($_GET['profiler']));

Profiler::start("total");

include(__DIR__.'/loader.php');
$loaderTime = microtime(true);
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <?php include('components/head.php'); ?>
    </head>
    <body>
        <header>
            <?php include('components/header.php'); ?>
        </header>
        <nav id="menu-main">
            <?php include('components/menu.php'); ?>
        </nav>
        <div id="menu-bottom">
            <div id="social-icons-mobile" class="visible-xs-block">
                <?php echo file_get_contents(CONTENT_DIRECTORY_PATH.'/social-icons.html'); ?>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <main class="col-sm-9 col-xs-12" id="content">
                    <?php include('components/content.php'); ?>
                </main>
                <aside class="col-sm-3 col-xs-12" id="sidebar">
                    <?php include('components/sidebar.php'); ?>
                </aside>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <?php include ('components/footer.php'); ?>
                </div>
            </div>
        </footer>
    </body>
    <?php
    Profiler::stop("total");
    echo "<!--\n".Profiler::getPrintableResults()."\n-->\n";
    ?>
</html>