import { loadPages } from './build/loadPages';
// import * as components from './components/index'

(async () => {
  const contentDirectory = './content';
  const pages = await loadPages(contentDirectory); // List of source pages. Include list pages
  console.dir(pages, { depth: 8 });
  // const layout = await makeLayout({ menu: await getMenu(pages) });
  // const renderedPages = await renderPages(pages, { layout, components });
  // const pagesWithLocations = await locatePages(renderedPages); // computes duplicates for canonical urls
  // await writePages(pagesWithLocations); // writes pages to disk
})().catch(console.error);
