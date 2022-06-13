import { renderToStaticMarkup } from 'react-dom/server';
import React from 'react';
import ReactMarkdown from 'react-markdown'

function App({ markdownContent }: {markdownContent: string}) {
    return (
      <React.StrictMode>
        <ReactMarkdown>
          {markdownContent}
        </ReactMarkdown>
      </React.StrictMode>
    )
}

export function markdownToHtml(markdownContent: string) {
  return renderToStaticMarkup(<App markdownContent={markdownContent}/>);
}
