<template>
  <div id="component_order_theader" class="row div_table-header">
    <h3>Aufträge</h3>
    <div>
      <img v-bind:src="img.eye.src" v-bind:alt="img.eye.alt" />
      <img
        v-on:click="create_order()"
        v-bind:class="img.order.class"
        v-bind:src="img.order.src"
        v-bind:alt="img.order.alt"
      />
    </div>
    <order_dialog1 v-bind:showModal="showModal" v-on:close_dialog="close_dialog()"></order_dialog1>
  </div>
</template>

<script>
import order_dialog1 from "./order_dialog1.vue";
export default {
  name: "order_theader",
  data: function () {
    return {
      img: {
        eye: {
          src: "../images/an_auf_table/eye.png",
          alt: "View orders",
        },
        order: {
          class: "img_auftrag-erstellen",
          src: "../images/an_auf_table/auftrag_erstellen.png",
          alt: "Create order",
        },
      },
      showModal: false,
    };
  },
  methods: {
    create_order: function () {
      this.showModal = true;
    },
    close_dialog: function () {
      this.showModal = false;
    }
  },
  components: {
    order_dialog1,
  },
};
</script>

<style>
</style>