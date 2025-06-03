import React from "react";
import "./style.css";
import { Container } from "react-bootstrap";
import { useTranslation } from "react-i18next";
function About() {
  const { t } = useTranslation();

  return (
    <div className="About" id="about">
      <div className="allDivs">
        <Container>
          <div className="allDiv">
            <div className="BoxAbout">
              <h2 className="about__title_clients textActions">
                {" "}
                {t("About")}
              </h2>
            </div>
            <div className="textEvents"> {t("introductionEvents")} </div>
          </div>
        </Container>
      </div>
    </div>
  );
}

export default About;
