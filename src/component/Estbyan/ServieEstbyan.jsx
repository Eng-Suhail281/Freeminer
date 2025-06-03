import React from "react";

import { Col, Container, Row } from "react-bootstrap";
import { useTranslation } from "react-i18next";
import logo from "../../asset/12557528_5012644.jpg";
function ServieEstbyan() {
  const { t } = useTranslation();
  const ListAlllDataEstba = t("ListAlllDataEstba");

  return (
    <Container>
      <div className="all_Box">
        <p className="clients textActions all_Box__p">{t("Characteristics")}</p>
        <div className="all_Boxs">
          {ListAlllDataEstba.map((item) => (
            <div className="boxEstbyan">
              <img
                src={item.image}
                alt="conversation_9100092"
                className="boxEstbyanLogo"
              />
              <small>{item.text} </small>
            </div>
          ))}
        </div>
      </div>
      <br />
      <ServieEstbyanItem />
    </Container>
  );
}

export default ServieEstbyan;

export function ServieEstbyanItem() {
  const { t } = useTranslation();

  return (
    <Container>
      <Row className="rwos ServieEstbyanItem">
        <Col xs={1} md={6}>
          <img src={logo} alt="contactLogo" className="contactLogods " />
        </Col>

        <Col xs={10} md={6}>
          <div
            data-aos="fade-up"
            className="itemServices itemServicesSecand Boxuniqs"
          >
            <div className="Coulmus">
              <small data-aos="fade-up" className="smallText">
                {t("existence")}{" "}
              </small>
            </div>
          </div>
        </Col>
      </Row>
    </Container>
  );
}
