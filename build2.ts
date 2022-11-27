import * as components from './components/index.js'

(async () => {
  const pages = await getPages(); // List of source pages. Include list pages
  const layout = await makeLayout({ menu: await getMenu(pages) });
  const renderedPages = await renderPages(pages, { layout, components });
  const pagesWithLocations = await locatePages(renderedPages); // computes duplicates for canonical urls
  await writePages(pagesWithLocations); // writes pages to disk
})().catch(console.error);
