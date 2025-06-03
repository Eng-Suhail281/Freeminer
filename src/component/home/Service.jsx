import React from "react";
import "../../Style/service.css";
import Card from "@mui/material/Card";
import CardContent from "@mui/material/CardContent";
import CardMedia from "@mui/material/CardMedia";
import { useTranslation } from "react-i18next";
import { Box, Slider } from "@mui/material";
import { Container } from "react-bootstrap";
function Service() {
  const { t } = useTranslation();
  const ServicesList = t("ServicesList");

  return (
    <div id="service" className="container services">
      <h2 data-aos="fade-up" className="title">
        {t("Services")}
      </h2>
      <Box sx={{ width: 300 }}>
        <Slider
          aria-label="Temperature"
          defaultValue={70}
          disabled
          color="secondary"
        />
      </Box>
      <div className="AllCaedsService">
        {ServicesList.map((item) => (
          <Card className={`card_service_Home ${item.class}`}>
            <CardMedia
              component="img"
              height="220"
              image={item.image}
              alt="green iguana"
            />
            <div className="flip-card" sx={{ maxWidth: 345 }}>
              <div className="flip-card-inner">
                <CardContent className="flip-card-front">
                  <div className="details">
                    <p className="name">{item.title}</p>
                    <p className="details_name">{`${item.text}`}</p>
                  </div>
                </CardContent>
                <div class="flip-card-back">
                  <p className="textService">{item.text}</p>
                </div>
              </div>
            </div>
          </Card>
        ))}
      </div>
    </div>
  );
}

export default Service;
