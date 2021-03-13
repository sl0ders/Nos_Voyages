const $ = require('jquery');
import 'bootstrap';
import '../css/app.css';
import 'jquery';
import React from "react";
import ReactDOM from "react-dom";
import LikeButton from "./component/LikeButton";

document.querySelectorAll('span.react-likes').forEach((span) => {
    const likes = +span.dataset.likes;
    const isLiked = +span.dataset.isLiked === 1;
    ReactDOM.render(<LikeButton likes={likes} isLiked={isLiked} />, span)
});


/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you require will output into a single css file (app.css in this case)
$('.cross').on('click', () => {
    console.log('close')
});
console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
