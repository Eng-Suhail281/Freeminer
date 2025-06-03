import React from "react";
import "./style.css";
import { Button } from "react-bootstrap";
import contactLogo from "../../asset/Team work-amico.png";
import { useTranslation } from "react-i18next";
import "./style.css";
import { NavHashLink } from "react-router-hash-link";
function Introduction() {
  const { t } = useTranslation();
  return (
    <div className="intro">
      <div className="container introContent ">
        <div className="introDetails">
          <div className="textLeft">
            <a
              rel="noreferrer"
              target="_blank"
              href={"https://events.datamining.om"}
            >
              <div className="platform">
                <span className="textDetails">{t("PlatformEvents")}</span>
              </div>
            </a>
            <h2  className="textActions">
              {t("Empowering")}
            </h2>
            <h2 className="textActions"> {t("Through")}</h2>
            <small  className="smallText lineHight">
              {t("AboutEvents")}
            </small>
          </div>
          <div  >
            <NavHashLink to={"/action#about"}>
              <Button className="LetsGo explor">{t("see")}</Button>
            </NavHashLink>
          </div>
        </div>
        <div  >
          <img src={contactLogo} alt="contactLogo" className="contactLogod" />
        </div>
      </div>
    </div>
  );
}

export default Introduction;
