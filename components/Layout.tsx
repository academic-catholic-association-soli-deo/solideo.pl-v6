import React, { ReactNode } from 'react'

export function Layout({ children }: { children: ReactNode }) {
  return (
    <React.StrictMode>
      <div>
        <h1>Soli Deo</h1>
        {children}
      </div>
    </React.StrictMode>
  )
}
