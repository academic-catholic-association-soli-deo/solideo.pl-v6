<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109901032-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-109901032-1');
</script>

<?php require __DIR__ . '/title.php'; ?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#23527c">
<meta name="theme-color" content="#23527c">
<meta name="msapplication-TileColor" content="#23527c">
<meta name="msapplication-TileImage" content="/img/favicon/mstile-150x150.png">

<?php if($website['is-home']): ?>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "url": "https://www.solideo.pl",
  "name": "Akademickie Stowarzyszenie Katolickie Soli Deo",
  "address": {
  	"@type": "PostalAddress",
  	"addressCountry": "PL",
  	"addressLocality": "Warszawa",
  	"addressRegion": "Mazowieckie",
  	"postalCode": "00-661",
  	"streetAddress": "plac Politechniki 1"
  },
  "email": "kontakt@solideo.pl",
  "logo": "https://solideo.pl/img/solideo-logo-833x1000.png",
  "sameAs": [
    "https://web.facebook.com/SoliDeo1989/",
    "https://www.instagram.com/asksolideo/",
    "https://www.youtube.com/user/AskSoliDeo"
  ]
}
</script>
<?php endif; ?>

<link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CLora:400,700&amp;subset=latin-ext" rel="stylesheet">

<?php //if(isset($_GET['style2'])): ?>
<link rel="stylesheet" href="/css/app.min3.css">
<?php //else: ?>
<?php //endif; ?>

<?php if (isset($_GET['newsletter'])) echo "<script src='https://www.google.com/recaptcha/api.js'></script>"; ?>

<?php if ($website['paginator']->hasPrevPage()) echo '<link rel="prev" href="' . $website['paginator']->getPrevLink() . '">'; ?>
<?php if ($website['paginator']->hasNextPage()) echo '<link rel="next" href="' . $website['paginator']->getNextLink() . '">'; ?>

