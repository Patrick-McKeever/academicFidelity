require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import routes from './routes';
import modalRoutes from './modalRoutes';

window.sheetViewApp = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    data: {
        currentSheet: {},
        spreadsheets: {}
    },
    methods: {
        getSpreadsheets(currentSheet) {
            var classId = currentSheet['classId'];
            axios.get('/class/' + classId).then((response) => {
                this.spreadsheets = response.data['spreadsheets']
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getSpreadsheets();
    }
});

window.modalApp = new Vue({
    el: '#modal',
    router: new VueRouter(modalRoutes)
});
