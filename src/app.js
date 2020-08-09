import Vue from 'vue';
import sidenav from './components/sidenav.vue';
import mainnav from './components/mainnav.vue';


new Vue({
    el: '#app',
    components: {
        sidenav,
        mainnav
    }
});