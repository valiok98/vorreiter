<template>
  <div id="component_inquiry_modal2">
    <modal v-if="showInquiryModal2">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>Anfrage erstellen</h5>
                <button class="modal-default-button" v-on:click="close()">X</button>
              </div>
              <div class="modal-body">
                <div id="dialog_anfrage-erstellen-2">
                  <div id="div_anfrage-erstellen-content" class="container-fluid">
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
                            <span>
                              <b>Ansprechpartner</b>
                            </span>
                            <br />
                            <span v-text="clientData.contactPerson"></span>
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
                        <inquiry_calculator></inquiry_calculator>
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
      showInquiryModal2: false,
    };
  },
  methods: {
    close: function () {
      this.showInquiryModal2 = false;
      this.$emit('close_inquiry_modal2');
    },
  },
  components: {
    inquiry_calculator,
  },
};
</script>

<style>
#component_inquiry_modal2 .modal-container {
  width: 50%;
  height: 90%;
  overflow-y: scroll;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

</style>