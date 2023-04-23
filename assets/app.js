/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import { registerReactControllerComponents } from '@symfony/ux-react';
registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));

import ReactDOM from "react-dom/client"
import App from "./react/controllers/App"
import React from 'react'

/*
const root = ReactDOM.createRoot(document.getElementById("root"));
root.render("Hello World ");*/
const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(<App />);
