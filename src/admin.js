import Vue from 'vue';
import Vuex from 'vuex';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import vSelect from 'vue-select';
import sidenav from './components/admin/sidenav.vue';
import mainnav from './components/admin/mainnav.vue';
import settings from './components/admin/settings.vue';
import inquiry_theader from './components/admin/inquiry_theader.vue';
import order_theader from './components/admin/order_theader.vue';
import inquiry_order_theader from './components/admin/inquiry_order_theader.vue';
import inquiry_detail from './components/admin/inquiry_detail.vue';
import order_detail from './components/admin/order_detail.vue';
import inquiry_table from './components/admin/inquiry_table.vue';
import order_table from './components/admin/order_table.vue';
import create_client_button from './components/admin/create_client_button.vue';
import convert_inquiry_order_modal from './components/admin/convert_inquiry_order_modal.vue';
import toast from './components/general/toast.vue';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import "vue-select/dist/vue-select.css";

Vue.use(Vuex);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.component('v-select', vSelect);

const store = new Vuex.Store({
    state: {
        inquiries: [],
        orders: [],
    },
    mutations: {
        add_inquiry(state, inquiry) {
            state.inquiries = [inquiry, ...state.inquiries];
        },
        add_order(state, order) {
            state.orders = [order, ...state.orders];
        },
        set_inquiries(state, inquiries) {
            state.inquiries = inquiries;
        },
        set_orders(state, orders) {
            state.orders = orders;
        },
        remove_inquiry_by_id(state, inquiry_id) {
            state.inquiries = state.inquiries.filter(inquiry => inquiry.id !== inquiry_id);
        },
        remove_order_by_id(state, order_id) {
            state.orders = state.orders.filter(order => order.id !== order_id);
        }

    }
});


new Vue({
    el: '#admin',
    components: {
        sidenav,
        mainnav,
        settings,
        inquiry_theader,
        order_theader,
        inquiry_order_theader,
        inquiry_detail,
        order_detail,
        inquiry_table,
        order_table,
        create_client_button,
        convert_inquiry_order_modal,
        toast
    },
    store
});