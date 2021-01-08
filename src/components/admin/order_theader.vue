<template>
  <div id="component_order_theader">
    <img
      v-on:click="create_order()"
      v-bind:src="create_img.src"
      v-bind:alt="create_img.alt"
    />
    <order_modal1
      :show_order_modal1="show_order_modal1"
      v-on:close_order_modal1="close_order_modal1()"
    ></order_modal1>
  </div>
</template>

<script>
import order_modal1 from "./order_modal1.vue";
export default {
  name: "order_theader",
  data: function () {
    return {
      create_img: {
        src: "img/create_order.png",
        alt: "Auftrag erstellen",
      },
      show_order_modal1: false,
    };
  },
  methods: {
    create_order: function () {
      this.show_order_modal1 = true;
    },
    close_order_modal1: function () {
      this.show_order_modal1 = false;
    },
  },
  components: {
    order_modal1,
  },
};
</script>

<style>
#component_order_theader img {
  cursor: pointer;
}
</style>
