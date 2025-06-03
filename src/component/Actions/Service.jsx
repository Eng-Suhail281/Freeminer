import React from "react";
import { Button, Col, Container, Row } from "react-bootstrap";
import Translate from "../../asset/Schedule-cuate.png";
import Plane from "../../asset/Organizing projects-bro.png";
import Shudeul from "../../asset/Schedule-amico.png";
import Organizing from "../../asset/Organizing projects-cuate.png";
import Tablet from "../../asset/Tablet login-amico.png";
import Team from "../../asset/Team work-amico.png";
import Add from "../../asset/Calendar-rafiki.png";

import { NavHashLink } from "react-router-hash-link";
import { useTranslation } from "react-i18next";
 
function Service() {
  const { t } = useTranslation();
  const CreateObj = t("CreateObj");
  const ReportsAndList = t("ReportsAndList");
  const PlanningList = t("PlanningList");

  return (
    <Container>
      <div className="Service">
        <p className="clients textActions"> {t("Services")}</p>
      </div>

      <Row>
        <Col xs={6} md={4}>
          <div data-aos="fade-down" className="itemServices">
            <img src={Translate} className="Translate" alt="Translate" />
            <div className="Coulmus">
              <h2 className=" itemServicceText">{t("Create")}</h2>
              <small data-aos="fade-up" className="smallText">
                {CreateObj.map((item) => (
                  <p>{item} </p>
                ))}
              </small>
            </div>
          </div>
        </Col>
        <Col xs={6} md={4}>
          <div data-aos="fade-down" className="itemServices">
            <div className="Coulmus">
              <h2 className=" itemServicceText">{t("ReportsAnd")}</h2>
              <small data-aos="fade-up" className="smallText">
                {ReportsAndList.map((item) => (
                  <p>{item} </p>
                ))}
              </small>
            </div>
            <img src={Plane} className="Translate" alt="Translate" />
          </div>
        </Col>
        <Col xs={6} md={4}>
          <div data-aos="fade-down" className="itemServices">
            <img src={Shudeul} className="Translate" alt="Translate" />

            <div className="Coulmus">
              <h2 className=" itemServicceText">{t("Planning")}</h2>
              <small data-aos="fade-up" className="smallText">
                {PlanningList.map((item) => (
                  <p>{item} </p>
                ))}
              </small>
            </div>
          </div>
        </Col>
      </Row>
     </Container>
  );
}

export default Service;

export function ServiceItem() {
  const { t } = useTranslation();
  const ManageList = t("ManageList");
  const resourcesList = t("resourcesList");
  const volunteersList = t("volunteersList");
  const AddList = t("AddList");

  return (
    <Container>
      <div data-aos="fade-up" className="secandService">
        <Row className="rwos">
          <Col xs={6} md={6}>
            <img src={Tablet} alt="contactLogo" className="contactLogods " />
          </Col>

          <Col xs={6} md={6}>
            <div
              data-aos="fade-up"
              className="itemServices itemServicesSecand Boxuniq"
            >
              <div className="Coulmus">
                <h2 className=" itemServicceText">{t("Manage")}</h2>
                <small data-aos="fade-up" className="smallText">
                  {ManageList.map((item) => (
                    <p>{item} </p>
                  ))}
                </small>
                <NavHashLink to="/action#serviceActions">
                  <Button className="LetsGo seeMore">{t("see")}</Button>
                </NavHashLink>
              </div>
            </div>
          </Col>
        </Row>
      </div>
      <div className="secandService">
        <Row id="serviceActions">
          <Col xs={6} md={4}>
            <div className="itemServices itemServicesSecand">
              <div className="Coulmus">
                <h2 className=" itemServicceText">{t("resources")}</h2>
                <small data-aos="fade-up" className="smallText">
                  {resourcesList.map((item) => (
                    <p>{item} </p>
                  ))}
                </small>
              </div>
              <img src={Organizing} className="Translate" alt="Organizing" />
            </div>
          </Col>
          <Col xs={6} md={4}>
            <div className="itemServices itemServicesSecand">
              <img src={Team} className="Translate" alt="Team" />

              <div className="Coulmus">
                <h2 className=" itemServicceText">{t("volunteers")}</h2>
                <small data-aos="fade-up" className="smallText">
                  {volunteersList.map((item) => (
                    <p>{item} </p>
                  ))}{" "}
                </small>
              </div>
            </div>
          </Col>
          <Col xs={6} md={4}>
            <div className="itemServices itemServicesSecand">
              <div className="Coulmus">
                <h2 className="textActions itemServicceText">{t("Add")}</h2>
                <small data-aos="fade-up" className="smallText">
                  {AddList.map((item) => (
                    <p>{item} </p>
                  ))}{" "}
                </small>
              </div>
              <img src={Add} className="Translate" alt="Add" />
            </div>
          </Col>
        </Row>
      </div>
    </Container>
  );
}
