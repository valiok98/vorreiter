import Vue from 'vue';
import sidenav from './components/sidenav.vue';
import mainnav from './components/mainnav.vue';
import settings from './components/settings.vue';
import toast from './components/toast.vue';
import inquiry_dialog2 from './components/inquiry_dialog2.vue';
import order_dialog1 from './components/order_dialog1.vue';
import order_dialog2 from './components/order_dialog2.vue';
import inquiry_theader from './components/inquiry_theader.vue';
import order_theader from './components/order_theader.vue';

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