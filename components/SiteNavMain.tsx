import React from 'react'

export function SiteNavMain() {
  return <nav id="menu-main">
    <div className="container">
      <Navbar>
        <NavLink href="/">Aktualności</NavLink>
        <NavDropdown title="O nas">
          <NavLink href="/">Aktualności</NavLink>
          <NavLink href="/o-nas/kim-jestesmy">Kim jesteśmy?</NavLink>
          <NavLink href="/o-nas/patron">Patron</NavLink>
          <NavLink href="/o-nas/historia">Historia</NavLink>
          <NavLink href="/kontakt/zarzad-glowny">Zarząd główny</NavLink>
          <NavLink href="/o-nas/sekcje">Sekcje i zespoły</NavLink>
          <NavLink href="/kontakt/kola-terenowe">Koła terenowe</NavLink>
          <NavLink href="/o-nas/faq">FAQ</NavLink>
          <NavLink href="/o-nas/ciekawostki">Ciekawostki</NavLink>
        </NavDropdown>
        <NavLink href="/o-nas/dolacz-do-nas">Dołącz do nas!</NavLink>
        <NavLink href="/wesprzyj-nas">Wesprzyj nas</NavLink>
        <NavLink href="/kontakt">Kontakt</NavLink>
      </Navbar>
    </div>
  </nav>
}

function Navbar({ children }: { children: React.ReactNode }) {
  return <>
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
        {children}
      </ul>
    </div>
  </>
}

function NavLink({ href, children }: { href: string, children: string }) {
  return <li><a href={href}>{children}</a></li>
}

function NavDropdown({ title, children }: { title: string, children: React.ReactNode }) {
  return <li className="dropdown">
    <a href="javascript:void(0);" className="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
      {title}
      <span className="caret"></span>
    </a>
    <ul className="dropdown-menu">
      {children}
    </ul>
  </li>
}
