<template>
  <div id="component_client_modal">
    <modal v-if="showClientModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div id="modal_anfrage-erstellen-1" class="modal-container">
              <div class="modal-header">
                <h5 v-if="clientType === 'inquiry'">Legen Sie den Kunden zur Anfrage an.</h5>
                <h5 v-else-if="clientType === 'order'">Legen Sie den Kunden zum Auftrag an.</h5>
                <button class="modal-default-button" v-on:click="close()">X</button>
              </div>
              <div class="modal-body">
                <form v-on:submit="create_client($event)" id="kunden_anlegen" method="POST">
                  <div>
                    <div class="kunden_input form-group">
                      <label for="bv_firmenname">Firmenname</label>
                      <input
                        required
                        type="text"
                        class="form-control"
                        id="bv_firmenname"
                        name="bv_firmenname"
                        placeholder="Firmenname ..."
                        v-model="clientName"
                      />
                    </div>
                    <div class="kunden_input form-group input-group mb-3">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="bv_anrede">Anrede</label>
                      </div>
                      <select
                        v-model="salutation"
                        class="custom-select"
                        id="bv_anrede"
                        name="bv_anrede"
                      >
                        <option value="Herr">Herr</option>
                        <option value="Frau">Frau</option>
                      </select>
                    </div>
                    <div class="kunden_input form-group">
                      <label for="bv_freitext">Freitext</label>
                      <textarea
                        class="form-control"
                        id="bv_freitext"
                        name="bv_freitext"
                        rows="10"
                        placeholder="Freitext ..."
                        v-model="freeText"
                      ></textarea>
                    </div>
                    <div class="kunden_input form-group">
                      <label for="bv_email">Email</label>
                      <input
                        required
                        type="email"
                        class="form-control"
                        id="bv_email"
                        name="bv_email"
                        placeholder="Email Adresse ..."
                        v-model="email"
                      />
                    </div>
                    <div class="kunden_input form-group">
                      <label for="bv_telefon">Telefon</label>
                      <input
                        required
                        type="tel"
                        class="form-control"
                        id="bv_telefon"
                        name="bv_telefon"
                        placeholder="Telefon ..."
                        v-model="phone"
                      />
                    </div>
                    <div class="kunden_input form-group">
                      <label for="bv_ort">Ort</label>
                      <input
                        required
                        type="text"
                        class="form-control"
                        id="bv_ort"
                        name="bv_ort"
                        placeholder="Ort ..."
                        v-model="place"
                      />
                    </div>
                    <div class="kunden_input form-group">
                      <label for="bv_hausnummer">Hausnummer</label>
                      <input
                        required
                        type="text"
                        class="form-control"
                        id="bv_hausnummer"
                        name="bv_hausnummer"
                        placeholder="Hausnummer ..."
                        v-model="houseNumber"
                      />
                    </div>
                    <div class="kunden_input form-group">
                      <label for="bv_plz">PLZ</label>
                      <input
                        required
                        type="number"
                        class="form-control"
                        id="bv_plz"
                        name="bv_plz"
                        placeholder="PLZ ..."
                        v-model="postcode"
                      />
                    </div>
                    <div class="kunden_input form-group">
                      <label for="bv_land">Land</label>
                      <input
                        required
                        type="text"
                        class="form-control"
                        id="bv_land"
                        name="bv_land"
                        placeholder="Land ..."
                        v-model="country"
                      />
                    </div>
                    <div class="kunden_input form-group">
                      <label for="bv_ztelefon">Zentrale Telefonnummer</label>
                      <input
                        required
                        type="tel"
                        class="form-control"
                        id="bv_ztelefon"
                        name="bv_ztelefon"
                        placeholder="Zentrale Telefonnummer ..."
                        v-model="centralPhone"
                      />
                    </div>
                    <div class="kunden_input form-group">
                      <label for="bv_ansprechpartner">Ansprechpartner</label>
                      <input
                        required
                        type="text"
                        class="form-control"
                        id="bv_ansprechpartner"
                        name="bv_ansprechpartner"
                        placeholder="Ansprechpartner ..."
                        v-model="contactPerson"
                      />
                    </div>
                    <div class="kunden_input form-group">
                      <label for="bv_strasse">Straße</label>
                      <input
                        required
                        type="text"
                        class="form-control"
                        id="bv_strasse"
                        name="bv_strasse"
                        placeholder="Straße ..."
                        v-model="street"
                      />
                    </div>
                    <div class="kunden_input form-check">
                      <input
                        type="checkbox"
                        class="form-check-input"
                        name="bv_kunden_informieren"
                        id="bv_kunden_informieren"
                        v-model="informClient"
                      />
                      <label
                        class="form-check-label"
                        for="bv_kunden_informieren"
                      >Kunden über Accounterstellung via E-Mail informieren</label>
                    </div>
                    <div class="kunden_input">
                      <button type="submit" class="btn btn-primary">Anlegen</button>
                    </div>
                  </div>
                </form>
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
  name: "client_modal",
  props: ["showClientModal", "clientType"],
  data: function () {
    return {
      clientName: "",
      salutation: "",
      freeText: "",
      email: "",
      phone: "",
      place: "",
      houseNumber: -1,
      postcode: -1,
      country: "",
      centralPhone: "",
      contactPerson: "",
      street: "",
      informClient: false,
    };
  },
  methods: {
    close: function () {
      this.showClientModal = false;
      this.$emit("close_client_modal");
    },
    create_client(e) {
      e.preventDefault();
      // Creating a client for an inquiry.
      if (this.clientType === "inquiry") {
        console.log(this.clientName, this.salutation);
      } else if (this.clientType === "order") {
        // Creating a client for an order.
      }
    },
  },
};
</script>

<style>
/* Modal part. */
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 50%;
  height: 90%;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
  border: none;
  background: none;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>