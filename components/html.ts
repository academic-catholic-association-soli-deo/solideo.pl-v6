export function wrapHtml({ html, title }: { html: string; title: string }): string {
  return (`<!DOCTYPE html>
    <html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>${title} - ASK Soli Deo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/style.css">
    </head>
    <body>
        ${html}
    </body>
    </html>
`)
}
