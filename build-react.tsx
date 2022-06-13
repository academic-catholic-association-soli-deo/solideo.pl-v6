import { renderToStaticMarkup } from 'react-dom/server';
import React from 'react';

function App() {
    return (
        <React.StrictMode>
            <div>Hello, World!</div>
        </React.StrictMode>
    )
}

export function buildReactSite() {
    return renderToStaticMarkup(<App/>);
}
