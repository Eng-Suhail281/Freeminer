import React from "react";
import { Button, Container } from "react-bootstrap";
import { useTranslation } from "react-i18next";
function Benefit() {
  const { t } = useTranslation();
  const benefit = t("benefit");
  const getBadgeColor = (role) => {
    switch (role) {
      case "one":
        return "#b64811";
      case "two":
        return "#127403";
      case "three":
        return "#b6a311";
      case "four":
        return "#b6118a";
      case "five":
        return "#ffc107";
      case "six":
        return "#dc3545";
      default:
        return "gray";
    }
  };
  return (
    <Container>
      <div className="allBenefit">
        <p className="clients textActions benegitText">
          {t("benefit ESTEBYAN")}
        </p>
        <small>{t("benefit ESTEBYAN Title")} </small>
        <div className="allCardBenefit">
          {benefit.map((item) => (
            <div
              style={{
                borderTop: `10px solid ${getBadgeColor(item.role)} `,
                borderRight: `10px solid ${getBadgeColor(item.role)} `,
              }}
              className="BenefitItems"
            >
              <img src={item.image} alt="logo" className="imageBenefit" />
              <small>{item.text} </small>
            </div>
          ))}
        </div>
      </div>
      <div className="buttons">
        <a rel="noreferrer" target="_blank" href={"https://eqp.datamining.om/"}>
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

export default Benefit;
