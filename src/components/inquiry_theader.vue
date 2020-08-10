<template>
  <div id="component_inquiry_theader" class="row div_table-header">
    <h3>Anfragen</h3>
    <div>
      <img v-bind:src="img.eye.src" v-bind:alt="img.eye.alt" />
      <img
        v-on:click="create_inquiry()"
        v-bind:class="img.inquiry.class"
        v-bind:src="img.inquiry.src"
        v-bind:alt="img.inquiry.alt"
      />
    </div>
    <inquiry_dialog1 :showModal="showModal" v-on:close_dialog="close_dialog()"></inquiry_dialog1>
  </div>
</template>

<script>
import inquiry_dialog1 from "./inquiry_dialog1.vue";

export default {
  name: "inquiry_theader",
  data: function () {
    return {
      img: {
        eye: {
          src: "../images/an_auf_table/eye.png",
          alt: "View inquiries",
        },
        inquiry: {
          class: "img_anfrage-erstellen",
          src: "../images/an_auf_table/anfrage_erstellen.png",
          alt: "Create inquiry",
        },
      },
      showModal: false,
    };
  },
  methods: {
    create_inquiry: function () {
      this.showModal = true;
    },
    close_dialog: function () {
      this.showModal = false;
    },
  },
  components: {
    inquiry_dialog1,
  },
};
</script>

<style>
#component_inquiry_theader img {
  height: 100%;
}
</style>