import React, { ReactNode } from 'react'
import { SiteBody } from './SiteBody.jsx'
import { SiteFooter } from './SiteFooter.jsx'
import { SiteHeader } from './SiteHeader.jsx'
import { SiteNavMain } from './SiteNavMain.jsx'
import { SiteNavSocial } from './SiteNavSocial.jsx'
import { SiteSidebar } from './SiteSidebar.jsx'

export function Layout({ children }: { children: ReactNode }) {
  return (
    <React.StrictMode>
      <SiteHeader />
      <SiteNavMain />
      <SiteNavSocial />
      <SiteBody main={children} sidebar={<SiteSidebar />} />
      <SiteFooter />
    </React.StrictMode>
  )
}
