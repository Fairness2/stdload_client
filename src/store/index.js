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
      сurrentAllotment: null
  },

  getters: {

  },

  mutations: {
      setData(state, {path, data}) {
          let parts = path.split('.'),
              last = parts.pop(),
              target = state;
          parts.forEach((part) => target = target[part]);

          return target[last] = data;
      },

      setPageLoader(state) {
          state.isPageLoaderShow = true;
      },

      removePageLoader(state) {
          state.isPageLoaderShow = false;
      },

  },

  actions: {

  }
});

export default store;