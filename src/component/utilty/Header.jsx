import React from "react";
import { useLocation } from "react-router-dom";
import logo from "../../asset/Logo-V4.png";
import { Button, Nav, Navbar } from "react-bootstrap";
import { Component } from "react";
import "../../Style/header.css";
import { useTranslation } from "react-i18next";
import { NavHashLink } from "react-router-hash-link";
import i18n from "../../Lang/i18next";
class Headers extends Component {
  changeLanguage = () => {
    const newLang = i18n.language === "en" ? "ar" : "en";
    localStorage.setItem("lang", newLang);
    i18n.changeLanguage(newLang);
  };

  render() {
    return (
      <>
        <Button
          className="btn lang"
          onClick={this.changeLanguage}
          variant="link"
        >
          {i18n.language === "en" ? "عربي" : "English"}
        </Button>
      </>
    );
  }
}

export default function Header() {
  let location = useLocation();
  const { t } = useTranslation();

  return (
    <div className="Header">
      <div className="header">
        <Navbar className="rowReverse" collapseOnSelect expand="lg">
          <>
            <Navbar.Brand href="/">
              <img src={logo} alt="logo" className="logo" />
            </Navbar.Brand>
            <Navbar.Toggle aria-controls="responsive-navbar-nav content" />
            <Navbar.Collapse id="responsive-navbar-nav content">
              <Nav className="navbar-pg nav">
                <NavHashLink
                  to="/#home"
                  className={
                    location.hash === "#home" && location.pathname === "/"
                      ? "selected"
                      : "nav-item"
                  }
                >
                  {t("Home")}
                </NavHashLink>
                <NavHashLink
                  to="/#about"
                  spy={true}
                  exact
                  smooth={true}
                  className={
                    location.hash === "#about" && location.pathname === "/"
                      ? "selected"
                      : "nav-item"
                  }
                >
                  {t("AboutHeader")}
                </NavHashLink>

                <NavHashLink
                  to="/#service"
                  spy={true}
                  smooth={true}
                  className={
                    location.hash === "#service" && location.pathname === "/"
                      ? "selected"
                      : "nav-item"
                  }
                >
                  {t("ServicesHeader")}
                </NavHashLink>
                <NavHashLink
                  to="/#statistic"
                  spy={true}
                  activeClassName="active"
                  smooth={true}
                  className={
                    location.hash === "#statistic" && location.pathname === "/"
                      ? "selected"
                      : "nav-item"
                  }
                >
                  {t("Indicators")}
                </NavHashLink>
                <NavHashLink
                  exact
                  to="/estebyan#estbyanIntro"
                  className={
                    location.hash === "#estbyanIntro" &&
                    location.pathname === "/estebyan"
                      ? "selected"
                      : "nav-item"
                  }
                >
                  {t("EstebyanHeader")}
                </NavHashLink>
                <NavHashLink
                  exact
                  to="/action#introAction"
                  className={
                    location.hash === "#introAction" &&
                    location.pathname === "/action"
                      ? "selected"
                      : "nav-item"
                  }
                >
                  {t("Events")}
                </NavHashLink>
                <NavHashLink
                  exact
                  to="/#contact"
                  spy={true}
                  activeClassName="active"
                  smooth={true}
                  className={
                    location.hash === "#contact" && location.pathname === "/"
                      ? "selected"
                      : "nav-item"
                  }
                >
                  {t("ContactHeader")}
                </NavHashLink>
              </Nav>
            </Navbar.Collapse>
            <Nav className="Switch">
              <Headers />
            </Nav>
          </>
        </Navbar>
      </div>
      {/* <Link to="home" spy={true} smooth={true} className="arrow">
        <FaArrowUp className="arrowIcon" />
      </Link> */}
    </div>
  );
}
