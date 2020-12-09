<template>
  <div id="component_inquiry_theader">
    <img
      v-on:click="create_inquiry()"
      v-bind:class="img.inquiry.class"
      v-bind:src="img.inquiry.src"
      v-bind:alt="img.inquiry.alt"
    />
    <inquiry_modal1
      :showInquiryModal1="showInquiryModal1"
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
      img: {
        inquiry: {
          class: "img_anfrage-erstellen",
          src: "../images/an_auf_table/anfrage_erstellen.png",
          alt: "Create inquiry",
        },
      },
      showInquiryModal1: false,
    };
  },
  methods: {
    create_inquiry: function () {
      this.showInquiryModal1 = true;
    },
    close_inquiry_modal1: function ($event) {
      this.showInquiryModal1 = false;
      console.log($event);
    },
  },
  components: {
    inquiry_modal1,
    Snackbar
  },
};
</script>

<style>
#component_inquiry_theader img {
  height: 100%;
}
</style>