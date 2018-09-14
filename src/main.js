// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import App from './App';
import router from './router';
import Store from './store/index.js';
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

import AxiosClient from './packages/axios_client/client.js';

Vue.use(AxiosClient);
Vue.use(Vuetify)


Vue.config.productionTip = false;

new Vue({
  el: '#app',
  store: Store,
  router,
  components: { App },
  template: '<App/>',
});
