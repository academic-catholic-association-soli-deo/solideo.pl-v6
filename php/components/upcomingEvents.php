<style type="text/css">
    .event-strip {
        margin: 6px;
        border-bottom: 1px dashed #ccc;
        margin-bottom: 5px;
        padding-bottom: 5px;
    }
    
    .event-strip a {
        color: #555;
    }

    .event-strip-1 {
        /*background:#f2f2f2;*/
    }
    
    .event-strip-2 {
        /*background:#ebebeb;*/
    }
    
    .event-strip time {
        text-align: right;
        font-size: 0.8em;
        width: 100%;
        background: rgba(255,253,39, 0.7);
        padding: 3px;
    }
</style>
<?php
$mds = $website['content'];
$iDisplayed = 0;
for($i = min(count($mds)-1, 26);$i >= 0 && $iDisplayed < 6;$i--) {
    $lmd = $mds[$i];
    $jsonData = $lmd->getStructuredDataJson();
    if($jsonData != null) {
        $data = json_decode($jsonData, true);
        if($data['@type'] == "Event") {
            $url = (isset($data['url'])? $data['url'] : (isset($data['sameAs'])? $data['sameAs'] : null));
            $timeStamp = (isset($data['startDate'])? strtotime($data['startDate']) : null);
            if($timeStamp != null && is_numeric($timeStamp) && $timeStamp < time()-60*60*24) continue; //don't display events older than a day
            ?>
<div itemscope class="event-strip event-strip-<?php echo ($iDisplayed%2==0? "1" : "2"); ?>">
    <?php echo $lmd->getStructuredDataMarkupJsonLD(); ?>
    <?php if($url != null) echo '<a href="'.$url.'">'; ?>
    <?php if($iDisplayed == 0) echo '<strong>'; ?>
    <?php if(isset($data['name'])) echo'<span>'.$data['name'].'</span>'; ?>
    <?php if($iDisplayed == 0) echo '</strong>'; ?>
    <?php if($url != null) echo '</a>'; ?>
    <?php if(isset($data['startDate'])) echo' <time datetime="'.$data['startDate'].'">'.date('d.m.Y', $timeStamp).'</time> '; ?>
</div>
            <?php
            $iDisplayed++;
        }
    }
}