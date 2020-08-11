<template>
  <div id="component_plain_modal">
    <modal v-if="showPlainModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div id="modal_anfrage-erstellen-1" class="modal-container">
              <div class="modal-header">
                <h5>{{modalHeader}}</h5>
                <button class="modal-default-button" v-on:click="close()">X</button>
              </div>
              <div class="modal-body">{{modalBody}}</div>
              <div class="modal-footer">
                <b-button v-on:click="close()" variant="light">Cancel</b-button>
                <b-button v-on:click="confirm_deletion()" variant="primary">Delete</b-button>
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
  name: "plain_modal",
  props: ["showPlainModal", "packageId", "modalHeader", "modalBody"],
  methods: {
    close: function () {
      this.showPlainModal = false;
      this.$emit("cancel_item_deletion");
    },
    confirm_deletion: function () {
      this.showPlainModal = false;
      this.$emit("confirm_item_deletion", this.packageId);
    },
  },
};
</script>

<style>
#component_plain_modal .modal-container {
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
</style>