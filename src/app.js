import Vue from 'vue';
import { VuejsDatatableFactory } from 'vuejs-datatable';
import sidenav from './components/sidenav.vue';
import mainnav from './components/mainnav.vue';
import settings from './components/settings.vue';
import toast from './components/toast.vue';
import inquiry_theader from './components/inquiry_theader.vue';
import order_theader from './components/order_theader.vue';

Vue.use(VuejsDatatableFactory);

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