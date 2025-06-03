import React from "react";
import "./style.css";
import { BsLinkedin } from "react-icons/bs";
import { BsTwitter } from "react-icons/bs";
import { BsSkype } from "react-icons/bs";
import { BsInstagram } from "react-icons/bs";
import { TiSocialSkypeOutline } from "react-icons/ti";
import { CiFacebook } from "react-icons/ci";
import logo from "../../asset/Logo-V4.png";
import { useTranslation } from "react-i18next";
const icons = [
  {
    images: <BsLinkedin />,
  },
  {
    images: <BsTwitter />,
  },
  {
    images: <BsSkype />,
  },
  {
    images: <BsInstagram />,
  },
  {
    images: <TiSocialSkypeOutline />,
  },
  {
    images: <CiFacebook />,
  },
];
function Footer() {
  const { t } = useTranslation();

  return (
    <div className="footer" data-aos="fade-up" data-aos-duration="1100">
      <div className="container FooterAll">
        <div className="contentRight">
          <img src={logo} alt="FooterImages" className="logoFooter" />
          <p className="textFooter">{t("Mining")}</p>
        </div>
        <div className="footerIcons">
          {icons.map((item) => (
            <div className="ciurcel">{item.images}</div>
          ))}
        </div>
      </div>
    </div>
  );
}

export default Footer;
