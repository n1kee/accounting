import { createApp } from 'vue';
import Report from './components/Report';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

import '../styles/app.css';

import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

window.axios = require('axios');

const vuetify = createVuetify({
    components,
    directives
});

const app = createApp({
    components: {
        report: Report
    }
});

app.component('VueDatePicker', VueDatePicker);

app.use(vuetify).mount('#app');
