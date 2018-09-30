import ReactDOM from "react-dom";
import React from "react";
import App from "./components/App";

if (document.getElementById('app-react')) {
    ReactDOM.render(<App />, document.getElementById('app-react'));
}
//registerServiceWorker();
