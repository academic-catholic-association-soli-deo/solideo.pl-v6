<?php

require_once __DIR__ . '/../vendor/Parsedown.php';

/*
 * Ta klasa reprezentuje dokument markdown (podstronę), którą można załadować. 
 * Dzięki temu foldery zawierające setki podstron ładowane są szybciej. Najpierw
 * tworzone są wszystkie LoadableMd, ale ich zawartość jest przetwarzana dopiero,
 * gdy components/content.php decyduje, że dany element ma być wyświetlony (np. 
 * wyświetlane są  tylko elementy z jednej strony paginacyjnej).
 */

class LoadableMd {

    private static $cacheSecret = "i84adehue";
    private $mdPath;
    private $relativeDir;
    private $settings;
    private $previewContent = null;
    private $fullContent = null;
    private $structuredData = null;

    function __construct($mdPath_, $relativeDir_, $settings_) {
        $this->mdPath = $mdPath_;
        $this->relativeDir = $relativeDir_;
        $this->settings = $settings_;

        //if (isset($_GET['cached'])) {
            $dataLoadedFromCache = CacheManager::getMyCache($this->mdPath, self::$cacheSecret, 3600*2, 10000);
            if ($dataLoadedFromCache !== null) {
                //echo("<!-- " . $this->mdPath . " loaded from cache...-->\n");
                if (isset($dataLoadedFromCache['fullContent']))
                    $this->fullContent = $dataLoadedFromCache['fullContent'];
                if (isset($dataLoadedFromCache['previewContent']))
                    $this->previewContent = $dataLoadedFromCache['previewContent'];
                if (isset($dataLoadedFromCache['structuredData']))
                    $this->structuredData = $dataLoadedFromCache['structuredData'];
            }
        //}
        //echo("<!-- mdPath=$mdPath_ -->\n\n");
    }

    public function loadContent($isPreview) {
        if ($isPreview && $this->previewContent !== null)
            return $this->previewContent;
        else if ($this->fullContent !== null)
            return $this->fullContent;

        $this->previewContent = $this->_parseMdFile(file_get_contents($this->mdPath), true);
        $this->fullContent = $this->_parseMdFile(file_get_contents($this->mdPath), true);
        $this->getStructuredDataJson();

        //if (isset($_GET['cached'])) {
            $dataForCache = array("previewContent" => $this->previewContent, "fullContent" => $this->fullContent, "structuredData" => $this->structuredData);
            CacheManager::setMyCache($this->mdPath, self::$cacheSecret, $dataForCache);
            if (isset($_GET['cacheDebug']))
                echo("<!--Written " . $this->mdPath . " to cache-->\n");
        //}

        if ($isPreview && $this->previewContent !== null)
            return $this->previewContent;
        else if ($this->fullContent !== null)
            return $this->fullContent;
    }

    private function _parseMdFile($fileContents, $isPreview) {
        $parsedown = new Parsedown();

        $title = $this->_parseTitle($fileContents);

        $markdownEntities = $this->_processEntities($fileContents);
        ;
        $markdownParsedDirs = str_ireplace("_dir_", "/" . implode('/', array_map('rawurlencode', explode('/', $this->relativeDir))), $markdownEntities);
        $markdownWithoutImages = $this->_parseIframes($this->_parseImages($markdownParsedDirs, $isPreview), $isPreview);

        $html = $parsedown->text($markdownWithoutImages);

        $link = "/" . Urlizer::pathToUrl(str_replace(CONTENT_DIRECTORY . "/", '', $this->relativeDir));
        $html = str_ireplace("<h1>", ($isPreview ? "<h2>" : "<h1 itemprop=\"headline\">") . "<a itemprop=\"mainEntityOfPage\" href=" . $link . ">", $html);
        $html = str_ireplace("</h1>", "</a>" . ($isPreview ? "</h2>" : "</h1>"), $html);

        $html = $this->protectEmailAddresses($html);

        $date = $this->getPostDate($fileContents);

        return array('markdown' => $fileContents, 'html' => $html, 'title' => $title, 'link' => $link, 'date' => $date);
    }

    private function _processEntities($markdown) {
        preg_match_all("/<[^>]+>/Uium", $markdown, $tags); //protect quotes in tags
        foreach ($tags[0] as $tag) {
            $tagWithoutQuotes = str_replace("\"", "[q-w-h]", $tag);
            $markdown = str_replace($tag, $tagWithoutQuotes, $markdown);
        }

        $markdown = str_replace("\\\"", "[q-w-h]", $markdown);
        $markdown = strtr($markdown, array(
            '"' => "&quot;",
            '“' => "&ldquo;",
            '”' => '&rdquo;',
            '„' => '&bdquo;',
            '„' => '&bdquo;'
        ));
        $markdown = str_replace("[q-w-h]", "", $markdown);
        return $markdown;
    }

    private function _parseImages($markdown, $isPreview) {
        $out = $markdown;

        $stripImagesExceptFirst = $isPreview;

        $res = array();
        preg_match_all("/!\[([^\]]+)\]\(([^\)]+)\)/i", $markdown, $res);
        for ($i = 0; $i < count($res[0]); $i++) {
            $matcher = $res[0][$i];
            $altUnsplitted = explode("||", $res[1][$i], 2);
            $alt = $altUnsplitted[0];
            $htmlParams = (count($altUnsplitted) > 1 ? $altUnsplitted[1] : "");

            $urlNonencoded = "/" . $this->relativeDir . "/" . $res[2][$i];
            $url = implode('/', array_map('rawurlencode', explode('/', $urlNonencoded)));

            $imageHtml = "";
            if (!$stripImagesExceptFirst || ($stripImagesExceptFirst && $i < 1)) {
                if ($this->settings['lazy-image-loading']) {
                    $imageHtml = "<div class=\"img-container\" itemprop=\"image\" itemscope itemtype=\"https://schema.org/ImageObject\">"
                            . "<noscript><img src=\"" . $url . "\" alt=\"" . $alt . "\" title=\"" . $alt . "\" $htmlParams/></noscript>"
                            . '<img data-src="' . $url . '" alt="' . $alt . '" title="' . $alt . '" class="b-lazy" src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== $htmlParams/>'
                            . '<meta itemprop="url" content="' . $url . '">'
                            . "</div>";
                } else {
                    $imageHtml = "<div class=\"img-container\" itemprop=\"image\" itemscope itemtype=\"https://schema.org/ImageObject\">"
                            . "<img src=\"" . $url . "\" alt=\"" . $alt . "\" title=\"" . $alt . "\" $htmlParams/>"
                            . '<meta itemprop="url" content="https://' . $_SERVER['HTTP_HOST'] . '/' . $url . '">'
                            . "</div>";
                }
            }

            $out = str_replace($matcher, $imageHtml, $out);
        }


        return $out;
    }

    private function _parseIframes($md, $isPreview) {
        preg_match_all("/<iframe([^>]+)>[^<]*<\\/iframe>/", $md, $iframes);

        $i = 0;
        foreach ($iframes[0] as $iframe) {
            $replacer = "";
            preg_match_all("/src=\"([^\"]+)\"/mUi", $iframe, $srcs);
            if (count($srcs[1] > 0) && (!$isPreview || ($isPreview && $i < 1))) {
                $iframeWithoutSize = preg_replace("/width=\"[^\"]+\"/mUi", "", $iframe);
                $iframeWithoutSize = preg_replace("/height=\"[^\"]+\"/mUi", "", $iframeWithoutSize);
                $replacer = "<div class=\"iframe-container\">" . $iframeWithoutSize . "</div>";
            }
            $md = str_replace($iframe, $replacer, $md);
            $i++;
        }
        return $md;
    }

    private function _parseTitle($md) {
        $headers = array();
        preg_match_all("/^#(.*)$/mi", $md, $headers);
        if (!empty($headers[1][0])) {
            return ucfirst(trim($headers[1][0]));
        } else {
            $lines = explode("\n", $md, 2);
            return $lines[0];
        }
    }

    private function protectEmailAddresses($content) {
        preg_match_all("/([a-z\d._%+-]+)@([a-z\d.-]+)\.([a-z]{2,6})\b/i", $content, $result);
        for ($i = 0; $i < count($result[0]); $i++) {
            $encrypted = base64_encode($result[0][$i]);
            $replacer = '<span data-enc="' . $encrypted . '" class="addr-protection">[Ochrona antyspamowa adresów e-mail. Włącz javascript, aby zobaczyć adres]</span>';
            $content = str_replace($result[0][$i], $replacer, $content);
        }
        return $content;
    }

    private function getPostDate($content) {
        $date = null;

        preg_match_all("/<time>(.*)<\/time>/mi", $content, $times);
        if (count($times[1]) > 0) {
            $date = $times[1][0];
        }
        return $date;
    }

    public function getRelativePath() {
        return $this->relativeDir;
    }

    public function getStructuredDataJson() {
        if ($this->structuredData != null)
            return $this->structuredData;

        $jsonLdPath = dirname($this->mdPath) . "/structured-data.json";
        if (file_exists($jsonLdPath) && is_readable($jsonLdPath)) {
            $out = "";
            $jsonLd = file_get_contents($jsonLdPath);

            $link = "/" . Urlizer::pathToUrl(str_replace(CONTENT_DIRECTORY . "/", '', $this->relativeDir));
            $jsonLd = str_ireplace("_link_", "https://" . $_SERVER['HTTP_HOST'] . $link, $jsonLd);
            $jsonLd = str_ireplace("_dir_", "https://" . $_SERVER['HTTP_HOST'] . "/" . implode('/', array_map('rawurlencode', explode('/', $this->relativeDir))), $jsonLd);

            $this->structuredData = $jsonLd;
            $out .= $jsonLd;
            $out .= "";
            return $out;
        } else {
            return null;
        }
    }

    public function getStructuredDataMarkupJsonLD() {
        if ($this->structuredData != null)
            return "<script type=\"application/ld+json\">\n" . $this->structuredData . "\n</script>\n";
        $jsonLdPath = dirname($this->mdPath) . "/structured-data.json";
        if (file_exists($jsonLdPath) && is_readable($jsonLdPath)) {
            $out = "<script type=\"application/ld+json\">\n";
            $out .= $this->getStructuredDataJson();
            $out .= "\n</script>\n";
            return $out;
        } else {
            return null;
        }
    }

}
