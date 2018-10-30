// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import App from './App';
import router from './router';
import Store from './store/index.js';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import colors from 'vuetify/es5/util/colors';

import AxiosClient from './packages/axios_client/client.js';

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


Vue.config.productionTip = false;

new Vue({
  el: '#app',
  store: Store,
  router,
  components: { App },
  template: '<App/>',
});
