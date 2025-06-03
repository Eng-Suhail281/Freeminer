import React from "react";
import { Button, Container, Form } from "react-bootstrap";
import contactLogo from "../../asset/Schedule-bro.png";
import { NavHashLink } from "react-router-hash-link";
import { useTranslation } from "react-i18next";

function ContactUs() {
  const { t } = useTranslation();

  return (
    <Container>
      <div className="contact__events">
        <div className="ContactUsEvents ">
          <p className="clients textActions">{t("Contact Us")}</p>
        </div>
        <br />
        <br />

        <div className="allContactUs">
          <Form   className="formContactUs">
            <Form.Group className="mb-3" controlId="formBasicPassword">
              <Form.Label className="LableForm">{t("Email")}</Form.Label>
              <Form.Control className="inputForm" type="email" />
            </Form.Group>
            <Form.Group className="mb-3" controlId="formBasicPassword">
              <Form.Label className="LableForm">{t("Messages")}</Form.Label>
              <br />
              <textarea className="form-control inputFormArea" type="text" />
            </Form.Group>
            <NavHashLink to={"/"}>
              <Button
                className="LetsGo explor submitEvent"
                variant="primary"
                type="submit"
              >
                {t("Submit")}
              </Button>
            </NavHashLink>
          </Form>
          <div data-aos="fade-right">
            <img
              src={contactLogo}
              alt="contactLogo"
              className="contactUSLogo"
            />
          </div>
        </div>
      </div>
      <div className="buttons">
        <a
          rel="noreferrer"
          target="_blank"
          href={"https://events.datamining.om"}
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
  );
}

export default ContactUs;
