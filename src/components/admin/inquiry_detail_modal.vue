<template>
  <div id="component_inquiry_detail_modal">
    <modal v-if="show_inquiry_detail_modal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>{{ modal_header }}</h5>
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
                            <span v-text="inquiry_data.client_data.company_name"></span>
                            <br />
                            <span>
                              <b>E-Mail Adresse</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.client_data.email"></span>
                            <br />
                            <span>
                              <b>Ort</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.client_data.place"></span>
                            <br />
                            <span>
                              <b>PLZ</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.client_data.postal_code"></span>
                            <br />
                            <span>
                              <b>Zentrale Telefonnummer</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.client_data.phone_central"></span>
                            <br />
                            <span>
                              <b>Straße</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.client_data.street"></span>
                          </div>
                          <div class="col-sm-6">
                            <h5></h5>
                            <br />
                            <span>
                              <b>Kundennummer</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.client_data.id"></span>
                            <br />
                            <span>
                              <b>Anrede</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.client_data.salutation"></span>
                            <br />
                            <span>
                              <b>Telefon</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.client_data.phone"></span>
                            <br />
                            <span>
                              <b>Hausnummer</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.client_data.house_number"></span>
                            <br />
                            <span>
                              <b>Land</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.client_data.country"></span>
                            <br />
                            <span>
                              <b>Freitext</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiry_data.client_data.additional_text"
                            ></span>
                          </div>
                        </div>
                        <div class="row"><br /></div>
                        <div class="row">
                          <div class="col-sm-6">
                            <!-- Pickup adress part. -->
                            <h5>Abholadresse</h5>
                            <span>
                              <b>Firmenname</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiry_data.pickup_address.company_name"
                            ></span>
                            <br />
                            <span>
                              <b>Anrede</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.pickup_address.salutation"></span>
                            <br />
                            <span>
                              <b>Titel</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.pickup_address.title"></span>
                            <br />
                            <span>
                              <b>Vorname</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.pickup_address.first_name"></span>
                            <br />
                            <span>
                              <b>Nachname</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.pickup_address.last_name"></span>
                            <br />
                            <span>
                              <b>Telefon</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.pickup_address.phone"></span>
                            <br />
                          </div>
                          <div class="col-sm-6">
                            <h5></h5>
                            <br />
                            <span>
                              <b>E-Mail Adresse</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.pickup_address.email"></span>
                            <br />
                            <span>
                              <b>Staße</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.pickup_address.street"></span>
                            <br />
                            <span>
                              <b>Hausnummer</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiry_data.pickup_address.house_number"
                            ></span>
                            <br />
                            <span>
                              <b>PLZ</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.pickup_address.postal_code"></span>
                            <br />
                            <span>
                              <b>Ort</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.pickup_address.place"></span>
                            <br />
                            <span>
                              <b>Land</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.pickup_address.country"></span>
                            <br />
                          </div>
                        </div>
                        <br />
                        <div class="row">
                          <div class="col-sm-6">
                            <h5>Lieferadresse</h5>
                            <span>
                              <b>Firmenname</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiry_data.delivery_address.company_name"
                            ></span>
                            <br />
                            <span>
                              <b>Anrede</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiry_data.delivery_address.salutation"
                            ></span>
                            <br />
                            <span>
                              <b>Titel</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.delivery_address.title"></span>
                            <br />
                            <span>
                              <b>Vorname</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiry_data.delivery_address.first_name"
                            ></span>
                            <br />
                            <span>
                              <b>Nachname</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.delivery_address.last_name"></span>
                            <br />
                            <span>
                              <b>Telefon</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.delivery_address.phone"></span>
                            <br />
                          </div>
                          <div class="col-sm-6">
                            <h5></h5>
                            <br />
                            <span>
                              <b>E-Mail Adresse</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.delivery_address.email"></span>
                            <br />
                            <span>
                              <b>Staße</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.delivery_address.street"></span>
                            <br />
                            <span>
                              <b>Hausnummer</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiry_data.delivery_address.house_number"
                            ></span>
                            <br />
                            <span>
                              <b>PLZ</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiry_data.delivery_address.postal_code"
                            ></span>
                            <br />
                            <span>
                              <b>Ort</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.delivery_address.place"></span>
                            <br />
                            <span>
                              <b>Land</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.delivery_address.country"></span>
                            <br />

                            <!-- Delivery adress part. -->
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 container-fluid">
                        <!-- here comes the data for the calculator -->
                        <div class="row" id="div_inq_information">
                          <div>
                            <h5></h5>
                            <br />
                            <span>
                              <b>Abhol-PLZ</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.postal_code_start"></span>
                            <br />
                            <span>
                              <b>Ziel-PLZ</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.postal_code_end"></span>
                            <br />
                            <span>
                              <b>Zustellfenster</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.time_window"></span>
                            <br />
                            <span>
                              <b>Zustellung am</b>
                            </span>
                            <br />
                            <span v-text="inquiry_data.delivery_day"></span>
                            <br />
                            <div v-if="inquiry_data.packages.length">
                              <div class="row">
                                <h5>Pakete</h5>
                              </div>
                              <div class="row">
                                <div
                                  v-bind:key="package_.id"
                                  v-for="package_ in inquiry_data.packages"
                                  class="col-sm-12"
                                  id="div_inq_packages"
                                >
                                  <b-h3
                                    v-on:click="collapse_accordion_item(package_.elemId)"
                                  >
                                    <span>Paket {{ package_.id + 1 }}</span>
                                  </b-h3>
                                  <b-collapse
                                    v-bind:id="package_.elemId"
                                    accordion="my-accordion"
                                    class="collapese_elem"
                                  >
                                    <b-ul>
                                      <li>Sendungsnummer: {{ package_.id + 1 }}</li>
                                      <li>Länge: {{ package_.length }}</li>
                                      <li>Breite: {{ package_.width }}</li>
                                      <li>Höhe: {{ package_.height }}</li>
                                      <li>
                                        Volumengewicht:
                                        {{ package_.volume_weight }}
                                      </li>
                                      <li>Gewicht: {{ package_.weight }}</li>
                                      <li>Gurtmaß: {{ package_.girth }}</li>
                                      <li>Preis: €{{ package_.price.toFixed(2) }}</li>
                                      <li
                                        v-if="
                                          package_.services &&
                                          JSON.parse(package_.services).length
                                        "
                                      >
                                        <span>Dienstleistungen:</span>
                                        <br />
                                        <b-ul
                                          v-if="
                                            package_.services &&
                                            JSON.parse(package_.services).length
                                          "
                                        >
                                          <li
                                            v-bind:key="service.id"
                                            v-for="service in JSON.parse(
                                              package_.services
                                            )"
                                          >
                                            {{ service.title }}
                                          </li>
                                        </b-ul>
                                      </li>
                                    </b-ul>
                                  </b-collapse>
                                </div>
                              </div>
                            </div>
                            <br />
                            <br />
                            <div class="row" id="div_inq_convert_to_order">
                              <div class="col-sm-12">
                                <b-button
                                  type="button"
                                  v-on:click="convert_to_order()"
                                  value="abs"
                                  variant="success"
                                  class="btn btn-primary"
                                >
                                  <img
                                    v-bind:src="checkmarkImg.src"
                                    v-bind:alt="checkmarkImg.alt"
                                  />
                                  <div class="div_small_border">
                                    <p></p>
                                  </div>
                                  <h4>Zum Auftrag</h4>
                                </b-button>
                              </div>
                            </div>
                          </div>
                        </div>
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
    <convert_inquiry_order_modal
      :inquiry_id="inquiry_id"
      :show_convert_inquiry_order_modal="show_convert_inquiry_order_modal"
      v-on:close_convert_inquiry_order_modal="close_convert_inquiry_order_modal()"
    ></convert_inquiry_order_modal>
  </div>
</template>

<script>
import Snackbar from "vuejs-snackbar";
import convert_inquiry_order_modal from "./convert_inquiry_order_modal.vue";

export default {
  name: "inquiry_detail_modal",
  props: ["show_inquiry_detail_modal", "inquiry_data"],
  data: function () {
    return {
      modal_header: "Anfrage im Detail",
      show_convert_inquiry_order_modal: false,
      inquiry_id: -1,
      closeImg: {
        src: "img/close_window.png",
        alt: "Fenster schließen",
      },
      checkmarkImg: {
        src: "img/checkmark.png",
        alt: "Bestätigen",
      },
    };
  },
  updated: function () {
    this.inquiry_id = this.inquiry_data.id;
  },
  methods: {
    collapse_accordion_item: function (elemId) {
      this.$root.$emit("bv::toggle::collapse", elemId);
    },
    close: function () {
      this.show_inquiry_detail_modal = false;
      this.$emit("close_inquiry_detail_modal");
    },
    convert_to_order: function () {
      this.close();
      this.show_convert_inquiry_order_modal = true;
    },
    close_convert_inquiry_order_modal: function () {
      this.show_convert_inquiry_order_modal = false;
    },
  },
  components: {
    Snackbar,
    convert_inquiry_order_modal,
  },
};
</script>

<style>
#component_inquiry_detail_modal {
  text-align: left;
}
#component_inquiry_detail_modal .modal-container {
  overflow-y: auto;
  width: 75%;
  height: 90%;
}

#component_inquiry_detail_modal #div_inq_information > div,
#component_inquiry_detail_modal #div_inq_packages {
  width: 100%;
}
#component_inquiry_detail_modal b-h3 {
  background: #f2f2f2;
  border: 1px solid black;
  border-radius: 3px;
  width: 100%;
  display: block;
  padding: 5px;
  cursor: pointer;
}
#component_inquiry_detail_modal .collapese_elem {
  background: #f2f2f2;
}
#component_inquiry_detail_modal b-ul {
  display: block;
  padding: 20px;
  border: 1px solid black;
  border-radius: 3px;
}

#component_inquiry_detail_modal .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}

#component_inquiry_detail_modal #div_inq_convert_to_order button {
  float: left;
  display: flex;
  flex-flow: row nowrap;
  justify-content: space-between;
  align-items: center;
}

#component_inquiry_detail_modal #div_inq_convert_to_order .div_small_border {
  border-left: 2px solid white;
  height: 45px;
  margin-left: 5px;
  margin-right: 5px;
}

#component_inquiry_detail_modal #div_inq_convert_to_order h4 {
  margin: 0;
}

#component_inquiry_detail_modal span {
  overflow-wrap: break-word;
}
</style>
