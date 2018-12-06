import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {

      currentUser: {
        login: 'test@test.test',
        name: 'Константин К'
      },
      isLoad: false, //TODO true
      currentPage: null,

      currentSemester: 3,

      allotments: [
          {id: '121', name: 'Распределение 1', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: true},
          {id: '122', name: 'Распределение 2', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 64, is_main: false},
          {id: '123', name: 'Распределение 3', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 72, is_main: true},
          {id: '124', name: 'Распределение 4', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
          {id: '125', name: 'Распределение 5', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
          {id: '126', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: true},
          {id: '127', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: true},
          {id: '128', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
          {id: '129', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
          {id: '130', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
          {id: '131', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
          {id: '132', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
          {id: '133', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
          {id: '134', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
          {id: '135', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
          {id: '136', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
          {id: '137', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
          {id: '138', name: 'Распределение 6', year_begin:'2017', year_end:'2018', all_hours: 64, dis_hours: 32, is_main: false},
      ],
      сurrentAllotment: {},
  },

  getters: {
      csrf: () => document.getElementById('csrf-token').content,
  },

  mutations: {
      setData(state, {path, value}) {
          let parts = path.split('.'),
              last = parts.pop(),
              target = state;
          parts.forEach((part) => target = target[part]);

          return target[last] = value;
      },

      setLoader(state, value) {
          state.isLoading = value;
      }

  },

  actions: {
      async fetchAllotments({commit, dispatch}){
          const response = await Vue.axiosClient.client.get('/allotments'),
              list = response.data.data;
              //current = list[0] || {};

          commit('setData', {path: 'allotments', value: list});
          commit('setData', {path: 'сurrentAllotment', value: {}});
      },
      async updateAllotments({commit, dispatch}){
          commit('setLoader', true);
          //await dispatch('fetchRoles');
          commit('setLoader', false);
      }
  }

});

export default store;