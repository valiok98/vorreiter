<template>
  <div id="component_inquiry_theader">
    <img
      v-on:click="create_inquiry()"
      v-bind:src="create_img.src"
      v-bind:alt="create_img.alt"
    />
    <inquiry_modal1
      :show_inquiry_modal1="show_inquiry_modal1"
      v-on:close_inquiry_modal1="close_inquiry_modal1($event)"
    ></inquiry_modal1>
    <snackbar ref="snackbar" baseSize="100px" position="bottom-right"></snackbar>
  </div>
</template>

<script>
import inquiry_modal1 from "./inquiry_modal1.vue";
import Snackbar from "vuejs-snackbar";

export default {
  name: "inquiry_theader",
  data: function () {
    return {
      create_img: {
        src: "img/create_inquiry.png",
        alt: "Anfrage erstellen",
      },
      show_inquiry_modal1: false,
    };
  },
  methods: {
    create_inquiry: function () {
      this.show_inquiry_modal1 = true;
    },
    close_inquiry_modal1: function ($event) {
      this.show_inquiry_modal1 = false;
    },
  },
  components: {
    inquiry_modal1,
    Snackbar,
  },
};
</script>

<style>
#component_inquiry_theader img {
  height: 100%;
  cursor: pointer;
}
</style>
