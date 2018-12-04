
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

//window.Vue = require('vue');
import Vue from 'vue';
//import App from './App';
import router from './router';
import store from './store/index.js';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import colors from 'vuetify/es5/util/colors';

import AxiosClient from './packages/axios_client/client.js';
import VueTippy from 'vue-tippy';

Vue.use(VueTippy);
Vue.use(AxiosClient);
Vue.use(Vuetify,{
    theme:{
        primary: '#1976D2',
        secondary: '#424242',
        accent: '#82B1FF',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107',
        header: '#1976D2'
    }
});

import StlLoader from './components/stlLoader';
import stlPageHome from  './components/stlPageHome';

Vue.config.productionTip = false;
const app = new Vue({
    el: '#app',
    components: { StlLoader, stlPageHome },
    store,
    router,
});
