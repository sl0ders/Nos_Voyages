require('../css/app.scss');
const $ = require('jquery');
require('bootstrap');
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