import React from 'react'

export function SiteFooter() {
  const year = new Date().getFullYear()
  return <footer className="footer">
    <div className="container">
      <div className="row">
        <div className="col-sm-4 col-xs-6 footer-column">
          <p>
            <strong style={{ fontSize: "1.4em" }}>kontakt@solideo.pl</strong><br />
          </p>
          <p>
            <strong>Adres korespondencyjny:</strong><br />
            Akademickie Stowarzyszenie Katolickie Soli Deo<br />
            skrytka pocztowa 227<br />
            00-001 Warszawa 1
          </p>
          <p>
            ...więcej w zakładce <a href="/kontakt">KONTAKT</a>
          </p>
        </div>
        <div className="col-sm-4 col-xs-6 footer-column">
          <p>
            <strong>Konto bankowe:</strong><br />
            BNP Paribas S.A. <br />
            Nr rachunku: 13 2030 0045 1110 0000 0390 0920
          </p>
          <p>
            <strong>Dane do faktury:</strong><br />
            Akademickie Stowarzyszenie Katolickie Soli Deo<br />
            Plac Politechniki 1 <br />
            00-661 Warszawa<br />
            <br />
            <strong>NIP</strong>: 951-20-69-241
          </p>
        </div>
        <div className="col-sm-4 col-xs-12 footer-column">
          <p>
            <strong>Strona WWW:</strong><br />
            Strona: Copyright &copy; 2017-{year} by Akademickie Stowarzyszenie Katolickie Soli Deo. |
            Treści: Copyright &copy; 1989-{year} by Akademickie Stowarzyszenie Katolickie Soli Deo. |
            Projekt i wykonanie strony internetowej: <a href="http://jblewandowski.com">Jędrzej Lewandowski</a> i Karolina Kraska. |
            Strona korzysta z Bootstrap, ikon social media Daniela Oppela i wzorów <a href="http://www.dinpattern.com/">DinPattern</a>.
          </p>
          <p>Zobacz nasze <a href="/zaprzyjaznione-strony">zaprzyjaźnione strony (i strony naszych członków)</a>.</p>
          <p>Nasza strona nie używa ciasteczek!</p>
        </div>
        <div className="col-sm-12 col-xs-12">
          <h3>Niech będzie pochwalony Jezus Chrystus!</h3>
        </div>
      </div>
    </div>
  </footer>
}
