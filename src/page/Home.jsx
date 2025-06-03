import React from "react";
import Header from "../component/utilty/Header";
import Introduction from "../component/home/Introduction";
import Service from "../component/home/Service";
import Statistic from "../component/home/Statistic";
import Footer from "../component/utilty/Footer";
import ContactUs from "../component/home/ContactUs";
import About from "../component/home/About";

function Home() {
  return (
    <div>
      <Header />
      <Introduction />
      <br />
      <About />
      <br />

      <Service />
      <Statistic />
      <ContactUs />
      <Footer />
    </div>
  );
}

export default Home;
