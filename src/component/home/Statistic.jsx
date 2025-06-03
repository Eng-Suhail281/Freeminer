import React from "react";
import "../../Style/statistic.css";
import { useTranslation } from "react-i18next";
import { Container } from "react-bootstrap";
import Card from "@mui/material/Card";
import CardContent from "@mui/material/CardContent";
import Typography from "@mui/material/Typography";

function Statistic() {
  const { t } = useTranslation();
  const StatisticsData = t("StatisticsData");
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

      default:
        return "gray";
    }
  };
  return (
    <div
      id="statistic"
      className="statistic aos-init aos-animate "
      data-aos="fade-up"
    >
      <Container>
        <h2 className="title">{t("Statistics")}</h2>
        <p className="subTitle">{t("TextStatistics")}</p>
        <div className="allCard aos-init aos-animate" data-aos="zoom-in-up">
          {StatisticsData.map((item) => (
            <Card
              style={{
                borderBottom: `10px solid ${getBadgeColor(item.role)} `,
              }}
              className="card_Statistic"
              data-aos="flip-left"
              sx={{ maxWidth: 395, marginBottom: 2 }}
            >
              <div>
                <img
                  component="img"
                  height="200"
                  src={`${item.images}`}
                  alt="green iguana"
                  className="statisticImage"
                />
                <CardContent>
                  <Typography
                    className="titleCards"
                    gutterBottom
                    variant="h5"
                    component="div"
                  >
                    {item.title}
                  </Typography>
                  <Typography variant="body2" color="text.secondary">
                    {item.text}{" "}
                  </Typography>
                </CardContent>
              </div>
            </Card>
          ))}
        </div>
      </Container>
    </div>
  );
}

export default Statistic;
