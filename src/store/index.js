import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
      currentUser: {
        login: 'test@test.test',
        name: 'Константин К'
      },
      isPageLoaderShow: false, //TODO true
      currentPage: null,
      isCurrentAllotment: null
  },

  getters: {

  },

  mutations: {

  },

  actions: {

  }
});

export default store;