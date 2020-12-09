<template>
  <div id="component_delete_package_modal">
    <modal v-if="showDeletePackageModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div id="delete_package_modal_container" class="modal-container">
              <div class="modal-header">
                <h5>{{ modalHeader }}</h5>
                <button class="modal-default-button" v-on:click="close()">
                  <img v-bind:src="closeImg.src" v-bind:alt="closeImg.alt" />
                </button>
              </div>
              <div class="modal-body">{{ modalBody }}</div>
              <div class="modal-footer">
                <b-button v-on:click="close()" variant="light">Cancel</b-button>
                <b-button v-on:click="confirm_deletion()" variant="primary"
                  >Delete</b-button
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
  props: ["showDeletePackageModal", "packageId", "modalHeader", "modalBody"],
  data: function () {
    return {
      closeImg: {
        src: "../images/modal/close_window.gif",
        alt: "Close modal",
      },
    };
  },
  methods: {
    close: function () {
      this.showDeletePackageModal = false;
      this.$emit("cancel_item_deletion");
    },
    confirm_deletion: function () {
      this.showDeletePackageModal = false;
      this.$emit("confirm_item_deletion", this.packageId);
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