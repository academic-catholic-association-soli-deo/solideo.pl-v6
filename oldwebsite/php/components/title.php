<?php
$title = "";
if ($website['query'] === $website['settings']['home-url']) {
    $title = "Akademickie Stowarzyszenie Katolickie Soli Deo";
    if ($website['paginator']->getCurrentPage() > 1) {
        $title .= " - Strona " . $website['paginator']->getCurrentPage();
    }
} else {
    if (isset($website['title'])) {
        $title = $website['title'] . " — ";
    } else if (count($website['content']) === 1) {
        $post = $website['content'][0]->loadContent(false/* isPreview */); //content is buffered => can be paginated
        $title = $post['title'] . " – ";
    }
    $title .= " ASK Soli Deo";
    if ($website['paginator']->hasPagination()) {
        $title .= " - Strona " . $website['paginator']->getCurrentPage();
    }
}
?>
<title><?php echo $title; ?></title>