<template>
  <div id="component_create_client_button">
    <div id="div_button_wrapper">
      <b-button
        value="abs"
        variant="success"
        class="btn btn-primary"
        v-on:click="show_client_modal = true"
      >
        <img v-bind:src="checkmark_img.src" v-bind:alt="checkmark_img.alt" />
        <div class="div_small_border">
          <p></p>
        </div>
        <div>
          <h4>Kunden erstellen</h4>
        </div>
      </b-button>
    </div>
    <client_modal
      :show_client_modal="show_client_modal"
      :client_type="client_type"
      v-on:close_client_modal="close_client_modal()"
    ></client_modal>
  </div>
</template>

<script>
import client_modal from "./client_modal.vue";

export default {
  name: "create_client_button",
  data: function () {
    return {
      checkmark_img: {
        src: "img/checkmark.png",
        alt: "Kunden erstellen",
      },
      show_client_modal: false,
      client_type: "order",
    };
  },
  methods: {
    close_client_modal: function () {
      this.show_client_modal = false;
    },
  },
  components: {
    client_modal,
  },
};
</script>

<style>
#component_create_client_button #div_button_wrapper button {
  float: left;
  display: flex;
  flex-flow: row nowrap;
  justify-content: space-between;
  align-items: center;
}

#component_create_client_button #div_button_wrapper .div_small_border {
  border-left: 2px solid white;
  height: 45px;
  margin-left: 5px;
  margin-right: 5px;
}

#component_create_client_button #div_button_wrapper h4 {
  margin: 0;
}
</style>
