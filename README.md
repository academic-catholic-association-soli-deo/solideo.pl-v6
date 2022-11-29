# Solideo v6

This is the 6th generation of Solideo.pl website.



## Requirements

### Functional

1. Posts have layouts
2. Posts have structured data
3. There is a sitemap
4. Posts are organized by years
5. Year pages are paginated
6. The front page is a page of current year
7. There is a dropdown structured menu
8. URLs from old websites are preserved for SEO
9. The sidebar and menu are configured via markdown/json/yml

### Quality attributes

1. **LMNT**: Low maintenance — should not require redeploys, payments, prolongations. Should not require software updates.
2. **FMT10Y**: Content storage format will be readable in 10-15 years. If not readable should be easy to migrate.
3. **FREE** Low cost of deployment — preferably free
4. **EASYUP** Content updates do not require much skills
5. **LOWSKILL** Software maintenance requires minimal software knowledge
6. **TECHN10Y** The technologies used should be popular and well documented. Should be popular among students in 10 years
7. **SEO** SEO friendly: static html, 



## Decisions

1. Store data in markdown with YML frontmatter: this format has been widely used for >10 years now
2. Store metadata in YML — to keep only two formats used
3. Site written in plain Javascript — javascript will be long used because of browsers. Use typescript for better readability and intention-reveal
4. Use React for building layout — this tradeoff will reduce my amount of maintenance
5. Update posts via Github file editing / commits — lower maintenance
6. Build website statically on github actions: probably will be free for long time. Write build scripts in bash in such a way they can be run locally
7. Use Nodejs LTS and do not use Deno — deno might not become very popular, it is not taking over nodejs
8. Deploy websites to Firebase Hosting — it is excellently low-maintenance. Deployment is very self-contained and nearly zero-setup. Migration would be easy.
