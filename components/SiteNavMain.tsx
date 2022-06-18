import React from 'react'

export function SiteNavMain() {
  return <nav id="menu-main">
    <div className="container">
      <div className="navbar-header">
        <button type="button" className="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span className="sr-only">Otwórz lub zamknij menu</span>
          <span className="icon-bar"></span>
          <span className="icon-bar"></span>
          <span className="icon-bar"></span>
        </button>
        <a href="#" className="navbar-brand hidden-lg hidden-md hidden-sm visible-xs-inline">Menu</a>
      </div>
      <div id="navbar" className="navbar-collapse collapse">
        <ul className="nav navbar-nav">
          {`<?php
          $menu = json_decode(file_get_contents(CONTENT_DIRECTORY_PATH."/menu.json"), true);

          function menuItemToHtml($title, $item) {
                if (is_array($item)) {
            $out = '<li className="dropdown"><a href="javascript:void(0);" className="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$title. ' <span className="caret"></span></a><ul className="dropdown-menu">';
                    foreach ($item as $k => $v) {
            $out.= menuItemToHtml($k, $v);
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
            ?>`}
        </ul>
      </div>
    </div >
  </nav >
}
