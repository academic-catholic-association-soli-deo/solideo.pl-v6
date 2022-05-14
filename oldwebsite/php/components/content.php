<?php
Profiler::start("content");

$twoColumnLayout = $website['paginator']->isSinglePage() === false;
$isPreview = ($twoColumnLayout == true);

$structuredJsonLdMarkup = null;
$displayGenericStructuredDataMarkup = false;
if($website['paginator']->isSinglePage()) {
    $structuredJsonLdMarkup = $website['paginator']->content[0]->getStructuredDataMarkupJsonLD();
    if($structuredJsonLdMarkup == null) $displayGenericStructuredDataMarkup = true;
}

if ($twoColumnLayout) echo '<div class="container-fluid two-column"><div class="row">'; 

foreach ($website['paginator']->content as $postLoader) {
    $post = $postLoader->loadContent($isPreview);
    require __DIR__ . '/post.php';
}

if($structuredJsonLdMarkup != null) echo $structuredJsonLdMarkup;


if ($twoColumnLayout) echo '</div>';
if ($website['paginator']->hasPagination()) require 'pagination-links.php';
if ($twoColumnLayout) echo '</div>';

Profiler::stop("content");
?>
