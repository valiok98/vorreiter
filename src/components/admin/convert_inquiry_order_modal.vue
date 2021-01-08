<template>
  <div id="component_convert_inquiry_order_modal">
    <modal v-if="show_convert_inquiry_order_modal">
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
                <form>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-lg-6">
                        <!-- Part for the pickup address. -->
                        <div class="row">
                          <div class="col-sm-6">
                            <h5>Abholadresse</h5>
                          </div>
                          <div class="col-sm-6" id="div_pickup_address">
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
                            <div class="col-sm-6">
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
                            <div class="col-sm-12">
                              <span>
                                <b>Ansprechpartner</b>
                              </span>
                            </div>
                          </div>
                          <div class="row"><br /></div>
                          <div class="row">
                            <div class="col-sm-6">
                              <span>
                                <b>Anrede<span style="color: red">&nbsp;*</span></b>
                              </span>
                              <br />
                              <div class="form-group form-inline">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text">Anrede</label>
                                  </div>

                                  <select v-model="from.salutation" class="custom-select">
                                    <option value="-">-</option>
                                    <option value="herr">Herr</option>
                                    <option value="frau">Frau</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <span>
                                <b>Titel</b>
                              </span>
                              <br />
                              <div class="form-group form-inline">
                                <input
                                  type="text"
                                  class="form-control"
                                  placeholder="Titel ..."
                                  required
                                  v-model="from.title"
                                />
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
                              <span>
                                <b>Hausnummer<span style="color: red">&nbsp;*</span></b>
                              </span>
                              <br />
                              <div class="form-group form-inline">
                                <input
                                  type="text"
                                  class="form-control"
                                  placeholder="Hausnummer ..."
                                  required
                                  v-model="from.house_number"
                                />
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <span>
                                <b>PLZ<span style="color: red">&nbsp;*</span></b>
                              </span>
                              <br />
                              <div class="form-group form-inline">
                                <input
                                  type="text"
                                  class="form-control"
                                  placeholder="PLZ ..."
                                  required
                                  v-model="from.postal_code"
                                />
                              </div>
                            </div>
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
                              <div>
                                <label>
                                  <b
                                    >Wählen Sie ein Land aus<span style="color: red"
                                      >&nbsp;*</span
                                    ></b
                                  >
                                </label>
                              </div>
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
                          </div>
                          <div class="row">
                            <br />
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <!-- Part for the delivery address. -->
                        <div class="row">
                          <div class="col-sm-6">
                            <h5>Lieferadresse</h5>
                          </div>
                          <div class="col-sm-6" id="div_delivery_address">
                            <input type="checkbox" value="0" v-model="to.same_address" />
                            <div>
                              <span>&nbsp;&nbsp;</span>
                            </div>
                            <h6>ist gleich dem Auftraggeber</h6>
                          </div>
                        </div>
                        <div v-if="!to.same_address.length">
                          <div class="row">
                            <div class="col-sm-6">
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
                            <div class="col-sm-12">
                              <span>
                                <b>Ansprechpartner</b>
                              </span>
                            </div>
                          </div>
                          <div class="row">
                            <br />
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
                              <span>
                                <b>Titel</b>
                              </span>
                              <br />
                              <div class="form-group form-inline">
                                <input
                                  type="text"
                                  class="form-control"
                                  placeholder="Titel ..."
                                  required
                                  v-model="to.title"
                                />
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
                              <span>
                                <b>Hausnummer<span style="color: red">&nbsp;*</span></b>
                              </span>
                              <br />
                              <div class="form-group form-inline">
                                <input
                                  type="text"
                                  class="form-control"
                                  placeholder="Hausnummer ..."
                                  required
                                  v-model="to.house_number"
                                />
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <span>
                                <b>PLZ<span style="color: red">&nbsp;*</span></b>
                              </span>
                              <br />
                              <div class="form-group form-inline">
                                <input
                                  type="text"
                                  class="form-control"
                                  placeholder="PLZ ..."
                                  required
                                  v-model="to.postal_code"
                                />
                              </div>
                            </div>
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
                              <div>
                                <label>
                                  <b
                                    >Wählen Sie ein Land aus<span style="color: red"
                                      >&nbsp;*</span
                                    ></b
                                  >
                                </label>
                              </div>
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
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="div_inq_convert_to_order">
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
                        <h4>Auftrag erstellen</h4>
                      </b-button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </modal>
    <snackbar ref="snackbar" baseSize="100px" position="bottom-right"></snackbar>
  </div>
</template>

<script>
import { COUNTRIES } from "../general/COUNTRIES";
import Snackbar from "vuejs-snackbar";

export default {
  name: "convert_inquiry_order_modal",
  props: ["show_convert_inquiry_order_modal", "inquiry_id"],
  data: function () {
    return {
      from: {
        company_name: "",
        salutation: "",
        title: "",
        first_name: "",
        last_name: "",
        phone: "",
        email: "",
        street: "",
        house_number: "",
        postal_code: "",
        place: "",
        country: "",
        same_address: [],
      },
      to: {
        company_name: "",
        salutation: "",
        title: "",
        first_name: "",
        last_name: "",
        phone: "",
        email: "",
        street: "",
        house_number: "",
        postal_code: "",
        place: "",
        country: "",
        same_address: [],
      },
      default_pickup_address: false,
      default_delivery_address: false,
      closeImg: {
        src: "img/close_window.png",
        alt: "Fenster schließen",
      },
      checkmarkImg: {
        src: "img/checkmark.png",
        alt: "Bestätigen",
      },
      countries_list: COUNTRIES,
    };
  },
  updated: function () {
    // Check if we're using the default pickup address.
    if (
      !this.from.same_address.length &&
      (!this.from.company_name ||
        !this.from.salutation ||
        !this.from.first_name ||
        !this.from.last_name ||
        !this.from.phone ||
        !this.from.email ||
        !this.from.street ||
        !this.from.house_number ||
        !this.from.postal_code ||
        !this.from.place ||
        !this.from.country)
    ) {
      this.default_pickup_address = false;
    } else {
      this.default_pickup_address = true;
    }

    // Check if we're using the default delivery address.
    if (
      !this.to.same_address.length &&
      (!this.to.company_name ||
        !this.to.salutation ||
        !this.to.first_name ||
        !this.to.last_name ||
        !this.to.phone ||
        !this.to.email ||
        !this.to.street ||
        !this.to.house_number ||
        !this.to.postal_code ||
        !this.to.place ||
        !this.to.country)
    ) {
      this.default_delivery_address = false;
    } else {
      this.default_delivery_address = true;
    }
  },
  methods: {
    close: function () {
      this.show_convert_inquiry_order_modal = false;
      this.$emit("close_convert_inquiry_order_modal");
    },
    convert_to_order: function () {
      // Check if we're using the default pickup address.
      if (!this.default_pickup_address) {
        this.$refs.snackbar.error("Es fehlen erforderliche Daten über die Abholadresse.");
        return;
      }
      // Check if we're using the default delivery address.
      if (!this.default_delivery_address) {
        this.$refs.snackbar.error(
          "Es fehlen erforderliche Daten über die Lieferadresse."
        );
        return;
      }
      // Send the request for converting the inquiry to an order.

      fetch(mainUrl + "admin_content/ajax/create_order_from_inquiry.php", {
        method: "POST",
        dataType: "json",
        mode: "cors",
        credentials: "same-origin",
        headers: {
          "Access-Control-Allow-Origin": "*",
        },
        body: JSON.stringify({
          inquiry_id: this.inquiry_id,
          from_address: this.from,
          to_address: this.to,
        }),
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success) {
            // Update the store by adding the newly created order.
            this.$store.commit("add_order", res.order);

            this.$refs.snackbar.info("Auftrag erflogreich erstellt.");
          } else {
            this.$refs.snackbar.error(res.msg);
          }
          return new Promise((resolve, reject) => setTimeout(resolve, 1000));
        })
        .then((res) => this.$emit("close_convert_inquiry_order_modal"))
        .catch((err) => this.$refs.snackbar.error(err));
    },
  },
  components: {
    Snackbar,
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

#component_convert_inquiry_order_modal #div_pickup_address,
#component_convert_inquiry_order_modal #div_delivery_address {
  display: flex;
  align-items: center;
}

#component_convert_inquiry_order_modal #div_pickup_address h6,
#component_convert_inquiry_order_modal #div_delivery_address h6 {
  margin: 0;
}

#component_convert_inquiry_order_modal #div_inq_convert_to_order button {
  float: left;
  display: flex;
  flex-flow: row nowrap;
  justify-content: space-between;
  align-items: center;
}

#component_convert_inquiry_order_modal #div_inq_convert_to_order .div_small_border {
  border-left: 2px solid white;
  height: 45px;
  margin-left: 5px;
  margin-right: 5px;
}

#component_convert_inquiry_order_modal #div_inq_convert_to_order h4 {
  margin: 0;
}

#component_convert_inquiry_order_modal select {
  cursor: pointer;
}
</style>
