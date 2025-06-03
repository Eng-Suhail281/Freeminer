import React from "react";
import "./style.css";
import { useTranslation } from "react-i18next";
import { Button, Container } from "react-bootstrap";
import Logo from "../../asset/At the office-amico.png";
import { NavHashLink } from "react-router-hash-link";
function Introduction() {
  const { t } = useTranslation();
  return (
    <div className="introActopn">
      <div className="Contecnt_container">
        <Container>
          <div className="introDetailsAction">
            <div className="textLefts">
              <a
                rel="noreferrer"
                target="_blank"
                href={"https://eqp.datamining.om/"}
              >
                <div className="platform">
                  <span className="textDetails">{t("Platform")}</span>
                </div>
              </a>

              <h2 className="clientsAction">
                {t("Provide")}{" "}
                <span className="clientsAction ColoText"> {t("World")} </span>
              </h2>
              <h2 className="clientsAction ">
                <span className="clientsAction ColoText">{t("Best")} </span>
                {t("Service")}
              </h2>
              <small className="smallText">{t("EstebyanAbout")} </small>
              <br />
              <NavHashLink to="/estebyan#aboutEstbyan">
                <Button className="btn lang see_more ">{t("see")}</Button>
              </NavHashLink>
            </div>

            <div>
              <img src={Logo} alt="LogoIntro" className="LogoIntro" />
            </div>
          </div>
        </Container>
      </div>
    </div>
  );
}

export default Introduction;
