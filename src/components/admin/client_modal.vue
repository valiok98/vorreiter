<template>
  <div id="component_client_modal">
    <modal v-if="show_client_modal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5 v-if="client_type === 'inquiry'">
                  Legen Sie den Kunden zur Anfrage an
                </h5>
                <h5 v-else-if="client_type === 'order'">
                  Legen Sie den Kunden zum Auftrag an
                </h5>
                <button class="modal-default-button" v-on:click="close()">
                  <img v-bind:src="close_img.src" v-bind:alt="close_img.alt" />
                </button>
              </div>
              <div class="modal-body">
                <form
                  v-on:submit="create_client($event)"
                  method="POST"
                  id="kunden_anlegen"
                >
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-sm-4 container-fluid">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label
                                >Firmenname<span style="color: red">&nbsp;*</span></label
                              >
                              <input
                                required
                                type="text"
                                class="form-control"
                                placeholder="Firmenname ..."
                                v-model="company_name"
                              />
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div>
                              <label>Anrede<span style="color: red">&nbsp;*</span></label>
                            </div>
                            <div class="input-group mb-3">
                              <select v-model="salutation" class="custom-select">
                                <option value="-">-</option>
                                <option value="herr">Herr</option>
                                <option value="frau">Frau</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div>
                              <label>Titel</label>
                            </div>
                            <div class="input-group mb-3">
                              <select v-model="title" class="custom-select">
                                <option value="-">-</option>
                                <option value="dr">Dr.</option>
                                <option value="dr_dr">Dr. Dr.</option>
                                <option value="prof">Prof.</option>
                                <option value="prof_dr">Prof. Dr.</option>
                                <option value="prof_dr_dr">Prof. Dr. Dr.</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-4"></div>
                        </div>
                        <div class="row"></div>
                      </div>
                      <div class="col-sm-8">
                        <div class="form-group">
                          <label>Freitext</label>
                          <textarea
                            class="form-control"
                            rows="5"
                            placeholder="Freitext ..."
                            v-model="additional_text"
                          ></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Vorname<span style="color: red">&nbsp;*</span></label>
                          <input
                            v-on:input="adjust_client_abv()"
                            required
                            type="text"
                            class="form-control"
                            placeholder="Vorname ..."
                            v-model="first_name"
                          />
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Nachname<span style="color: red">&nbsp;*</span></label>
                          <input
                            v-on:input="adjust_client_abv()"
                            required
                            type="text"
                            class="form-control"
                            placeholder="Nachname ..."
                            v-model="last_name"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Telefon<span style="color: red">&nbsp;*</span></label>
                          <input
                            required
                            type="tel"
                            class="form-control"
                            placeholder="Telefon ..."
                            v-model="phone"
                          />
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label
                            >E-Mail Adresse<span style="color: red">&nbsp;*</span></label
                          >
                          <input
                            required
                            type="email"
                            class="form-control"
                            placeholder="E-Mail Adresse ..."
                            v-model="email"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Straße<span style="color: red">&nbsp;*</span></label>
                          <input
                            required
                            type="text"
                            class="form-control"
                            placeholder="Straße ..."
                            v-model="street"
                          />
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Hausnummer<span style="color: red">&nbsp;*</span></label>
                          <input
                            required
                            type="number"
                            min="0"
                            class="form-control"
                            placeholder="Hausnummer ..."
                            v-model="house_number"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>PLZ<span style="color: red">&nbsp;*</span></label>
                          <input
                            required
                            type="number"
                            min="0"
                            class="form-control"
                            placeholder="PLZ ..."
                            v-model="postal_code"
                          />
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Ort<span style="color: red">&nbsp;*</span></label>
                          <input
                            required
                            type="text"
                            class="form-control"
                            placeholder="Ort ..."
                            v-model="place"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div>
                          <label
                            >Wählen Sie ein Land aus<span style="color: red"
                              >&nbsp;*</span
                            ></label
                          >
                        </div>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text">Land</label>
                          </div>
                          <select v-model="country" class="custom-select">
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
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label
                            >Zentrale Telefonnummer<span style="color: red"
                              >&nbsp;*</span
                            ></label
                          >
                          <input
                            required
                            type="tel"
                            class="form-control"
                            placeholder="Zentrale Telefonnummer ..."
                            v-model="phone_central"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Fax</label>
                          <input
                            type="text"
                            class="form-control"
                            placeholder="Fax ..."
                            v-model="fax"
                          />
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Mobil<span style="color: red">&nbsp;*</span></label>
                          <input
                            required
                            type="tel"
                            class="form-control"
                            placeholder="Mobil ..."
                            v-model="mobile_phone"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Kundenkürzel</label>
                          <input
                            required
                            type="text"
                            class="form-control"
                            v-model="shorthand"
                          />
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div>
                          <br />
                        </div>
                        <div class="form-check">
                          <input
                            type="checkbox"
                            class="form-check-input"
                            v-model="inform_client"
                          />
                          <label class="form-check-label"
                            >Kunden über Accounterstellung via E-Mail informieren</label
                          >
                        </div>
                      </div>
                    </div>
                    <div class="row" id="div_create_client">
                      <div class="col-sm-12">
                        <b-button
                          type="submit"
                          value="abs"
                          variant="success"
                          class="btn btn-primary"
                        >
                          <img
                            v-bind:src="checkmark_img.src"
                            v-bind:alt="checkmark_img.alt"
                          />
                          <div class="div_small_border">
                            <p></p>
                          </div>
                          <div>
                            <h4>Kunden erstellen</h4>
                          </div>
                        </b-button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </modal>
    <inquiry_modal2
      :client_data="client_data"
      :show_inquiry_modal2="show_inquiry_modal2"
      v-on:close_inquiry_modal2="close_inquiry_modal2()"
    ></inquiry_modal2>
    <order_modal2
      :client_data="client_data"
      :show_order_modal2="show_order_modal2"
      v-on:close_order_modal2="close_order_modal2()"
    ></order_modal2>
    <snackbar ref="snackbar" baseSize="100px" position="bottom-right"></snackbar>
  </div>
</template>

<script>
import inquiry_modal2 from "./inquiry_modal2";
import order_modal2 from "./order_modal2";
import Snackbar from "vuejs-snackbar";
import { COUNTRIES } from "../general/COUNTRIES";

export default {
  name: "client_modal",
  props: ["show_client_modal", "client_type"],
  data: function () {
    return {
      company_name: "",
      salutation: "",
      additional_text: "",
      email: "",
      phone: "",
      first_name: "",
      last_name: "",
      title: "",
      mobile_phone: "",
      fax: "",
      shorthand: "",
      place: "",
      house_number: 0,
      postal_code: 0,
      country: "",
      phone_central: "",
      street: "",
      inform_client: false,
      client_data: {},
      show_inquiry_modal2: false,
      show_order_modal2: false,
      close_img: {
        src: "img/close_window.png",
        alt: "Fenster schließen",
      },
      checkmark_img: {
        src: "img/checkmark.png",
        alt: "Bestätigen",
      },
      countries_list: COUNTRIES,
    };
  },
  methods: {
    close: function () {
      this.show_client_modal = false;
      this.$emit("close_client_modal");
    },
    adjust_client_abv: function () {
      let firstChar = "";
      let midChar = "";
      let lastChar = "";
      let vowels = ["a", "e", "i", "o", "u"];

      const get_first_consonant = (name) => {
        for (let c of name) {
          if (!vowels.includes(c)) return c;
        }
        return "";
      };

      if (this.first_name) {
        firstChar = this.first_name[0];
        midChar = get_first_consonant(this.last_name);
        lastChar = get_first_consonant(this.last_name.substr(1));
      } else if (this.last_name) {
        firstChar = this.last_name[0];
        midChar = get_first_consonant(this.last_name.substr(1));
        lastChar = get_first_consonant(this.last_name.substr(2));
      }
      this.shorthand = firstChar + midChar + lastChar;
    },
    async create_client(e) {
      e.preventDefault();
      // Send the creation request.
      let res = {};
      try {
        res = await fetch(mainUrl + "admin_content/ajax/create_client.php", {
          method: "POST",
          dataType: "json",
          mode: "cors",
          credentials: "same-origin",
          headers: {
            "Access-Control-Allow-Origin": "*",
          },
          body: JSON.stringify({
            company_name: this.company_name,
            salutation: this.salutation,
            additional_text: this.additional_text,
            email: this.email,
            phone: this.phone,
            first_name: this.first_name,
            last_name: this.last_name,
            title: this.title,
            mobile_phone: this.mobile_phone,
            shorthand: this.shorthand,
            fax: this.fax,
            place: this.place,
            house_number: this.house_number,
            postal_code: this.postal_code,
            country: this.country,
            phone_central: this.phone_central,
            street: this.street,
            inform_client: this.inform_client,
          }),
        });

        res = await res.json();
      } catch (err) {
        this.$refs.snackbar.error(err);
        return;
      }

      if (res.success) {
        // Getting the data for the client.
        try {
          res = await fetch(mainUrl + "admin_content/ajax/find_client_by_email.php", {
            method: "POST",
            dataType: "json",
            mode: "cors",
            credentials: "same-origin",
            headers: {
              "Access-Control-Allow-Origin": "*",
            },
            body: JSON.stringify({
              email: this.email,
            }),
          }).then((res) => res.json());

          // Check again if the client was successfully retrieved.
          if (res.success) {
            this.client_data = res.client_data;
          } else {
            this.$refs.snackbar.error(res.msg);
          }
        } catch (err) {
          this.$refs.snackbar.error(err);
          return;
        }

        // Creating a client for an inquiry.
        if (this.client_type === "inquiry") {
          this.close();
          this.show_inquiry_modal2 = true;
        } else if (this.client_type === "order") {
          // Creating a client for an order.
          this.close();
          this.show_order_modal2 = true;
        }
        this.$refs.snackbar.info("Kunde erflogreich angelegt.");
      } else {
        this.$refs.snackbar.error(res.msg);
      }
    },
    close_inquiry_modal2: function () {
      this.show_inquiry_modal2 = false;
    },
    close_order_modal2: function () {
      this.show_order_modal2 = false;
    },
  },
  components: {
    inquiry_modal2,
    order_modal2,
    Snackbar,
  },
};
</script>

<style>
#component_client_modal .modal-container {
  overflow-y: scroll;
  width: 50%;
  height: 90%;
}

#component_client_modal .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}

#component_client_modal #div_create_client button {
  float: left;
  display: flex;
  flex-flow: row nowrap;
  justify-content: space-between;
  align-items: center;
}

#component_client_modal #div_create_client .div_small_border {
  border-left: 2px solid white;
  height: 45px;
  margin-left: 5px;
  margin-right: 5px;
}

#component_client_modal #div_create_client h4 {
  margin: 0;
}

#component_client_modal select {
  cursor: pointer;
}
</style>
