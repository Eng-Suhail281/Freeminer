import React, { useState } from "react";
import contactLogo from "../../asset/Business Plan-amico.png";
import { Container } from "react-bootstrap";
import { Modal } from "react-bootstrap";
import { FaRegPlayCircle } from "react-icons/fa";
import { IoCloseCircleOutline } from "react-icons/io5";
import { useTranslation } from "react-i18next";

function About() {
  const { t } = useTranslation();

  const [show, setShow] = useState(false);
  const [show2, setShow2] = useState(false);

  return (
    <div id="aboutEstbyan" className="">
      <Container>
        <div className="introContent">
          <div className="textDetailss">
            <div className="about__titles">
              <h2 className="about__title_clients">
                {t("Choose")}
                <h2 className="ColoText"> {t("The")}</h2>
                {t("IT")}
              </h2>
              <br />
              <h2 className="about__title_client"> {t("Business")}</h2>
            </div>
            <div className="BorderLeft">
              <small className="">
                {t("ESTEBYAN Platform")}
                <br />
                {t("What")}
              </small>
            </div>

            <div className="action_intro">
              <div
                className="  btnWatchVideos"
                onClick={() => setShow2(!show2)}
              >
                <FaRegPlayCircle className="iconVideo" />
                <span className="btnWatchVideo">{t("Estebian Platform")}</span>
              </div>
              <div
                className=" btnWatchVideos mar"
                onClick={() => setShow(!show)}
              >
                <FaRegPlayCircle className="iconVideo" />
                <span className="btnWatchVideo">{t("Platform")}</span>
              </div>
            </div>
          </div>
          <div data-aos="fade-right">
            <img
              src={contactLogo}
              alt="contactLogo"
              className="contactLogods"
            />
          </div>
        </div>
        <Modal show={show} fullscreen={true} onHide={() => setShow(false)}>
          <div onClick={() => setShow(false)}>
            <IoCloseCircleOutline
              onClick={() => setShow(false)}
              className="close"
            />
          </div>
          <Modal.Body closeButton>
            <iframe
              title="ESTEBYAN"
              src="https://youtu.be/G4FZnkmzY0o"
            ></iframe>
          </Modal.Body>
        </Modal>
        <Modal show={show2} fullscreen={true} onHide={() => setShow2(false)}>
          <div onClick={() => setShow2(false)}>
            <IoCloseCircleOutline
              onClick={() => setShow2(false)}
              className="close"
            />
          </div>{" "}
          <Modal.Body closeButton>
            <iframe
              title="Data ESTEBYAN"
              src="https://youtu.be/GWLbaRxTqMg"
            ></iframe>
          </Modal.Body>
        </Modal>
      </Container>
    </div>
  );
}

export default About;
