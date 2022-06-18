import React from 'react'
import { SocialIcons } from './SocialIcons.jsx'
import * as fs from "fs"

export function SiteHeader() {
  return <header>
    <a href="/" id="header-triptych">
      <img className="triptych-center" src="/img/asksolideo-logo-320x384.png" alt="Logo ASK Soli Deo" />
      <h1>Soli Deo</h1>

      <h2 className="triptych-left">
        <span>Akademickie</span>
        <span style={{ fontSize: "78.4%" }}>Stowarzyszenie</span>
        <span style={{ fontSize: "110%", letterSpacing: "0.075em" }}>Katolickie</span>
      </h2>

      <h3 className="triptych-right">
        <img src="/img/czas-to-milosc.png" alt="Czas to miłość" />
      </h3>
    </a>

    <div id="social-icons" className="hidden-xs">
      <SocialIcons />
    </div>

    <div id="way-left">&nbsp;</div>


    <div id="members-img">
      <HeaderFoto />
      <div className="shadow"></div>
    </div>
  </header>
}

function HeaderFoto() {
  const photosDir = 'content/header-foto'
  const files = fs.readdirSync(photosDir)
    .filter(item => !item.startsWith("."))
    .filter(item => !item.startsWith("_"))
    .filter(item => item.endsWith(".jpg"))
  const randomFile = files[Math.floor(Math.random() * files.length)]
  const fullImgPath = `/header-foto/${randomFile}`
  return <img src={fullImgPath} alt="Zdjęcie członków stowarzyszenia" />
}
