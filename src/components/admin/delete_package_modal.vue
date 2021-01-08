<template>
  <div id="component_delete_package_modal">
    <modal v-if="show_delete_package_modal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div id="delete_package_modal_container" class="modal-container">
              <div class="modal-header">
                <h5>{{ modal_header }}</h5>
                <button class="modal-default-button" v-on:click="close()">
                  <img v-bind:src="close_img.src" v-bind:alt="close_img.alt" />
                </button>
              </div>
              <div class="modal-body">{{ modal_body }}</div>
              <div class="modal-footer">
                <b-button v-on:click="close()" variant="light">Cancel</b-button>
                <b-button v-on:click="confirm_deletion()" variant="primary"
                  >Löschen</b-button
                >
              </div>
            </div>
          </div>
        </div>
      </transition>
    </modal>
  </div>
</template>

<script>
export default {
  name: "delete_package_modal",
  props: ["show_delete_package_modal", "package_id", "modal_header", "modal_body"],
  data: function () {
    return {
      close_img: {
        src: "img/close_window.png",
        alt: "Fenster schließen",
      },
    };
  },
  methods: {
    close: function () {
      this.show_delete_package_modal = false;
      this.$emit("cancel_item_deletion");
    },
    confirm_deletion: function () {
      this.show_delete_package_modal = false;
      this.$emit("confirm_item_deletion", this.package_id);
    },
  },
};
</script>

<style>
#component_delete_package_modal #delete_package_modal_container {
  width: 30%;
  height: 30%;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

#component_delete_package_modal .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}
</style>