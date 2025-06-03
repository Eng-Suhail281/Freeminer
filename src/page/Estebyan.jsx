import React from "react";
import Introduction from "../component/Estbyan/Introduction";
import ServieEstbyan from "../component/Estbyan/ServieEstbyan";
import Header from "../component/utilty/Header";
import Footer from "../component/utilty/Footer";
import About from "../component/Estbyan/About";
import Benefit from "../component/Estbyan/Benefit";

function Estebyan() {
  return (
    <div id="estbyanIntro">
      <Header />
      <Introduction /> 
       <About />
      <br />
      <ServieEstbyan />
      <br />
      <Benefit /> 
      <Footer />
    </div>
  );
}

export default Estebyan;
