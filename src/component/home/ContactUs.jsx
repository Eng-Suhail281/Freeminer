import React from "react";
import "./style.css";
import { useTranslation } from "react-i18next";
import { CiLocationOn } from "react-icons/ci";
import { IoIosPhonePortrait } from "react-icons/io";
import { TfiEmail } from "react-icons/tfi";
import { Button, Container } from "react-bootstrap";
import contactLogo from "../../asset/5259588.jpg";
function ContactUs() {
  const { t } = useTranslation();
  return (
    <div id="contact" className="ContactUs">
      <Container>
        <h2 className="title">{t("Contact Us")}</h2>
        <div className="AllContent">
          <div className="contactCards">
            <h5 className="textForm">{t("GET IN TOUCH")}</h5>
            <div className="textContact">
              <div className="d-flex itemContent">
                <span className="iconCard">
                  <CiLocationOn />
                </span>
                <span className="textContact_Title">{t("Location")}</span>
              </div>
              <span className="detalsLocation">
                {t("Oman, Muscat, Al Koud Mzoon street")}
              </span>
            </div>
            <hr />

            <div className="textContact">
              <div className="d-flex itemContent">
                <span className="iconCard">
                  <TfiEmail />
                </span>
                <span className="textContact_Title">{t("Email")}</span>
              </div>
              <span className="detalsLocation">info@datamining.om</span>
            </div>
            <hr />
            <div className="textContact">
              <div className="d-flex itemContent">
                <span className="iconCard">
                  <IoIosPhonePortrait />
                </span>
                <span className="textContact_Title">{t("Call")} :</span>
              </div>
              <span className="detalsLocation">+968 99384453</span>
            </div>
          </div>
          <div>
            <img
              src={contactLogo}
              alt="contactLogo"
              className="contact_Us_Logo"
            />
          </div>
        </div>
        <div className="buttons">
          <a
            target="_blank"
            rel="noreferrer"
            href={
              "https://eqp.datamining.om/estebyan/Get-In-Touch-With-Data-Mining"
            }
          >
            <Button
              className="LetsGo seeMore m-2 target"
              variant="primary"
              type="submit"
            >
              {t("GET IN TOUCH")}
            </Button>
          </a>
          <a
            rel="noreferrer"
            target="_blank"
            href={
              "https://eqp.datamining.om/estebyan/Service-Request-From-Data-Mining"
            }
          >
            <Button
              className="LetsGo  seeMore m-2"
              variant="primary"
              type="submit"
            >
              {t("ServicesHeader")}
            </Button>
          </a>
        </div>
      </Container>
    </div>
  );
}

export default ContactUs;
