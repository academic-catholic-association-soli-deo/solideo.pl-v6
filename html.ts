export function wrapHtml({ html, title, frontmatter }: { html: string; title: string, frontmatter: Record<string, any> }): string {
    return (`<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>${title} - ASK Soli Deo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#23527c">
    <meta name="theme-color" content="#23527c">
    <meta name="msapplication-TileColor" content="#23527c">
    <meta name="msapplication-TileImage" content="/favicon/mstile-150x150.png">
    ${frontmatter.structuredData ?
            `<script type="application/ld+json">${JSON.stringify(frontmatter.structuredData)}</script>`
            : ''
        }
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CLora:400,700&amp;subset=latin-ext" rel="stylesheet">
        <link rel="stylesheet" href="/style.css">
</head>
<body>
    ${html}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/scripts.js"></script>
</body>
</html>
`)
}
