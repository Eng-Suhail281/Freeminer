import { createGlobalStyle } from "styled-components";

export const GlobalStyle = createGlobalStyle`
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
 
html {
    font-family: 'Source Sans Pro', sans-serif;
  direction: ${(props) => props.dir}; // to apply the multi languages in styling
}
 
 }
`;
