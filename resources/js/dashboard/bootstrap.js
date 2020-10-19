import validate from 'jquery-validation';
import 'jquery-validation/dist/localization/messages_es';
import 'jquery-validation/dist/additional-methods';

import Cleave from 'cleave.js';

import moment from 'moment';
import 'moment/locale/es';

import 'select2';

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
} catch (e) {
    console.error('bootstrap loader error', e)
}

window._ = require('lodash');

require('bootstrap');

require('jszip');
require('pdfmake');
require('datatables.net-dt');
require('datatables.net-buttons');
require('datatables.net-buttons/js/buttons.html5.js');
require('datatables.net-buttons/js/buttons.print.js');
require('datatables.net-responsive-dt');

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.feather = require('feather-icons');

window.PerfectScrollbar = require('perfect-scrollbar').default;

require('dropify');