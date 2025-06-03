import React from "react";
import { Container } from "react-bootstrap";
import { useTranslation } from "react-i18next";

function ObjectiveEvent() {
  const { t } = useTranslation();
  const ActionObjective = t("ActionObjective");

  return (
    <div className="About">
      <Container>
        <div className="allDiv">
          <div className="TimeLine">
            <div   className="info-timeline">
              <ul>
                <li className="LITIMELINE">
                  <span className="timeline-circle">{t("Vision")}</span>
                  <div className="boxTimeLines">
                    <p>{t("TextActionVesions")}</p>
                  </div>
                </li>
                <li className="LITIMELINE">
                  <span className="timeline-circle">{t("Mission")}</span>
                  <div className="boxTimeLines">
                    <p>{t("TextActionMission")}</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div className="allObjective">
            <p className="clients textActions">{t("Objectives")}</p>

            {ActionObjective?.map((item) => (
              <div className="objectives"  >
                <div className={item.role}></div>
                <p className="number">0{item.id}</p>
                <div className="oneItemOb">
                  <p>{item.name}</p>
                  <span>{item.text}</span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </Container>
    </div>
  );
}

export default ObjectiveEvent;
