import React from 'react';
import Header from './header';
import Footer from './footer';

const Layout = ({ children }) => {
  return (
    <div className="d-flex flex-column min-vh-100">
      <Header />
      <main className="flex-grow-1 p-4">
        {children}
      </main>
      <Footer />
    </div>
  );
};

export default Layout;
