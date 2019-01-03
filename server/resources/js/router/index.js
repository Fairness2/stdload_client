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

];

export default new Router({
  mode: 'history',
  routes,
  scrollBehavior(to, from, savedPosition) {
      return {x: 0, y: 0} //сброс позиции прокрутки при переходе по ссылкам
  },
})
