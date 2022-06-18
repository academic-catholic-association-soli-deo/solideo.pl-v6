import React from 'react'

export function SiteBody({ main, sidebar }: { main: React.ReactNode, sidebar: React.ReactNode }) {
  return <div className="container">
    <div className="row">
      <main className="col-sm-9 col-xs-12" id="content">
        {main}
      </main>
      <aside className="col-sm-3 col-xs-12" id="sidebar">
        {sidebar}
      </aside>
    </div>
  </div>
}
