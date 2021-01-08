<template>
  <div id="component_order_detail_modal">
    <modal v-if="show_order_detail_modal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>{{ modalHeader }}</h5>
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
                            <span v-text="order_data.client_data.company_name"></span>
                            <br />
                            <span>
                              <b>E-Mail Adresse</b>
                            </span>
                            <br />
                            <span v-text="order_data.client_data.email"></span>
                            <br />
                            <span>
                              <b>Ort</b>
                            </span>
                            <br />
                            <span v-text="order_data.client_data.place"></span>
                            <br />
                            <span>
                              <b>PLZ</b>
                            </span>
                            <br />
                            <span v-text="order_data.client_data.postal_code"></span>
                            <br />
                            <span>
                              <b>Zentrale Telefonnummer</b>
                            </span>
                            <br />
                            <span v-text="order_data.client_data.phone_central"></span>
                            <br />
                            <span>
                              <b>Straße</b>
                            </span>
                            <br />
                            <span v-text="order_data.client_data.street"></span>
                          </div>
                          <div class="col-sm-6">
                            <h5></h5>
                            <br />
                            <span>
                              <b>Kundennummer</b>
                            </span>
                            <br />
                            <span v-text="order_data.client_data.id"></span>
                            <br />
                            <span>
                              <b>Anrede</b>
                            </span>
                            <br />
                            <span v-text="order_data.client_data.salutation"></span>
                            <br />
                            <span>
                              <b>Telefon</b>
                            </span>
                            <br />
                            <span v-text="order_data.client_data.phone"></span>
                            <br />
                            <span>
                              <b>Hausnummer</b>
                            </span>
                            <br />
                            <span v-text="order_data.client_data.house_number"></span>
                            <br />
                            <span>
                              <b>Land</b>
                            </span>
                            <br />
                            <span v-text="order_data.client_data.country"></span>
                            <br />
                            <span>
                              <b>Freitext</b>
                            </span>
                            <br />
                            <span v-text="order_data.client_data.additional_text"></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 container-fluid">
                        <!-- here comes the data for the calculator -->
                        <div class="row" id="div_ord_information">
                          <div>
                            <!-- Pickup adress part. -->
                            <h5>Abholadresse</h5>
                            <div class="container-fluid">
                              <div class="row">
                                <div class="col-sm-6">
                                  <span>
                                    <b>Firmenname</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.pickup_address.company_name"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>Anrede</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.pickup_address.salutation"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>Titel</b>
                                  </span>
                                  <br />
                                  <span v-text="order_data.pickup_address.title"></span>
                                  <br />
                                  <span>
                                    <b>Vorname</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.pickup_address.first_name"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>Nachname</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.pickup_address.last_name"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>Telefon</b>
                                  </span>
                                  <br />
                                  <span v-text="order_data.pickup_address.phone"></span>
                                  <br />
                                </div>
                                <div class="col-sm-6">
                                  <span>
                                    <b>E-Mail Adresse</b>
                                  </span>
                                  <br />
                                  <span v-text="order_data.pickup_address.email"></span>
                                  <br />
                                  <span>
                                    <b>Staße</b>
                                  </span>
                                  <br />
                                  <span v-text="order_data.pickup_address.street"></span>
                                  <br />
                                  <span>
                                    <b>Hausnummer</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.pickup_address.house_number"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>PLZ</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.pickup_address.postal_code"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>Ort</b>
                                  </span>
                                  <br />
                                  <span v-text="order_data.pickup_address.place"></span>
                                  <br />
                                  <span>
                                    <b>Land</b>
                                  </span>
                                  <br />
                                  <span v-text="order_data.pickup_address.country"></span>
                                  <br />
                                </div>
                              </div>
                            </div>
                            <br />
                            <!-- Delivery adress part. -->
                            <h5>Lieferadresse</h5>
                            <div class="container-fluid">
                              <div class="row">
                                <div class="col-sm-6">
                                  <span>
                                    <b>Firmenname</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.delivery_address.company_name"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>Anrede</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.delivery_address.salutation"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>Titel</b>
                                  </span>
                                  <br />
                                  <span v-text="order_data.delivery_address.title"></span>
                                  <br />
                                  <span>
                                    <b>Vorname</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.delivery_address.first_name"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>Nachname</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.delivery_address.last_name"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>Telefon</b>
                                  </span>
                                  <br />
                                  <span v-text="order_data.delivery_address.phone"></span>
                                  <br />
                                </div>
                                <div class="col-sm-6">
                                  <span>
                                    <b>E-Mail Adresse</b>
                                  </span>
                                  <br />
                                  <span v-text="order_data.delivery_address.email"></span>
                                  <br />
                                  <span>
                                    <b>Staße</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.delivery_address.street"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>Hausnummer</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.delivery_address.house_number"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>PLZ</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.delivery_address.postal_code"
                                  ></span>
                                  <br />
                                  <span>
                                    <b>Ort</b>
                                  </span>
                                  <br />
                                  <span v-text="order_data.delivery_address.place"></span>
                                  <br />
                                  <span>
                                    <b>Land</b>
                                  </span>
                                  <br />
                                  <span
                                    v-text="order_data.delivery_address.country"
                                  ></span>
                                  <br />
                                </div>
                              </div>
                            </div>
                            <!-- Package part. -->

                            <div class="container-fluid">
                              <div class="row"><br /></div>
                              <div class="row">
                                <div class="col-sm-6">
                                  <span>
                                    <b>Zustellfenster</b>
                                  </span>
                                  <br />
                                  <span v-text="order_data.time_window"></span>
                                  <br />
                                </div>
                                <div class="col-sm-6">
                                  <span>
                                    <b>Zustellung am</b>
                                  </span>
                                  <br />
                                  <span v-text="order_data.delivery_day"></span>
                                  <br />
                                </div>
                              </div>
                            </div>
                            <div v-if="order_data.packages.length">
                              <div class="row">
                                <h5>Pakete</h5>
                              </div>
                              <div class="row">
                                <div
                                  v-bind:key="package_.id"
                                  v-for="package_ in order_data.packages"
                                  class="col-sm-12"
                                  id="div_ord_packages"
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
  </div>
</template>

<script>
export default {
  name: "order_detail_modal",
  props: ["show_order_detail_modal", "order_data"],
  data: function () {
    return {
      modalHeader: "Auftrag im Detail",
      closeImg: {
        src: "img/close_window.png",
        alt: "Fenster schließen",
      },
    };
  },
  methods: {
    collapse_accordion_item: function (elemId) {
      this.$root.$emit("bv::toggle::collapse", elemId);
    },
    close: function () {
      this.show_order_detail_modal = false;
      this.$emit("close_order_detail_modal");
    },
  },
};
</script>

<style>
#component_order_detail_modal {
  text-align: left;
}
#component_order_detail_modal .modal-container {
  overflow-y: auto;
  width: 75%;
  height: 90%;
}

#component_order_detail_modal #div_ord_information > div,
#component_order_detail_modal #div_ord_packages {
  width: 100%;
}
#component_order_detail_modal b-h3 {
  background: #f2f2f2;
  border: 1px solid black;
  border-radius: 3px;
  width: 100%;
  display: block;
  padding: 5px;
  cursor: pointer;
}
#component_order_detail_modal .collapese_elem {
  background: #f2f2f2;
}
#component_order_detail_modal b-ul {
  display: block;
  padding: 20px;
  border: 1px solid black;
  border-radius: 3px;
}

#component_order_detail_modal .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}

#component_order_detail_modal span {
  overflow-wrap: break-word;
}
</style>
