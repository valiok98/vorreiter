<template>
  <div id="component_order_modal2">
    <modal v-if="showOrderModal2">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>Auftrag erstellen</h5>
                <button class="modal-default-button" v-on:click="close()">
                  <img v-bind:src="closeImg.src" v-bind:alt="closeImg.alt" />
                </button>
              </div>
              <div class="modal-body">
                <div>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-sm-6 container-fluid">
                        <form id="ordAddressForm" class="m-form">
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
                          <div class="row">
                            <br />
                          </div>
                          <!-- Part for the pickup address. -->
                          <div class="row">
                            <div class="col-sm-6">
                              <h5>Abholadresse</h5>
                            </div>
                            <div class="col-sm-6">
                              <h6>ist gleich dem Auftraggeber</h6>
                              <input
                                type="checkbox"
                                value="0"
                                v-model="from.sameAddress"
                              />
                            </div>
                          </div>
                          <div v-if="!from.sameAddress.length">
                            <div class="row">
                              <div class="col-sm-6">
                                <span>
                                  <b>Firmenname</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Firmenname ..."
                                    required
                                    v-model="from.companyName"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <span>
                                <b>Ansprechpartner</b>
                              </span>
                              <div class="container-fluid">
                                <div class="row">
                                  <div class="col-sm-3">
                                    <span>
                                      <b>Anrede</b>
                                    </span>
                                    <br />
                                    <div class="form-group form-inline">
                                      <input
                                        type="text"
                                        class="form-control"
                                        placeholder
                                        required
                                        v-model="from.salutation"
                                      />
                                    </div>
                                  </div>
                                  <div class="col-sm-3">
                                    <span>
                                      <b>Titel</b>
                                    </span>
                                    <br />
                                    <div class="form-group form-inline">
                                      <input
                                        type="text"
                                        class="form-control"
                                        placeholder
                                        required
                                        v-model="from.personalTitle"
                                      />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <span>
                                  <b>Vorname</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Vorname ..."
                                    required
                                    v-model="from.firstName"
                                  />
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <span>
                                  <b>Nachname</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nachname ..."
                                    required
                                    v-model="from.lastName"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <span>
                                  <b>Telefon</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Telefon ..."
                                    required
                                    v-model="from.phone"
                                  />
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <span>
                                  <b>E-Mail Adresse</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Email ..."
                                    required
                                    v-model="from.email"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <span>
                                  <b>Staße</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Staße ..."
                                    required
                                    v-model="from.street"
                                  />
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <span>
                                  <b>Hausnummer</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Hausnummer ..."
                                    required
                                    v-model="from.houseNumber"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <span>
                                  <b>PLZ</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="PLZ ..."
                                    required
                                    v-model="from.postCode"
                                  />
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <span>
                                  <b>Ort</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Ort ..."
                                    required
                                    v-model="from.place"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <span>
                                  <b>Land</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Land ..."
                                    required
                                    v-model="from.country"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <br />
                            </div>
                          </div>

                          <!-- Part for the delivery address. -->
                          <div class="row">
                            <div class="col-sm-6">
                              <h5>Lieferadresse</h5>
                            </div>
                            <div class="col-sm-6">
                              <h6>ist gleich dem Auftraggeber</h6>
                              <input
                                type="checkbox"
                                value="0"
                                v-model="to.sameAddress"
                              />
                            </div>
                          </div>
                          <div v-if="!to.sameAddress.length">
                            <div class="row">
                              <div class="col-sm-6">
                                <span>
                                  <b>Firmenname</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Firmenname ..."
                                    required
                                    v-model="to.companyName"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <span>
                                <b>Ansprechpartner</b>
                              </span>
                              <div class="container-fluid">
                                <div class="row">
                                  <div class="col-sm-3">
                                    <span>
                                      <b>Anrede</b>
                                    </span>
                                    <br />
                                    <div class="form-group form-inline">
                                      <input
                                        type="text"
                                        class="form-control"
                                        placeholder
                                        required
                                        v-model="to.salutation"
                                      />
                                    </div>
                                  </div>
                                  <div class="col-sm-3">
                                    <span>
                                      <b>Titel</b>
                                    </span>
                                    <br />
                                    <div class="form-group form-inline">
                                      <input
                                        type="text"
                                        class="form-control"
                                        placeholder
                                        required
                                        v-model="to.personalTitle"
                                      />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <span>
                                  <b>Vorname</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Vorname ..."
                                    required
                                    v-model="to.firstName"
                                  />
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <span>
                                  <b>Nachname</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nachname ..."
                                    required
                                    v-model="to.lastName"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <span>
                                  <b>Telefon</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Telefon ..."
                                    required
                                    v-model="to.phone"
                                  />
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <span>
                                  <b>E-Mail Adresse</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Email ..."
                                    required
                                    v-model="to.email"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <span>
                                  <b>Staße</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Staße ..."
                                    required
                                    v-model="to.street"
                                  />
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <span>
                                  <b>Hausnummer</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Hausnummer ..."
                                    required
                                    v-model="to.houseNumber"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <span>
                                  <b>PLZ</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="PLZ ..."
                                    required
                                    v-model="to.postCode"
                                  />
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <span>
                                  <b>Ort</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Ort ..."
                                    required
                                    v-model="to.place"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <span>
                                  <b>Land</b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Land ..."
                                    required
                                    v-model="to.country"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div
                        id="div_auftrag-versandrechner"
                        class="col-sm-6 div_versandrechner-wrapper"
                      >
                        <order_calculator
                          :clientData="clientData"
                          :fromAddress="from"
                          :toAddress="to"
                          v-on:close_order_modal2="close()"
                        ></order_calculator>
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
import order_calculator from "./order_calculator.vue";

export default {
  name: "order_modal2",
  props: ["showOrderModal2", "clientData"],
  data: function () {
    return {
      from: {
        companyName: "",
        salutation: "",
        personalTitle: "",
        firstName: "",
        lastName: "",
        phone: "",
        email: "",
        street: "",
        houseNumber: "",
        postCode: "",
        place: "",
        country: "",
        sameAddress: [],
      },
      to: {
        companyName: "",
        salutation: "",
        personalTitle: "",
        firstName: "",
        lastName: "",
        phone: "",
        email: "",
        street: "",
        houseNumber: "",
        postCode: "",
        place: "",
        country: "",
        sameAddress: [],
      },
      closeImg: {
        src: "../images/modal/close_window.gif",
        alt: "Close modal",
      },
    };
  },
  methods: {
    close: function () {
      this.showorderModal2 = false;
      this.$emit("close_order_modal2");
    },
  },
  components: {
    order_calculator,
  },
};
</script>

<style>
#component_order_modal2 .modal-container {
  width: 75%;
  height: 90%;
  overflow-y: scroll;
}
#component_order_modal2 #ordAddressForm input[type="text"] {
  width: 100%;
}
#component_order_modal2 .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}
</style>