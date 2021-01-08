import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import main_login_form from './components/index/main_login_form.vue';
import change_password from './components/index/change_password.vue';
import toast from './components/general/toast.vue';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import "vue-select/dist/vue-select.css";

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

new Vue({
    el: '#index',
    components: {
        main_login_form,
        change_password,
        toast
    },
});