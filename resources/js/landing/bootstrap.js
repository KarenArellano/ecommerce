window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.$ = window.jQuery = require('jquery');

window.Popper = require('popper.js').default;

require('bootstrap');

window.niceSelect = require('jquery-nice-select');

window.lightSlider = require('lightslider');