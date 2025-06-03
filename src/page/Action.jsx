import React from "react";
import Header from "../component/utilty/Header";
import Footer from "../component/utilty/Footer";
import Introduction from "../component/Actions/Introduction";
import About from "../component/Actions/About";
import ContactUs from "../component/Actions/ContactUs";
import ObjectiveEvent from "../component/Actions/ObjectiveEvent";
import Service, { ServiceItem } from "../component/Actions/Service";

function Action() {
  return (
    <div id="introAction">
      <Header />
      <Introduction />
      <br />
      <About />
          <ObjectiveEvent />
     <Service />
         <ServiceItem />
      <ContactUs /> 
      <Footer />
    </div>
  );
}

export default Action;
