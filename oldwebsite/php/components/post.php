<article <?php if ($twoColumnLayout) echo' class="col-md-6 col-xs-12"'; ?> <?php if ($displayGenericStructuredDataMarkup) echo 'itemscope itemtype="http://schema.org/BlogPosting"'; ?>>
    <div class="post-above">
        <?php if ($post['date'] != null): ?>
            <time datetime="<?php echo($post['date']); ?>" <?php if ($displayGenericStructuredDataMarkup) echo 'itemprop="datePublished dateModified"'; ?>><?php echo preg_replace("/ \d\d:\d\d:\d\d/mi", "", $post['date']); ?></time>
        <?php endif; ?>
        <?php if (isset($website['edit-mode']) && $website['edit-mode']) echo("| <a href=\"/editor/#" . str_replace(CONTENT_DIRECTORY . "/", "", $postLoader->getRelativePath()) . "\">editor</a>"); ?>
        <?php if ($displayGenericStructuredDataMarkup): ?>
            | <span itemprop="author publisher" itemscope itemtype="https://schema.org/Organization">
                <span itemprop="name">ASK Soli Deo</span>
                <span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                    <meta itemprop="url" content="https://solideo.pl/img/solideo-logo-833x1000.png">
                    <meta itemprop="width" content="833">
                    <meta itemprop="height" content="1000">
                </span>
            </span>
        <?php endif; ?>
    </div>
    <div class="post <?php if ($website['paginator']->isSinglePage()) echo("post-complete"); ?>">
        <div class="text-container" <?php if ($displayGenericStructuredDataMarkup) echo 'itemprop="articleBody"'; ?>>

            <?php
            if (strpos($post['markdown'], '![') === false && strpos($post['markdown'], '<iframe') === false) { //doesn't contain images
                $patternFiles = glob("img/patterns/*.gif");
                $patternUrl = "/" . $patternFiles[array_rand($patternFiles, 1)];
                echo("<div class=\"image-placeholder\" style=\"background-image: url(" . $patternUrl . ");\"><div></div></div>");
            }
            ?>
            <?php
            $html = $post['html'];
            $html = preg_replace("/(<p>)?<time>(.*)<\/time>(<\/p>)?/mi", "", $html);

            echo $html;
            ?>
            <?php if (!$website['paginator']->isSinglePage()): ?>
                <div class="readmore"><a class="btn btn-solideo btn-sm" href="<?php echo $post['link']; ?>" role="button">Więcej &raquo;</a></div>
            <?php endif; ?>

        </div>
    </div>
</article>