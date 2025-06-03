import React, { useState } from "react";
import "./style.css";
import { BsFillCaretRightFill } from "react-icons/bs";
import AboutImage from "../../asset/aboutNew.png";
import "../../Style/intro.css";
import { IoCloseCircleOutline } from "react-icons/io5";
import { Modal } from "react-bootstrap";
import { useTranslation } from "react-i18next";
function Introduction() {
  const [show, setShow] = useState(false);
  const { t } = useTranslation();

  return (
    <div id="home">
      <section>
        <div className="container">
          <div className="hero__wrapper">
            <div className="hero__content">
              <h2 className="section__title">
                {t("Omani")}
                <span className="highlights"> {t("DATA")} </span>
                {t("Omanis")}
              </h2>
              <p className="details_text">{t("Mining")}</p>

              <div className="hero__btns">
                <button className="register__btn">{t("Started")}</button>
                <button onClick={() => setShow(!show)} className="watch__btn">
                  <span>
                    <BsFillCaretRightFill />
                  </span>
                  {t("Video")}
                </button>
              </div>
            </div>

            <div className="hero__img">
              <div
                data-aos="fade-up"
                data-aos-delay="100"
                data-aos-duration="2000"
              >
                <div className="">
                  <img
                    src={AboutImage}
                    alt="AboutImage"
                    className="AboutImage"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <Modal show={show} fullscreen={true} onHide={() => setShow(false)}>
        <div onClick={() => setShow(false)}>
          <IoCloseCircleOutline
            onClick={() => setShow(false)}
            className="close"
          />
        </div>
        <Modal.Body closeButton>
          <iframe
            allowfullscreen="true"
            title="Data Mining"
            src="https://www.youtube-nocookie.com/embed/E6hKz2AbkJY?autoplay=0&controls=0&disablekb=1&playsinline=0&cc_load_policy=0&cc_lang_pref=auto&widget_referrer=https%3A%2F%2Fdatamining.om%2F%23&rel=0&showinfo=0&iv_load_policy=3&modestbranding=1&customControls=true&noCookie=true&enablejsapi=1&origin=https%3A%2F%2Fdatamining.om&widgetid=1"
          ></iframe>
        </Modal.Body>
      </Modal>
    </div>
  );
}

export default Introduction;
