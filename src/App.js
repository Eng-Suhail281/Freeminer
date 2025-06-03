import Aos from "aos";
import { lazy, Suspense, useEffect } from "react";
import { GlobalStyle } from "./them/style";
import { Route, Routes } from "react-router-dom";
import { useTranslation } from "react-i18next";
import { Spinner } from "react-bootstrap";
import Home from "./page/Home";
import Estebyan from "./page/Estebyan";
import Action from "./page/Action";

function App() {
  useEffect(() => {
    Aos.init();
  }, []);
  const { i18n } = useTranslation();
  // const Home = lazy(() => import("./page/Home"));
  // const Estebyan = lazy(() => import("./page/Estebyan"));
  // const Action = lazy(() => import("./page/Action"));
  return (
    <>
      <GlobalStyle dir={i18n.language === "en" ? "ltr" : "rtl"} />
      <Suspense
        fallback={
          <div className="Spinner">
            <Spinner animation="border" variant="success" />
          </div>
        }
      >
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/estebyan" element={<Estebyan />} />
          <Route path="/action" element={<Action />} />
        </Routes>
      </Suspense>
    </>
  );
}

export default App;
