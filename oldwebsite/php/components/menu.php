<div  class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Otwórz lub zamknij menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="#" class="navbar-brand hidden-lg hidden-md hidden-sm visible-xs-inline">Menu</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <?php
            $menu = json_decode(file_get_contents(CONTENT_DIRECTORY_PATH."/menu.json"), true);

            function menuItemToHtml($title, $item) {
                if (is_array($item)) {
                    $out = '<li class="dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $title . ' <span class="caret"></span></a><ul class="dropdown-menu">';
                    foreach ($item as $k => $v) {
                        $out .= menuItemToHtml($k, $v);
                        $out .= "\n";
                    }
                    $out .= "</ul></li>";
                    return $out;
                } else {
                    return '<li><a href="' . str_replace(" ", "-", $item) . '">' . $title . '</a></li>';
                }
            }

            foreach ($menu as $k => $v) {
                echo menuItemToHtml($k, $v);
            }
            ?>
        </ul>
    </div><!--/.nav-collapse -->
</div>