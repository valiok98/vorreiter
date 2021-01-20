import Vue from 'vue';
import Vuex from 'vuex';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import vSelect from 'vue-select';
import admin_content from './components/admin/admin_content.vue';
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
        clients: [],
    },
    mutations: {
        add_inquiry(state, inquiry) {
            state.inquiries = [inquiry, ...state.inquiries];
        },
        add_order(state, order) {
            state.orders = [order, ...state.orders];
        },
        add_client(state, client) {
            state.clients = [client, ...state.clients];
        },
        set_inquiries(state, inquiries) {
            state.inquiries = inquiries;
        },
        set_orders(state, orders) {
            state.orders = orders;
        },
        set_clients(state, clients) {
            state.clients = clients;
        },
        remove_inquiry_by_id(state, inquiry_id) {
            state.inquiries = state.inquiries.filter(inquiry => inquiry.id !== inquiry_id);
        },
        remove_order_by_id(state, order_id) {
            state.orders = state.orders.filter(order => order.id !== order_id);
        },
        remove_client_by_id(state, client_id) {
            state.clients = state.clients.filter(client => client.id !== client_id);
        }

    }
});


new Vue({
    el: '#admin',
    components: {
        admin_content,
        toast
    },
    store
});