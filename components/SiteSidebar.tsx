import React from 'react'
import { SocialIcons } from './SocialIcons.jsx'

export function SiteSidebar() {
  return <>
    <ZnajdzNas />
    <Patronite />
    <Archiwum />
    <Polecamy />
  </>
}

function ZnajdzNas() {
  return <Widget title="Znajdź nas" className="widget-social">
    <p style={{ textAlign: "center" }}>
      <SocialIcons />
    </p>
  </Widget>
}

function Patronite() {
  return <Widget className="widget-baner">
    <a target="_blank" href="https://patronite.pl/ASKSoliDeo" title="Wesprzyj nas!">
      <img id="side30" src="/banery/patronite.png" alt="ASK Soli Deo na patronite" />
    </a>
  </Widget>
}

function Archiwum() {
  const years = []
  for (let y = 2004; y <= new Date().getFullYear(); y++) {
    years.push(y)
  }
  years.reverse()
  return <Widget title="Archiwum" className="widget-archive">
    <p>
      {years.map(year => (<a key={year} href={`/${year}`}>{year}</a>))}
    </p>
  </Widget>
}

function Polecamy() {
  return <Widget title="Polecamy" className="widget-baner">
    <a rel="nofollow" href="https://fanimani.pl/akademickie-stowarzyszenie-katolickie-soli-deo/" target="_blank"
      title="Zapraszamy na zakupy!">
      <img src="/banery/fanimani.png" alt="Wspomóż ASK Soli Deo robiąc zakupy — fanimani.pl" />
    </a>
  </Widget>
}

function Widget({ children, title, className }: { children: React.ReactNode, title?: string, className: string }) {
  return <div className={"widget " + className}>
    {title && <h3>{title}</h3>}
    {children}
  </div>
}
