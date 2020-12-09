<template>
  <div id="component_order_theader">
    <img
      v-on:click="create_order()"
      v-bind:class="img.order.class"
      v-bind:src="img.order.src"
      v-bind:alt="img.order.alt"
    />
    <order_modal1 :showOrderModal1="showOrderModal1" v-on:close_order_modal1="close_order_modal1()"></order_modal1>
  </div>
</template>

<script>
import order_modal1 from "./order_modal1.vue";
export default {
  name: "order_theader",
  data: function () {
    return {
      img: {
        order: {
          class: "img_auftrag-erstellen",
          src: "../images/an_auf_table/auftrag_erstellen.png",
          alt: "Create order",
        },
      },
      showOrderModal1: false,
    };
  },
  methods: {
    create_order: function () {
      this.showOrderModal1 = true;
    },
    close_order_modal1: function () {
      this.showOrderModal1 = false;
    },
  },
  components: {
    order_modal1,
  }
};
</script>

<style>
</style>