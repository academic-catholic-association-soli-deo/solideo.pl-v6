import * as yaml from "https://deno.land/std@0.139.0/encoding/yaml.ts";

const years = [2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020]

for (const year of years) {
  const dir = `content/${year}`
  const settingsFile = `${dir}/settings.json`
  const settings = JSON.parse(await Deno.readTextFile(settingsFile))
  const indexFile = `${dir}/index.md`
  const indexContents = `---\n${yaml.stringify(settings).trim()}\n---\n`
  console.log()
  console.log("---")
  console.log(indexFile)
  console.log(indexContents)
  await Deno.writeTextFile(indexFile, indexContents)
  await Deno.remove(settingsFile)
}
