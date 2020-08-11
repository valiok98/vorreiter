import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import sidenav from './components/sidenav.vue';
import mainnav from './components/mainnav.vue';
import settings from './components/settings.vue';
import toast from './components/toast.vue';
import inquiry_theader from './components/inquiry_theader.vue';
import order_theader from './components/order_theader.vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);


new Vue({
    el: '#app',
    components: {
        sidenav,
        mainnav,
        settings,
        toast,
        inquiry_theader,
        order_theader
    }
});