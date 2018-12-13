import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
      selectedSemester: 3,
      selectedDimension: 1,
      dimensions: [
          {id: 1, text: 'По дсициплине',},
          {id: 2, text: 'По преподавателю',},
          {id: 3, text: 'По направлению',},
      ],
      semesters: [
          {id: 1, text: 'Осенний', value: 1},
          {id: 2, text: 'Весенний', value: 2},
          {id: 3, text: 'Все', value: 3},
      ],


      isLoad: false, //TODO true
      currentPage: null,

      currentSemester: 3,
      currentDimension: 1,

      allotments: [],
      сurrentAllotment: {},
      allotmentsCreateError: false,

      disciplines: [],
      currentDicipline: {},
      groups: [],
      currentGroup: {},
      loadElements: [],
      currentLoadElement: {},
      workers: [],
      currentWorker: {},

      threads:[],
      auditorys:[],

      headers: [
          {
              text: 'Преподаватель',
              align: 'left',
              sortable: false,
              value: 'name'
          },
          { text: 'Должность', value: 'position' },
          { text: 'Часов', value: 'hours' },
          { text: 'Доля', value: 'part' }
      ],

      peopleData:[],

      selectedThread:{},
      selectedAuditory:{}
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
          state.isLoad = value;
      }

  },

  actions: {
      async fetchAllotments({commit, dispatch}){
          const response = await Vue.axiosClient.client.get('/allotments'),
              list = response.data.status ? response.data.data : [];

          commit('setData', {path: 'allotments', value: list});
          commit('setData', {path: 'сurrentAllotment', value: {}});
      },

      async fetchDisciplineDisciplines({commit, dispatch}){

          let params = {
              'allotment_id': this.state.сurrentAllotment.id,
              'semester': this.state.selectedSemester,
          };

          const response = await Vue.axiosClient.client.get('/allotments/discipline/get_disciplines', params),
              list = response.data.status ? response.data.data : [];

          commit('setData', {path: 'disciplines', value: list});
          commit('setData', {path: 'currentDicipline', value: {}});
      },

      async fetchDisciplineGroups({commit, dispatch}){

          let params = {
              'allotment_id': this.state.сurrentAllotment.id,
              'semester': this.state.selectedSemester,
              'discipline': this.state.currentDicipline.id,
          };

          const response = await Vue.axiosClient.client.get('/allotments/discipline/get_groups', params),
              list = response.data.status ? response.data.data : [];

          commit('setData', {path: 'groups', value: list});
          commit('setData', {path: 'currentGroup', value: {}});
      },

      async fetchLoadElements({commit, dispatch}){

          let params = {
              'allotment_id': this.state.сurrentAllotment.id,
              'semester': this.state.selectedSemester,
              'discipline': this.state.currentDicipline.id,
              'group': this.state.currentGroup.id,
          };

          const response = await Vue.axiosClient.client.get('/allotments/discipline/get_elements', params),
              list = response.data.status ? response.data.data : [];

          commit('setData', {path: 'loadElements', value: list});
          commit('setData', {path: 'currentLoadElement', value: {}});
      },

      async updateAllotments({commit, dispatch}){
          commit('setLoader', true);
          await dispatch('fetchAllotments');
          commit('setLoader', false);
      },
      async createAllotment({commit, dispatch}, params){
          commit('setLoader', true);
          const response = await Vue.axiosClient.client.post('/allotments', params);
          if (response.data.status)
              await dispatch('fetchAllotments');
          commit('setLoader', false);
          return response.data.status;
      },

      async editAllotment({commit, dispatch}){
          commit('setLoader', true);
          const response = await Vue.axiosClient.client.post('/allotments/edit', this.state.сurrentAllotment);
          if (response.data.status)
              await dispatch('fetchAllotments');
          commit('setLoader', false);
          return response.data.status;
      },

      async removeAllotment({commit, dispatch}){
          commit('setLoader', true);
          let params = {'id': this.state.сurrentAllotment.id};
          const response = await Vue.axiosClient.client.post('/allotments/remove', params);
          if (response.data.status)
              await dispatch('fetchAllotments');
          commit('setLoader', false);
          return response.data.status;
      },

      async changeSemester({commit, dispatch}, val){
          commit('setLoader', true);
          commit('setData', {path: 'selectedSemester', value: val});

          await dispatch('fetchDisciplineDisciplines');

          commit('setLoader', false);
      },
  }

});

export default store;