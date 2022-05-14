<a href="/" id="header-triptych">
    <img class="triptych-center" src="/img/asksolideo-logo-320x384.png" alt="Logo ASK Soli Deo" />
    <h1>Soli Deo</h1>

    <h2 class="triptych-left">
        <span>Akademickie</span>
        <span style="font-size: 78.4%;">Stowarzyszenie</span>
        <span style="font-size: 110%; letter-spacing: 0.075em;">Katolickie</span>
    </h2>

    <h3 class="triptych-right">
        <img src="/img/czas-to-milosc.png" alt="Czas to miłość" />
    </h3>
</a>

<div id="social-icons" class="hidden-xs">
    <?php echo file_get_contents(CONTENT_DIRECTORY_PATH . '/social-icons.html'); ?>
</div>

<div id="way-left">&nbsp;</div>


<div id="members-img">
    <?php
    $dirIterator = new DirectoryIterator(CONTENT_DIRECTORY_PATH."/header-foto/");
    $imgs = array();
    foreach($dirIterator as $node) {
        if(!$node->isDir() && !$node->isDot() && $node->getFilename()[0] != '_' && $node->isReadable() && $node->getExtension() == "jpg") {
            $imgs[] =  $node->getFilename();
        }
    }
    
    $intervalS = 60*30;//change every 30 minutes
    
    $loadedI = false;
    if(isset($_GET['header_i'])) $loadedI = filter_input(INPUT_GET, 'header_i', FILTER_VALIDATE_INT, array('options'=>array('min_range' => 0, 'max_rande' => count($imgs)-1)));
    
    $i = ($loadedI !== false? $loadedI : ((int)floor(time()/$intervalS))%count($imgs));
    //echo '<!-- floor(time()/$intervalS))='.((double)time()/(double)$intervalS).' count($imgs)='.count($imgs).', $i='.$i.' -->';
    echo '<img src="/'.CONTENT_DIRECTORY."/header-foto/".$imgs[$i].'" alt="Zdjęcie członków stowarzyszenia ('.$i.')"/>';
    ?>
    
    <div class="shadow"></div>
</div>

