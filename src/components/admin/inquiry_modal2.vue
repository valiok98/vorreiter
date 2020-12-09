<template>
  <div id="component_inquiry_modal2">
    <modal v-if="showInquiryModal2">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>Anfrage erstellen</h5>
                <button class="modal-default-button" v-on:click="close()">
                  <img v-bind:src="closeImg.src" v-bind:alt="closeImg.alt" />
                </button>
              </div>
              <div class="modal-body">
                <div>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-sm-6 container-fluid">
                        <div class="row">
                          <div class="col-sm-6">
                            <h5>Auftraggeber</h5>
                            <span>
                              <b>Firmenname</b>
                            </span>
                            <br />
                            <span v-text="clientData.companyName"></span>
                            <br />
                          </div>
                          <div class="col-sm-6">
                            <br />
                            <span>
                              <b>Kundennummer</b>
                            </span>
                            <br />
                            <span v-text="clientData.clientId"></span>
                            <br />
                            <span>
                              <b>Telefon</b>
                            </span>
                            <br />
                            <span v-text="clientData.phone"></span>
                            <br />
                            <span>
                              <b>E-Mail-Adresse</b>
                            </span>
                            <br />
                            <span v-text="clientData.email"></span>
                          </div>
                        </div>
                      </div>
                      <div
                        id="div_anfrage-versandrechner"
                        class="col-sm-6 div_versandrechner-wrapper"
                      >
                        <inquiry_calculator
                          :clientData="clientData"
                          v-on:close_inquiry_modal2="close()"
                        ></inquiry_calculator>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </modal>
  </div>
</template>

<script>
import inquiry_calculator from "./inquiry_calculator.vue";

export default {
  name: "inquiry_modal2",
  props: ["showInquiryModal2", "clientData"],
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
      this.showInquiryModal2 = false;
      this.$emit("close_inquiry_modal2");
    },
  },
  components: {
    inquiry_calculator,
  },
};
</script>

<style>
#component_inquiry_modal2 .modal-container {
  overflow-y: scroll;
  width: 75%;
  height: 90%;
}

#component_inquiry_modal2 .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}
</style>