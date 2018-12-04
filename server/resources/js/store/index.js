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

      allotments: {
          121: {id: '121', name: 'Распределение 1', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: true},
          122: {id: '122', name: 'Распределение 2', year:'2017-2018', all_hours: 64, dis_hours: 64, primary: false},
          123: {id: '123', name: 'Распределение 3', year:'2017-2018', all_hours: 64, dis_hours: 72, primary: true},
          124: {id: '124', name: 'Распределение 4', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
          125: {id: '125', name: 'Распределение 5', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
          126: {id: '126', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: true},
          127: {id: '127', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: true},
          128: {id: '128', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
          129: {id: '129', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
          130: {id: '130', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
          131: {id: '131', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
          132: {id: '132', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
          133: {id: '133', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
          134: {id: '134', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
          135: {id: '135', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
          136: {id: '136', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
          137: {id: '137', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
          138: {id: '138', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32, primary: false},
      },
      сurrentAllotment: null,
  },

  getters: {
      csrf: () => document.getElementById('csrf').content,
  },

  mutations: {
      setData(state, {path, data}) {
          let parts = path.split('.'),
              last = parts.pop(),
              target = state;
          parts.forEach((part) => target = target[part]);

          return target[last] = data;
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
          await dispatch('fetchRoles');
          commit('setLoader', false);
      }
  }

});

export default store;