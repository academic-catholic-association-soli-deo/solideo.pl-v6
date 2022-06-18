import React from 'react'

export function SiteNavSocial() {
  return <div id="menu-bottom">
    <div id="social-icons-mobile" className="visible-xs-block">
      php echo file_get_contents(CONTENT_DIRECTORY_PATH.'/social-icons.html');
    </div>
  </div>
}
