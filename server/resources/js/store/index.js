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
      currentAllotment: {},
      allotmentsCreateError: false,

      disciplines: [],
      currentDicipline: {},
      groups: [],
      currentGroup: {},
      loadElements: [],
      currentLoadElement: {},
      workers: [],
      currentWorker: null,

      threads:[],
      auditorys:[],

      headers: [
          {
              text: 'Преподаватель',
              align: 'left',
              sortable: false,
              value: 'fio'
          },
          { text: 'Группа', value: 'group' },
          { text: 'Занятие', value: 'type_class' }
      ],

      peopleData:[],

      selectedThread:null,
      selectedAuditory:null
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
          commit('setData', {path: 'currentAllotment', value: {}});
      },

      async fetchDisciplineDisciplines({commit, dispatch}){

          let params = {
              'allotment_id': this.state.currentAllotment.id,
              'semester': this.state.selectedSemester,
          };

          const response = await Vue.axiosClient.client.get('/hi_discipline/get_disciplines', {params}),
              list = response.data.status ? response.data.data : [];

          commit('setData', {path: 'disciplines', value: list});
          commit('setData', {path: 'currentDicipline', value: {}});
      },

      async fetchDisciplineGroups({commit, dispatch}){

          let params = {
              'allotment_id': this.state.currentAllotment.id,
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
              'allotment_id': this.state.currentAllotment.id,
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
          const response = await Vue.axiosClient.client.post('/allotments/edit', this.state.currentAllotment);
          if (response.data.status)
              await dispatch('fetchAllotments');
          commit('setLoader', false);
          return response.data.status;
      },

      async removeAllotment({commit, dispatch}){
          commit('setLoader', true);
          let params = {'id': this.state.currentAllotment.id};
          const response = await Vue.axiosClient.client.post('/allotments/remove', params);
          if (response.data.status)
              await dispatch('fetchAllotments');
          commit('setLoader', false);
          return response.data.status;
      },

      async changeSemester({commit, dispatch}, val){
          commit('setLoader', true);
          commit('setData', {path: 'selectedSemester', value: val});

          await dispatch('fetchHiDisciplineDisciplines');

          commit('setLoader', false);
      },

      async updateHiDiscipline({commit, dispatch}){
          commit('setLoader', true);
          if (Object.keys(this.state.currentAllotment).length === 0){
              await dispatch('fetchAllotment');
          }
          await dispatch('fetchWorkers');
          await dispatch('fetchThreads');
          await dispatch('fetchClassrooms');
          await dispatch('fetchHiDisciplineDisciplines');
          commit('setLoader', false);
      },

      async fetchAllotment({commit, dispatch}){
          let allotmentId = this.state.route.params.id;
          const response = await Vue.axiosClient.client.get('/allotments/get_allotment',  {
                  params: {
                      id: allotmentId
                  }
              }),
              list = response.data.status ? response.data.data : {};

          commit('setData', {path: 'currentAllotment', value: list});
      },

      async fetchWorkers({commit, dispatch}){
          const response = await Vue.axiosClient.client.get('/workers/get_workers'),
              list = response.data.status ? response.data.data : {};

          commit('setData', {path: 'workers', value: list});
          commit('setData', {path: 'currentWorker', value: null});
      },

      async fetchThreads({commit, dispatch}){
          let params = {
              'allotment': this.state.currentAllotment.id,
          };
          const response = await Vue.axiosClient.client.get('/flows/get_flows', {params}),
              list = response.data.status ? response.data.data : {};

          commit('setData', {path: 'threads', value: list});
          commit('setData', {path: 'selectedThread', value: null});
      },

      async fetchClassrooms({commit, dispatch}){
          const response = await Vue.axiosClient.client.get('/classrooms/get_classrooms'),
              list = response.data.status ? response.data.data : {};

          commit('setData', {path: 'auditorys', value: list});
          commit('setData', {path: 'selectedAuditory', value: null});
      },

      async fetchHiDisciplineDisciplines({commit, dispatch}){
          let params = {
              'allotment': this.state.currentAllotment.id,
              'semester': this.state.currentSemester,
          };
          const response = await Vue.axiosClient.client.get('/hi_discipline/get_disciplines', {params}),
              list = response.data.status ? response.data.data : [];

          commit('setData', {path: 'disciplines', value: list});
          commit('setData', {path: 'currentDicipline', value: {}});
      },

      async updateHiDisciplineDiscipline({commit, dispatch}){
          commit('setLoader', true);
          await dispatch('fetchHiDisciplineDisciplines');
          commit('setLoader', false);
      },

      async updateHiDisciplineGroup({commit, dispatch}){
          commit('setLoader', true);
          await dispatch('fetchHiDisciplineGroups');
          commit('setLoader', false);
      },

      async fetchHiDisciplineGroups({commit, dispatch}){
          let params = {
              'allotment': this.state.currentAllotment.id,
              'semester': this.state.currentSemester,
              'discipline': this.state.currentDicipline.id,
          };
          const response = await Vue.axiosClient.client.get('/hi_discipline/get_groups', {params}),
              list = response.data.status ? response.data.data.groups : [],
              listWorker = response.data.status ? response.data.data.distributionElements : [];

          commit('setData', {path: 'groups', value: list});
          commit('setData', {path: 'currentGroup', value: {}});
          commit('setData', {path: 'peopleData', value: listWorker});
      },

      async updateHiDisciplineLoadElements({commit, dispatch}){
          commit('setLoader', true);
          await dispatch('fetchHiDisciplineLoadElements');
          commit('setLoader', false);
      },

      async fetchHiDisciplineLoadElements({commit, dispatch}){
          let params = {
              'allotment': this.state.currentAllotment.id,
              'semester': this.state.currentSemester,
              'discipline': this.state.currentDicipline.id,
              'group': this.state.currentGroup.id,
          };
          const response = await Vue.axiosClient.client.get('/hi_discipline/get_load_elements', {params}),
              list = response.data.status ? response.data.data : [];

          commit('setData', {path: 'loadElements', value: list});
          commit('setData', {path: 'currentLoadElement', value: {}});
      },

      async updateHiDisciplineLoadElement({commit, dispatch}){
          commit('setLoader', true);
          await dispatch('fetchHiDisciplineLoadElement');
          commit('setLoader', false);
      },

      async fetchHiDisciplineLoadElement({commit, dispatch}){
          let params = {
              'load_element': this.state.currentLoadElement.id,
          };
          const response = await Vue.axiosClient.client.get('/hi_discipline/get_load_element', {params}),
              list = response.data.status ? response.data.data : {};

          let worker_id = null;
          let thread_id = null;
          let classroom_id = null;
          if (Object.keys(list !== 0)){
              worker_id = list.worker_id;
              thread_id = list.flow_id;
              classroom_id = list.classroom_id;
          }
          commit('setData', {path: 'currentLoadElement', value: list});
          commit('setData', {path: 'currentWorker', value: worker_id});
          commit('setData', {path: 'selectedThread', value: thread_id});
          commit('setData', {path: 'selectedAuditory', value: classroom_id});
      },

      async saveChangeLoadElement({commit, dispatch}){
          commit('setLoader', true);
          let params = {
              'id': this.state.currentLoadElement.id,
              'thread': this.state.selectedThread,
              'classroom': this.state.selectedAuditory,
              'need_interactive_board': this.state.currentLoadElement.need_interactive_board,
              'need_multimedia_classroom': this.state.currentLoadElement.need_multimedia_classroom,
              'need_marker_board': this.state.currentLoadElement.need_marker_board,
              'comment': this.state.currentLoadElement.comment,
              'hours_first_before': this.state.currentLoadElement.hours_first_before,
              'hours_second_befor': this.state.currentLoadElement.hours_second_befor,
              'fours_first_after': this.state.currentLoadElement.fours_first_after,
              'hours_second_after': this.state.currentLoadElement.hours_second_after,
          };
          const response = await Vue.axiosClient.client.post('/load_elements/set_load_element', params),
              res = response.data.status;

          commit('setLoader', false);
          return res;
      },

      async setWorkerLoadElementHiDiscipline({commit, dispatch}){
          commit('setLoader', true);
          let params = {
              'load_element': this.state.currentLoadElement.id,
              'worker': this.state.currentWorker,
          };
          const response = await Vue.axiosClient.client.post('/load_elements/set_worker', params),
              res = response.data.status;

          if (res) {
              let elem = this.state.currentLoadElement;
              await dispatch('fetchHiDisciplineLoadElements');
              commit('setData', {path: 'currentLoadElement', value: elem});
          }
          commit('setLoader', false);
          return res;
      },

      async setWorkerGroupHiDiscipline({commit, dispatch}){
          commit('setLoader', true);
          let params = {
              'allotment': this.state.currentAllotment.id,
              'discipline': this.state.currentDicipline.id,
              'group': this.state.currentGroup.id,
              'worker': this.state.currentWorker,
          };
          const response = await Vue.axiosClient.client.post('/hi_discipline/set_worker_group', params),
              res = response.data.status;

          if (res) {
              await dispatch('fetchHiDisciplineLoadElements');
          }
          commit('setLoader', false);
          return res;
      },

      async setWorkerDisciplineHiDiscipline({commit, dispatch}){
          commit('setLoader', true);
          let params = {
              'allotment': this.state.currentAllotment.id,
              'discipline': this.state.currentDicipline.id,
              'worker': this.state.currentWorker,
          };
          const response = await Vue.axiosClient.client.post('/hi_discipline/set_worker_discipline', params),
              res = response.data.status;

          if (res) {
              await dispatch('fetchHiDisciplineGroups');
          }
          commit('setLoader', false);
          return res;
      },
  }

});

export default store;