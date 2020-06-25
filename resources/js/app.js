require('./bootstrap'); 

window.Vue = require('vue')
import router from './router'
import store from './store'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import common from './common';

//support moment js
import Filter from './filter'

Vue.mixin(common)
Vue.use(ViewUI);

Vue.component('mainapp', require('./components/mainapp.vue').default)
 
const app = new Vue({
    el:'#app',
    router,
    Filter,
    store
})