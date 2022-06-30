export function wrapHtml({ html, title, frontmatter }: { html: string; title: string, frontmatter: Record<string, any> }): string {
    return (`<!DOCTYPE html>
    <html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>${title} - ASK Soli Deo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/style.css">
        ${frontmatter.structuredData ?
            `<script type="application/ld+json">${JSON.stringify(frontmatter.structuredData)}</script>`
            : ''
        }
    </head>
    <body>
        ${html}
    </body>
    </html>
`)
}
