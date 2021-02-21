require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import routes from './routes';
import modalRoutes from './modalRoutes';
import 'handsontable/dist/handsontable.full.css';

Vue.use(VueRouter);

Vue.component('class-create', require('./components/resources/class/createClass.vue').default);
Vue.component('class-list', require('./components/resources/class/classList.vue').default);
Vue.component('group-list', require('./components/resources/group/groupList.vue').default);
Vue.component('spreadsheet-sidebar', require('./components/resources/spreadsheet/spreadsheetSidebar.vue').default);
Vue.component('read-spreadsheet', require('./components/resources/spreadsheet/readSpreadsheet.vue').default);
Vue.component('slg-list', require('./components/resources/slgs/slgList.vue').default);
Vue.component('sheet-table', require('./components/resources/spreadsheet/sheetAsTable.vue').default);
Vue.component('obs-list', require('./components/resources/evaluation/myObsList.vue').default);
Vue.component('teacher-list', require('./components/resources/teacher/teacherList').default);


window.app = new Vue({
    el: '#app',
    router: new VueRouter(routes)
});

Vue.prototype.$app = window.app;

window.modalApp = new Vue({
    el: '#modal',
    router: new VueRouter(modalRoutes)
});

Vue.prototype.$modalApp = window.modalApp;

