<template>
  <div id="component_convert_inquiry_order_modal">
    <modal v-if="showConvertInquiryOrderModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>Anfrage in Auftrag umwandeln</h5>
                <button class="modal-default-button" v-on:click="close()">
                  <img v-bind:src="closeImg.src" v-bind:alt="closeImg.alt" />
                </button>
              </div>
              <div class="modal-body">
                
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
  name: "convert_inquiry_order_modal",
  props: ["showConvertInquiryOrderModal"],
  data: function () {
    return {
      closeImg: {
        src: "images/modal/close_window.gif",
        alt: "Close modal",
      },
    };
  },
  methods: {
    close: function () {
      this.showConvertInquiryOrderModal = false;
    },
  },
};
</script>

<style>
/* Component part. */
#component_convert_inquiry_order_modal {
  color: black;
}

#component_convert_inquiry_order_modal .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}

#component_convert_inquiry_order_modal p {
  text-decoration: underline;
}

#component_convert_inquiry_order_modal modal {
  position: absolute;
}
</style>