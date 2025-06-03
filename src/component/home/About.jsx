import React, { useState } from "react";
import LogoImage from "../../asset/12643932_5031659.jpg";
import "../../Style/about.css";
import { useTranslation } from "react-i18next";
import { Col } from "react-bootstrap";

function About() {
  const [open, setOpen] = useState(true);
  const [open2, setOpen2] = useState(true);
  const [open3, setOpen3] = useState(true);

  const handleClick = () => {
    setOpen(!open);
  };
  const handleClick2 = () => {
    setOpen2(!open2);
  };
  const handleClick3 = () => {
    setOpen3(!open3);
  };
  const { t } = useTranslation();
  const ObjectivesList = t("ObjectivesList");

  return (
    <div id="about" className=" services">
      <h2 className="title">{t("About")}</h2>
      <div className="borderAbout"></div>
      <div className="container about">
        <Col xs={11} md={6}>
          <div onClick={handleClick} className="BoxShare objective">
            <h3 className="textTab">{t("Objectives")}</h3>
            {open ? (
              <div>
                <ul className="ulTab">
                  {ObjectivesList.map((item) => (
                    <li className="li">{item}</li>
                  ))}
                </ul>
              </div>
            ) : (
              ""
            )}
          </div>
          <div onClick={handleClick2} className="BoxShare Mission">
            <h3 className="textTab">{t("Mission")}</h3>
            {open2 ? (
              <div className="ulTab li textTabs">{t("MissionText")} </div>
            ) : (
              ""
            )}
          </div>
          <div
             onClick={handleClick3}
            className="BoxShare vesion"
          >
            <h3 className="textTab">{t("Vision")}</h3>
            {open3 ? (
              <div className="ulTab li textTabs">{t("VisionText")} </div>
            ) : (
              ""
            )}
          </div>
        </Col>
        <Col xs={1} md={6}>
          <img src={LogoImage} alt="LogoImage" className="LogoImage" />
        </Col>
      </div>
    </div>
  );
}

export default About;
