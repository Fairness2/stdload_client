import Vue from 'vue';
import Router from 'vue-router';
import StlPageAllotments from '../components/stlPageAllotments';
import StlPageHiDiscipline from '../components/stlPageHiDiscipline';
import StlPageAdmin from '../components/admin/stlPageAdmin';
import StlPageAdminRole from '../components/admin/stlPageAdminRole';
import StlPageAdminTypeClass from '../components/admin/stlPageAdminTypeClass';
import StlPageAdminQualification from '../components/admin/stlPageAdminQualification';
import StlPageAdminPosition from '../components/admin/stlPageAdminPosition';
import StlPageAdminFaculty from '../components/admin/stlPageAdminFaculty';
import StlPageAdminDiscipline from '../components/admin/stlPageAdminDiscipline';
import StlPageAdminBuilding from '../components/admin/stlPageAdminBuilding';
import StlPageAdminClassroom from '../components/admin/stlPageAdminClassroom';
import StlPageAdminSpecialty from '../components/admin/stlPageAdminSpecialty';
import StlPageAdminRequirementFgos from '../components/admin/stlPageAdminRequirementFgos';
import StlPageAdminGroup from '../components/admin/stlPageAdminGroup';
import StlPageAdminFlow from '../components/admin/stlPageAdminFlow';
import StlPageAdminUser from '../components/admin/stlPageAdminUser';
import StlPageAdminWorker from '../components/admin/stlPageAdminWorker';
import StlPageAdminDegreesWorker from '../components/admin/stlPageAdminDegreesWorker';
import StlPageAdminPositionWorker from '../components/admin/stlPageAdminPositionWorker';
import StlPageAdminRateWorker from '../components/admin/stlPageAdminRateWorker';
import StlPageAdminStaffWorker from '../components/admin/stlPageAdminStaffWorker';
import StlPageAdminTrainedWorker from '../components/admin/stlPageAdminTrainedWorker';


Vue.use(Router);

const routes = [
    {
        name: 'pageAllotments',
        path: '/page/allotments',
        component: StlPageAllotments,
    },
    {
        name: 'homePage',
        path: '/home',
        redirect: {name: 'pageAllotments'},
        component: StlPageAllotments
    },
    {
        name: 'hiDiscipline',
        path: '/page/hi_discipline/:id',
        component: StlPageHiDiscipline
    },
    {
        name: 'admin',
        path: '/admin',
        component: StlPageAdmin,
    },
    {
        name: 'admin_roles',
        path: '/admin/roles',
        component: StlPageAdminRole,
    },
    {
        name: 'admin_type_class',
        path: '/admin/type_class',
        component: StlPageAdminTypeClass,
    },
    {
        name: 'admin_qualification',
        path: '/admin/qualification',
        component: StlPageAdminQualification,
    },
    {
        name: 'admin_position',
        path: '/admin/position',
        component: StlPageAdminPosition,
    },
    {
        name: 'admin_faculty',
        path: '/admin/faculty',
        component: StlPageAdminFaculty,
    },
    {
        name: 'admin_discipline',
        path: '/admin/discipline',
        component: StlPageAdminDiscipline,
    },
    {
        name: 'admin_building',
        path: '/admin/building',
        component: StlPageAdminBuilding,
    },
    {
        name: 'admin_classroom',
        path: '/admin/classroom',
        component: StlPageAdminClassroom,
    },
    {
        name: 'admin_specialty',
        path: '/admin/specialty',
        component: StlPageAdminSpecialty,
    },
    {
        name: 'admin_requirement_fgos',
        path: '/admin/requirement_fgos',
        component: StlPageAdminRequirementFgos,
    },
    {
        name: 'admin_group',
        path: '/admin/group',
        component: StlPageAdminGroup,
    },
    {
        name: 'admin_flow',
        path: '/admin/flow',
        component: StlPageAdminFlow,
    },
    {
        name: 'admin_user',
        path: '/admin/user',
        component: StlPageAdminUser,
    },
    {
        name: 'admin_worker',
        path: '/admin/worker',
        component: StlPageAdminWorker,
    },
    {
        name: 'admin_degrees_worker',
        path: '/admin/degrees_worker',
        component: StlPageAdminDegreesWorker,
    },
    {
        name: 'admin_position_worker',
        path: '/admin/position_worker',
        component: StlPageAdminPositionWorker,
    },
    {
        name: 'admin_rate_worker',
        path: '/admin/rate_worker',
        component: StlPageAdminRateWorker,
    },
    {
        name: 'admin_staff_worker',
        path: '/admin/staff_worker',
        component: StlPageAdminStaffWorker,
    },
    {
        name: 'admin_trained_worker',
        path: '/admin/trained_worker',
        component: StlPageAdminTrainedWorker,
    },

];

export default new Router({
  mode: 'history',
  routes,
  scrollBehavior(to, from, savedPosition) {
      return {x: 0, y: 0} //сброс позиции прокрутки при переходе по ссылкам
  },
})
