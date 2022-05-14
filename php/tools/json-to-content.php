<?php
exit; //disable

if (PHP_SAPI != "cli")
    exit;

function startsWith($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle) {
    $length = strlen($needle);

    return $length === 0 ||
            (substr($haystack, -$length) === $needle);
}

/* echo "\n\n\n# idjxp_content\n";
  print_r($content->idjxp_content[0]);

  echo "\n\n\n# jom_content\n";
  print_r($content->jom_content[0]);

  echo "\n\n\n# jos_content\n";
  print_r($content->jos_content[0]);
 */

if (!file_exists("tmp-Strona")) {
    mkdir("tmp-Strona");
}

$out = array();
$posts = array();
$numOfPosts = 0;
$numOfErrors = 0;

//processContent($out, $content->jos_content, "jos");
//processContent($out, $content->jom_content, "jom");
processContent($out, json_decode(file_get_contents("jos_content.json")), "jos");
processContent($out, json_decode(file_get_contents("jom_content.json")), "jom");

function processContent(&$out, $joomlaObj, $srcname) {
    global $posts, $numOfPosts, $numOfErrors;

    foreach ($joomlaObj as &$post) {
        $id = $post->id;

        /* $foundDuplicate = false;
          foreach ($posts as $comparedPost) {
          if ($comparedPost['id'] == $post->id)
          $foundDuplicate = true;
          }
          if ($foundDuplicate)
          break; */
        $numOfPosts++;

        $content = $post->introtext;
        if (strlen(trim($post->fulltext)) > 0)
            $content .= "\n<!--{{intro-break}}-->\n" . $post->fulltext;
        $content = Normalizer::normalize($content);
        $content = str_replace("\\", "", $content);
        $content = str_ireplace("'\"", "\"", $content);
        $content = str_ireplace("\"'", "\"", $content);
        $content = str_ireplace("\"'\"\"", "\"", $content);
        $content = str_ireplace("\"\"'\"", "\"", $content);
        $content = preg_replace("/\"mailto:[^\"']+[\"']/mUi", "\"\"", $content);
        $content = str_ireplace(" style=\"\"", "", $content);
        $content = preg_replace("/<!--\[if gte mso 9\]>[\s\S\n]*<!\[endif\]-->/mUi", "", $content);
        $content = preg_replace("/<!--\[if gte mso 20\]>[\s\S\n]*<!\[endif\]-->/mUi", "", $content);
        $content = preg_replace("/<style>[\s\S\n]*<\/style>/mUi", "", $content);
        $content = preg_replace("/<\/?span[^>]*>/mUi", "", $content);
        $content = preg_replace("/<\/?\n?span[^>]*>/mUi", "", $content);
        $content = preg_replace("/<\/?p[^>]*>/mUi", "\n", $content);
        $content = preg_replace("/\\s?style=\"[^\"]+\"/mUi", "", $content);
        $content = preg_replace("/<\/?\n?font[^>]*>/mUi", "", $content);
        $content = preg_replace("/<\/?div[^>]*>/mUi", "", $content);
        $content = preg_replace("/<\/?br[^>]*>/mUi", "\n", $content);
        $content = str_ireplace("<b>", "**", $content);
        $content = str_ireplace("</b>", "**", $content);
        $content = str_ireplace("<strong>", "**", $content);
        $content = str_ireplace("</strong>", "**", $content);
        $content = str_ireplace("<i>", "*", $content);
        $content = str_ireplace("</i>", "*", $content);
        $content = str_ireplace("<em>", "*", $content);
        $content = str_ireplace("</em>", "*", $content);
        $content = str_ireplace("<u>", "*", $content);
        $content = str_ireplace("</u>", "*", $content);
        $content = str_ireplace("&quot;", "\"", $content);
        $content = str_ireplace("&amp;", "&", $content);
        $content = preg_replace("/<\/?div>/mUi", "", $content);
        $content = preg_replace("/<h1[^>]*>/mUi", "\n# ", $content);
        $content = str_ireplace("</h1>", "", $content);
        $content = preg_replace("/<h2[^>]*>/mUi", "\n# ", $content);
        $content = str_ireplace("</h2>", "", $content);
        $content = preg_replace("/<h3[^>]*>/mUi", "\n# ", $content);
        $content = str_ireplace("</h3>", "", $content);
        $content = preg_replace("/<h4[^>]*>/mUi", "\n# ", $content);
        $content = str_ireplace("</h4>", "", $content);
        $content = preg_replace("/<h5[^>]*>/mUi", "\n# ", $content);
        $content = str_ireplace("</h5>", "", $content);
        $content = preg_replace("/<h6[^>]*>/mUi", "\n# ", $content);
        $content = str_ireplace("</h6>", "", $content);
        $content = str_ireplace("<hr/>", "***\n", $content);
        $content = str_ireplace("<hr />", "***\n", $content);
        $content = str_ireplace("<o:p>", "", $content);
        $content = str_ireplace("</o:p>", "", $content);
        $content = str_ireplace("<\nstrong>", "", $content);
        $content = str_ireplace("<\nspan>", "", $content);
        $content = str_ireplace("<\nfont>", "", $content);
        $content = str_ireplace("<\nbr>", "\n", $content);
        $content = str_ireplace("<wbr>", "", $content);
        $content = str_ireplace("%5C%22%5C%22", "", $content);

        $content = str_ireplace("<UL type=disc>", "<ul>", $content);
        $content = str_ireplace("<blockquote class=\"gmail_quote\">", "<blockquote>", $content);
        $content = str_ireplace("</ />", "", $content);
        $content = str_ireplace("</siv>", "", $content);
        $content = str_ireplace("</idv>", "", $content);
        $content = str_ireplace('<?xml:namespace prefix = o ns = "urn:schemas-microsoft-com:office:office" />', "", $content);
        $content = str_ireplace('<A href="" ??? mailto:prezes@solideo.pl???>', "", $content);
        $content = str_ireplace('<BCHÓR b II< Pawła Jana Myśli Centrum>', "BCHÓR b II Pawła Jana Myśli Centrum", $content);
        $content = str_ireplace('<strong underline;="""">', "**", $content);
        $content = str_ireplace('<Bmso-bidi-font-weight: " normal?>', "**", $content);
        $content = str_ireplace('<a onclick="pobierz(\'http://pliki.solideo.pl/mp3/Czy_Jezus_byl_grzecznym_chlopcem-Ks.Piotr_Pawlukiewicz.mp3\');">', "<a href=\"http://pliki.solideo.pl/mp3/Czy_Jezus_byl_grzecznym_chlopcem-Ks.Piotr_Pawlukiewicz.mp3\" />", $content);
        $content = str_ireplace('<ol type="I">', "<ol>", $content);
        $content = str_ireplace('<center>', "", $content);
        $content = str_ireplace('</center>', "", $content);
        $content = str_ireplace('</wbr>', "", $content);
        $content = str_ireplace('<address>', "<blockquote>", $content);
        $content = str_ireplace('</address>', "</blockquote>", $content);
        $content = str_ireplace('<li value="5">', "<li>", $content);
        $content = preg_replace("/<skype:span [^>]*>[\s\S\n]*<\/skype:span>/mUi", "", $content);
        $content = str_ireplace('<strong class="niebieski-9">', "**", $content);
        $content = str_ireplace('<\np>', "", $content);
        $content = str_ireplace('<\np align="center">', "", $content);
        $content = str_ireplace('<li class=MsoNormal>', "<li>", $content);
        $content = str_ireplace('<LI class=MsoNormal ?="" 36.0pt?="" 0cm="" 0pt;="" mso-list:="" l0="" level1="" lfo1;="" tab-stops:="" list="" margin:="">', "<li>", $content);
        $content = str_ireplace('<UL type=disc ?="" 0cm?="" margin-top:="">', "<ul>", $content);
        $content = str_ireplace('<BLOCKQUOTE dir=ltr>', "<blockquote>", $content);
        $content = str_ireplace('<?xml:namespace prefix = o ns = ""urn:schemas-microsoft-com:office:office"" />', "", $content);
        $content = str_ireplace('</skype:span></skype:span>', "", $content);
        $content = str_ireplace('</\nfont>', "", $content);
        $content = str_ireplace('</\nspan>', "", $content);
        $content = str_ireplace('<LI class=MsoNormal>', "<li>", $content);
        $content = str_ireplace('<\nu>', "*", $content);
        $content = str_ireplace('</\nstrong>', "", $content);
        $content = str_ireplace('<\n/p>', "\n", $content);
        $content = str_ireplace('<\np times="" new="" roman;="">', "", $content);
        $content = str_ireplace('<p\nalign="center">', "", $content);
        $content = str_ireplace('<A href=\'"mailto:pierwsza.pomoc@nzs.-uw.pl"\'>', "<A href=\"mailto:pierwsza.pomoc@nzs.-uw.pl\">", $content);
        $content = str_ireplace('', "", $content);
        $content = str_ireplace('', "", $content);
        $content = str_ireplace('', "", $content);

        $content = parseImages($content);
        $content = parseLinks($content);
        $content = str_ireplace("<a>", "", $content);
        $content = str_ireplace("</a>", "", $content);

        $content = str_replace("\n\n\n", "\n", $content);


        $leftTags;
        preg_match_all("/<[^!^>]+>/mU", $content, $leftTags);
        foreach ($leftTags[0] as $i => &$tag) {
            if (in_array(strtolower($tag), array("<li>", "</li>", "<ul>", "</ul>", "<ol>", "</ol>", "<blockquote>", "</blockquote>", "<cite>", "</cite>", "<sup>", "</sup>", "<youtube>", "</youtube>"))) {
                unset($leftTags[0][$i]);
            }
        }

        if (count($leftTags[0]) > 0) {
            //echo "\n\n\n\n#############\n".$content.":\n";
            foreach ($leftTags[0] as &$tag) {
                //echo(">>> '".$tag."'\n");

                $content = str_replace($tag, "<!--{{error-tag:'" . $tag . "'}}-->", $content);

                $numOfErrors++;
            }
            //echo("\n\n");
        }

        $postParsed = array(
            "content" => $content,
            "source" => $srcname,
            "title" => $post->title,
            "publish_down" => $post->publish_down,
            "created" => $post->created,
            'id' => $post->id,
            "original_introtext" => $post->introtext,
            "original_fulltext" => $post->fulltext
        );

        $posts[] = $postParsed;
    }
}

echo("Syntax errors=" . $numOfErrors . "\n");

/* $countOfLenghtyPosts = 0;
  $i = 0;
  foreach($byId as $id => $elems) {
  foreach($elems as $post) {
  if(strlen($post['content']) > 25000) {
  print_r($post);
  echo("\nlen=".strlen($post['content'])."\n\n\n\n\n");
  $countOfLenghtyPosts++;
  }
  }
  $i++;
  }

  echo("conte of lenghty posts: ".$countOfLenghtyPosts."\n");
 */

/*
  function parseLists($in) {
  preg_match_all("/<(uo)l>([\s\S]*)<\/[uo]l>/mUi", $in, $res);
  if(count($res[0]) > 0) {
  echo $in."\n\n\n\n#############\n\n\n";
  }
  for($i = 0;$i < count($res[0]);$i++) {
  $whole = $res[0][$i];
  $listType = $res[1][$i];
  $content = $res[2][$i];

  $replacer = "";

  preg_match_all("<li>([\s\S]*)<\/li>/mUi", $whole, $lis);
  if(count($lis[0]) > 0) {
  foreach($lis as $ii => $li) {

  }

  $in = str_replace($whole, $replacer, $in);
  }
  }
  return $in;
  } */

function parseImages($in) {
    preg_match_all("/(<img[^>]+>)/mUi", $in, $res);
    foreach ($res[0] as &$match) {
        preg_match_all("/alt=\"([^\"]+)\"/mUi", $match, $alts);
        preg_match_all("/src=\"([^\"]+)\"/mUi", $match, $srcs);

        if (count($srcs[1]) > 0) {
            $alt = str_replace("]", "", str_replace("[", "", count($alts[1]) > 0 ? $alts[1][0] : $srcs[1][0]));
            $in = str_replace($match, "\n![" . $alt . "](" . $srcs[1][0] . ")", $in);
        } else
            echo("! image without src: res=" . print_r($res, true) . ";;; srcs=" . print_r($srcs, true) . "\n");
    }
    return $in;
}

function parseLinks($in) {
    //echo $in."\n\n\n\n#############\n\n\n";
    preg_match_all("/<a[^>]*>([^<]*)<\/a>/mUi", $in, $res);
    for ($i = 0; $i < count($res[0]); $i++) {
        $whole = $res[0][$i];
        $content = $res[1][$i];

        preg_match_all("/href=\"([^\"]+)\"/mUi", $whole, $hrefs);
        if (count($hrefs[1]) > 0) {
            $replacer = "";
            $lines = explode("\n", $content);
            foreach ($lines as $ii => $line) {
                $replacer .= "[" . $line . "](" . $hrefs[1][0] . ")";
                if ($ii < count($lines) - 1)
                    $replacer .= "\n";
            }

            $in = str_replace($whole, $replacer, $in);
        } else
            $in = str_replace($whole, $content, $in);
    }
    return $in;
}

/**
 * Find duplicate posts
 */
/*
  $i = 0;
  $numOfDiffs = 0;
  foreach($byId as $id => $elems) {
  if(count($elems) > 1) {
  $match = true;
  $percentDiff = 0;
  $content = str_replace("\r", "", str_replace("\n", "", $elems[0]['content']));
  //echo "<<".$id.">>\n";
  foreach($elems as $post) {
  $myContent = str_replace("\r", "", str_replace("\n", "", $post['content']));
  $charsDif = similar_text($myContent, $content, $percentDiff);
  //if($post['content'] != $content) $match = false;
  if($percentDiff < 80) {
  $match = false;
  echo ($percentDiff)."% (".$charsDif." chars)\n";
  }
  $i++;
  }
  if(!$match) {
  echo("\n\n\n\n\n>>>>>>>>>\n\n");
  echo("id=".$id.", numPosts=".count($elems).". they don't match\n");
  print_r($elems);
  $numOfDiffs++;
  }
  }
  $percent = ($i/$numOfPosts)*100;
  if($i % ($numOfPosts/20) == 0) echo("Progress: ".$percent."%\n");
  }
  echo("num of diffs: ".$numOfDiffs."\n\n");
 * */ //Every content is matching



/**
 * Find posts with publish down date
 */
/* foreach($byId as $postVariants) {
  foreach($postVariants as $post) {
  if($post['publish_down'] != "0000-00-00 00:00:00") {
  echo("\n\n\n\n\n\n###############\n");
  print_r($post);
  }
  }
  } */


/**
 * Find posts with different creation date
 */
foreach ($posts as $key => &$post) {
    preg_match_all("/^([^|^\n]+)\\|/U", $post['content'], $res);
    if (count($res[1]) > 0) {
        $post['text-date'] = trim($res[1][0]);
        if (strpos($post['text-date'], 'Dziś') !== false)
            $post['text-date'] .= (" (data umieszczenia na nowej stronie: " . $post['created'] . ")");
        //echo("\n\n\n\n\n\n###############\n");
        print_r($posts[$key]);
    }
}


/*
  //look for duplicates


 */
/*
  for ($i = 0; $i < count($posts); $i++) {
  $post = $posts[$i];
  $myContent = str_replace("\n", "", str_replace("\r", "", $post['content']));
  for ($ii = 0; $ii < $i; $ii++) {
  $comparedPost = $posts[$ii];
  $comparedContent = str_replace("\n", "", str_replace("\r", "", $comparedPost['content']));
  similar_text($myContent, $comparedContent, $percentSimilar);
  if ($percentSimilar > 50) {
  echo("\n########## Warning! similar posts: (similarity=" . $percentSimilar . "%)!\n");
  print_r($comparedPost);
  echo("\n---\n");
  print_r($post);
  echo("\n\n\n\n\n");
  }
  //print_r($comparedPost);
  //echo("\n---\n");
  //print_r($post);
  }
  echo("progress=" . ($i / count($posts) * 100) . "%\n");
  }
 */

/**
 * Old posts are present with date 2013.05.08
 */
foreach ($posts as $keyI => &$post) {
    $parsedDateinfo = date_parse_from_format("Y-m-d H:i:s", $post['created']);
    if ($parsedDateinfo['year'] == 2013 && $parsedDateinfo['month'] == 5 && $parsedDateinfo['day'] == 8) {
        $title = strtolower(trim(titleToFilename($post['title'])));
        foreach ($posts as $iOld => &$postOld) {
            $parsedDateinfoOfOldPost = date_parse_from_format("Y-m-d H:i:s", $postOld['created']);
            if ($post['created'] != $postOld['created']) {
                $titleOld = strtolower(trim(titleToFilename($postOld['title'])));
                if ($title == $titleOld) {
                    if(isset($post['text-date'])) {
                        preg_match_all("/(20\d\d)/mUi", $post['text-date'], $years);
                        if(count($years[1]) > 0) {
                            $yearInTextDateInNewPost = $years[1][0];
                            if($parsedDateinfoOfOldPost['year'] != $yearInTextDateInNewPost) {
                                echo("!     ! Found fake title match: ".$title.". year in text-date: ".$yearInTextDateInNewPost.", year of oldpost: ".$parsedDateinfoOfOldPost['year']."\n");
                                continue;
                            }
                        }
                    }
                    $postOld['content'] = $post['content'] . "\n\n<!--CONTENT FROM OLD SERVER (jos before 2013): " . $postOld['content'] . "\n-->";
                    $postOld['after-2013-move'] = $post;
                    unset($posts[$keyI]);
                    echo("Joined " . $title . ": " . $postOld['created'] . "\n");
                    break;
                }
            }
        }
    }
}

echo("\n\n#### CREATING FILE STRUCTURE...\n");
/*
 * Create file structure
 */
$unsatisfiedLinks = array();
foreach ($posts as &$post) {
    $parsed = date_parse_from_format("Y-m-d H:i:s", $post['created']);
    $timestamp = mktime(
            $parsed['hour'], $parsed['minute'], $parsed['second'], $parsed['month'], $parsed['day'], $parsed['year']
    );
    $year = date('Y', $timestamp);
    $title = normalizer_normalize($post['title']);
    $titleFilenamed = titleToFilename($title);
    $filename = "[" . date("Y.m.d", $timestamp) . "] " . $titleFilenamed;
    $dir = "./tmp-Strona/" . $year . "/" . $filename . "";
    //echo($filename . "\n");
    $i = 2;
    while (file_exists($dir)) {
        $dir = str_replace("_" . ($i - 1), "", $dir);
        $dir .= " _" . $i;
        $i++;
    }
    mkdir($dir, 0777, true);

    file_put_contents($dir . "/import-data.json", json_encode($post));

    $content = "<!--{{json:" . json_encode(array("created_date" => $post['created'], "publish_down" => $post['publish_down'], "id" => $post['id'])) . "}}-->\n";
    $content .= "# " . $post['title'] . "\n\n";
    $content .= "<time>" . (isset($post['text-date']) ? $post['text-date'] : $post['created']) . "</time>\n\n";
    $content .= $post['content'];
    file_put_contents($dir . "/" . $filename . ".txt", $content);

    preg_match_all("/\]\(([^)]+)\)/mi", $content, $urls);
    $urls = $urls[1];
    $urls = array_unique($urls);
    foreach ($urls as &$url) {
        if (startsWith($url, "images/stories")) {
            //they don't exist
        } else {
            $pathinfo = pathinfo(urldecode($url));
            if (endsWith(strtolower($url), ".jpeg") || endsWith(strtolower($url), ".jpg") || endsWith(strtolower($url), ".png") || endsWith(strtolower($url), ".gif")) {
                $imgfilename = $pathinfo['basename'];
                $downloadUrl = (startsWith($url, "http") ? $url : "http://solideo.pl/" . $url);
                echo("Downloading $downloadUrl to $dir... ");
                $downloaded = @file_get_contents($downloadUrl);
                if ($downloaded) {
                    file_put_contents($dir . "/" . $imgfilename, $downloaded);
                    $content = str_replace($url, $imgfilename, $content);
                    file_put_contents($dir . "/" . $filename . ".txt", $content);
                    echo("Done! **********************\n");
                } else
                    echo("Failed\n");
            }
            else if (startsWith($url, "http")) {
                //do not check now
            } else
                $unsatisfiedLinks[] = $url;
        }
    }
}
print_r($unsatisfiedLinks);
echo("\n\n-----\nnum of posts = " . count($posts) . "\n");

function titleToFilename($title) {
    $title = normalizer_normalize($title);
    $title = str_replace("\"", "", str_replace("[/red]", "", str_replace("[red]", "", str_replace("\\", "-", str_replace("/", "-", $title)))));
    $title = str_replace("[/br]", "", str_replace("[br]", "", $title));
    $title = str_replace("[/u]", "", str_replace("[u]", "", $title));
    $title = str_replace("[/i]", "", str_replace("[i]", "", $title));
    $title = str_replace("[", "(", str_replace("]", ")", $title));
    $title = str_replace(array("!", "?", ">", "<", ".", ",", "/", "\\", "+", "=", "|", ":", ";", "'", "@", "#", "$", "%", "^", "&", "*", "£", "§", "~", "`"), "-", $title);
    return $title;
}
