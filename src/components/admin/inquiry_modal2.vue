<template>
  <div id="component_inquiry_modal2">
    <modal v-if="show_inquiry_modal2">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>Anfrage erstellen</h5>
                <button class="modal-default-button" v-on:click="close()">
                  <img v-bind:src="close_img.src" v-bind:alt="close_img.alt" />
                </button>
              </div>
              <div class="modal-body">
                <div>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-lg-6 container-fluid">
                        <form id="form_inquiry_address" class="m-form">
                          <div class="row">
                            <div class="col-lg-6">
                              <h5>Auftraggeber</h5>
                              <span>
                                <b>Firmenname</b>
                              </span>
                              <br />
                              <span v-text="client_data.company_name"></span>
                              <br />
                            </div>
                            <div class="col-lg-6">
                              <br />
                              <span>
                                <b>Kundennummer</b>
                              </span>
                              <br />
                              <span v-text="client_data.id"></span>
                              <br />
                              <span>
                                <b>Telefon</b>
                              </span>
                              <br />
                              <span v-text="client_data.phone"></span>
                              <br />
                              <span>
                                <b>E-Mail-Adresse</b>
                              </span>
                              <br />
                              <span v-text="client_data.email"></span>
                            </div>
                          </div>
                          <div class="row">
                            <br />
                          </div>

                          <!-- Part for the pickup address. -->
                          <div class="row">
                            <div class="col-lg-6">
                              <h5>Abholadresse</h5>
                            </div>
                            <div class="col-lg-6" id="div_pickup_address">
                              <input
                                type="checkbox"
                                value="0"
                                v-model="from.same_address"
                              />
                              <div>
                                <span>&nbsp;&nbsp;</span>
                              </div>
                              <h6>ist gleich dem Auftraggeber</h6>
                            </div>
                          </div>
                          <div v-if="!from.same_address.length">
                            <div class="row">
                              <div class="col-lg-6">
                                <span>
                                  <b>Firmenname<span style="color: red">&nbsp;*</span></b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Firmenname ..."
                                    required
                                    v-model="from.company_name"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <span>
                                <b>Ansprechpartner</b>
                              </span>
                            </div>
                            <div class="row">
                              <div class="col-lg-6">
                                <span>
                                  <b>Anrede<span style="color: red">&nbsp;*</span></b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <label class="input-group-text">Anrede</label>
                                    </div>
                                    <select
                                      v-model="from.salutation"
                                      class="custom-select"
                                    >
                                      <option value="-">-</option>
                                      <option value="herr">Herr</option>
                                      <option value="frau">Frau</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <span>
                                  <b>Titel</b>
                                </span>
                                <div class="form-group form-inline">
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <label class="input-group-text">Titel</label>
                                    </div>
                                    <select v-model="from.title" class="custom-select">
                                      <option value="-">-</option>
                                      <option value="dr">Dr.</option>
                                      <option value="dr_dr">Dr. Dr.</option>
                                      <option value="prof">Prof.</option>
                                      <option value="prof_dr">Prof. Dr.</option>
                                      <option value="prof_dr_dr">Prof. Dr. Dr.</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-6">
                                <span>
                                  <b>Vorname<span style="color: red">&nbsp;*</span></b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Vorname ..."
                                    required
                                    v-model="from.first_name"
                                  />
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <span>
                                  <b>Nachname<span style="color: red">&nbsp;*</span></b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nachname ..."
                                    required
                                    v-model="from.last_name"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-6">
                                <span>
                                  <b>Telefon<span style="color: red">&nbsp;*</span></b>
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
                              <div class="col-lg-6">
                                <span>
                                  <b
                                    >E-Mail Adresse<span style="color: red"
                                      >&nbsp;*</span
                                    ></b
                                  >
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
                              <div class="col-lg-6">
                                <span>
                                  <b>Staße<span style="color: red">&nbsp;*</span></b>
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
                              <div class="col-lg-6">
                                <span>
                                  <b>Hausnummer<span style="color: red">&nbsp;*</span></b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    placeholder="Hausnummer ..."
                                    required
                                    v-model="from.house_number"
                                    v-on:input="
                                      from.house_number =
                                        parseInt(from.house_number) >= 0
                                          ? from.house_number
                                          : 0
                                    "
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-6">
                                <span>
                                  <b>PLZ<span style="color: red">&nbsp;*</span></b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    placeholder="PLZ ..."
                                    required
                                    v-model="from.postal_code"
                                    v-on:input="
                                      from.postal_code =
                                        parseInt(from.postal_code) >= 0
                                          ? from.postal_code
                                          : 0
                                    "
                                  />
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <span>
                                  <b>Ort<span style="color: red">&nbsp;*</span></b>
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
                              <div class="col-lg-6">
                                <label>
                                  <b
                                    >Wählen Sie ein Land aus<span style="color: red"
                                      >&nbsp;*</span
                                    ></b
                                  >
                                </label>
                                <br />
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text">Land</label>
                                  </div>
                                  <select v-model="from.country" class="custom-select">
                                    <option
                                      v-bind:key="cntr"
                                      v-for="cntr in countries_list"
                                      v-bind:value="cntr"
                                    >
                                      {{ cntr }}
                                    </option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>
                                    <b>Fax</b>
                                  </label>
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Fax ..."
                                    v-model="from.fax"
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
                            <div class="col-lg-6">
                              <h5>Lieferadresse</h5>
                            </div>
                            <div class="col-lg-6" id="div_delivery_address">
                              <input
                                type="checkbox"
                                value="0"
                                v-model="to.same_address"
                              />
                              <div>
                                <span>&nbsp;&nbsp;</span>
                              </div>
                              <h6>ist gleich dem Auftraggeber</h6>
                            </div>
                          </div>
                          <div v-if="!to.same_address.length">
                            <div class="row">
                              <div class="col-lg-6">
                                <span>
                                  <b>Firmenname<span style="color: red">&nbsp;*</span></b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Firmenname ..."
                                    required
                                    v-model="to.company_name"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <span>
                                <b>Ansprechpartner</b>
                              </span>
                            </div>
                            <div class="row">
                              <div class="col-lg-6">
                                <span>
                                  <b>Anrede<span style="color: red">&nbsp;*</span></b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <label class="input-group-text">Anrede</label>
                                    </div>
                                    <select v-model="to.salutation" class="custom-select">
                                      <option value="-">-</option>
                                      <option value="herr">Herr</option>
                                      <option value="frau">Frau</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <span>
                                  <b>Titel</b>
                                </span>
                                <div class="form-group form-inline">
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <label class="input-group-text">Titel</label>
                                    </div>
                                    <select v-model="to.title" class="custom-select">
                                      <option value="-">-</option>
                                      <option value="dr">Dr.</option>
                                      <option value="dr_dr">Dr. Dr.</option>
                                      <option value="prof">Prof.</option>
                                      <option value="prof_dr">Prof. Dr.</option>
                                      <option value="prof_dr_dr">Prof. Dr. Dr.</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-6">
                                <span>
                                  <b>Vorname<span style="color: red">&nbsp;*</span></b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Vorname ..."
                                    required
                                    v-model="to.first_name"
                                  />
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <span>
                                  <b>Nachname<span style="color: red">&nbsp;*</span></b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nachname ..."
                                    required
                                    v-model="to.last_name"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-6">
                                <span>
                                  <b>Telefon<span style="color: red">&nbsp;*</span></b>
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
                              <div class="col-lg-6">
                                <span>
                                  <b
                                    >E-Mail Adresse<span style="color: red"
                                      >&nbsp;*</span
                                    ></b
                                  >
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
                              <div class="col-lg-6">
                                <span>
                                  <b>Staße<span style="color: red">&nbsp;*</span></b>
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
                              <div class="col-lg-6">
                                <span>
                                  <b>Hausnummer<span style="color: red">&nbsp;*</span></b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    placeholder="Hausnummer ..."
                                    required
                                    v-model="to.house_number"
                                    v-on:input="
                                      to.house_number =
                                        parseInt(to.house_number) >= 0
                                          ? to.house_number
                                          : 0
                                    "
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-6">
                                <span>
                                  <b>PLZ<span style="color: red">&nbsp;*</span></b>
                                </span>
                                <br />
                                <div class="form-group form-inline">
                                  <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    placeholder="PLZ ..."
                                    required
                                    v-model="to.postal_code"
                                    v-on:input="
                                      to.postal_code =
                                        parseInt(to.postal_code) >= 0 ? to.postal_code : 0
                                    "
                                  />
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <span>
                                  <b>Ort<span style="color: red">&nbsp;*</span></b>
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
                              <div class="col-lg-6">
                                <label>
                                  <b
                                    >Wählen Sie ein Land aus<span style="color: red"
                                      >&nbsp;*</span
                                    ></b
                                  >
                                </label>
                                <br />
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text">Land</label>
                                  </div>
                                  <select v-model="to.country" class="custom-select">
                                    <option
                                      v-bind:key="cntr"
                                      v-for="cntr in countries_list"
                                      v-bind:value="cntr"
                                    >
                                      {{ cntr }}
                                    </option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>
                                    <b>Fax</b>
                                  </label>
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Fax ..."
                                    v-model="to.fax"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="col-lg-6">
                        <inquiry_calculator
                          :client_data="client_data"
                          :from_address="from"
                          :to_address="to"
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
import { COUNTRIES } from "../general/COUNTRIES";

export default {
  name: "inquiry_modal2",
  props: ["show_inquiry_modal2", "client_data"],
  data: function () {
    return {
      from: {
        company_name: "",
        salutation: "-",
        title: "-",
        first_name: "",
        last_name: "",
        phone: "",
        email: "",
        street: "",
        house_number: "",
        postal_code: "",
        place: "",
        country: "",
        fax: "",
        same_address: [],
      },
      to: {
        company_name: "",
        salutation: "-",
        title: "-",
        first_name: "",
        last_name: "",
        phone: "",
        email: "",
        street: "",
        house_number: "",
        postal_code: "",
        place: "",
        country: "",
        fax: "",
        same_address: [],
      },
      close_img: {
        src: "img/close_window.png",
        alt: "Fenster schließen",
      },
      countries_list: COUNTRIES,
    };
  },
  methods: {
    close: function () {
      this.unset_properties();
      this.show_inquiry_modal2 = false;
      this.$emit("close_inquiry_modal2");
    },
    unset_properties: function () {
      for (const prop in this.from) {
        this.from[prop] = "";
      }
      this.from.salutation = "-";
      this.from.title = "-";
      for (const prop in this.to) {
        this.to[prop] = "";
      }
      this.to.salutation = "-";
      this.to.title = "-";
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
  /* Overwrite the width from the client modal. */
  width: 75% !important;
  height: 90%;
}

#component_inquiry_modal2 #form_inquiry_address input[type="text"] {
  width: 100%;
}

#component_inquiry_modal2 .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}

#component_inquiry_modal2 #div_pickup_address,
#component_inquiry_modal2 #div_delivery_address {
  display: flex;
  align-items: center;
}

#component_inquiry_modal2 #div_pickup_address h6,
#component_inquiry_modal2 #div_delivery_address h6 {
  margin: 0;
}

#component_inquiry_modal2 select {
  cursor: pointer;
}
</style>
