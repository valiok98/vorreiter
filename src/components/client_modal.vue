<template>
  <div id="component_client_modal">
    <modal v-if="showClientModal">
      <transition>
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div>
              <div class="modal-header">
                <h5 v-if="clientType === 'inquiry'">Legen Sie den Kunden zur Anfrage an.</h5>
                <h5 v-else-if="clientType === 'order'">Legen Sie den Kunden zum Auftrag an.</h5>
                <button class="modal-default-button" v-on:click="close()">X</button>
              </div>
              <div class="modal-body">
                <form v-on:submit="create_client($event)" method="POST">
                  <div>
                    <div class="kunden_input form-group">
                      <label for="bv_firmenname">Firmenname</label>
                      <input
                        required
                        type="text"
                        class="form-control"
                        placeholder="Firmenname ..."
                        v-model="clientName"
                      />
                    </div>
                    <div class="kunden_input form-group input-group mb-3">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="bv_anrede">Anrede</label>
                      </div>
                      <select v-model="salutation" class="custom-select">
                        <option value="Herr">Herr</option>
                        <option value="Frau">Frau</option>
                      </select>
                    </div>
                    <div class="kunden_input form-group">
                      <label for="bv_freitext">Freitext</label>
                      <textarea
                        class="form-control"
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
                        placeholder="Straße ..."
                        v-model="street"
                      />
                    </div>
                    <div class="kunden_input form-check">
                      <input type="checkbox" class="form-check-input" v-model="informClient" />
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
    <inquiry_modal2 :clientData="clientData" :showInquiryModal2="showInquiryModal2"></inquiry_modal2>
    <order_modal2 :clientData="clientData" :showOrderModal2="showOrderModal2"></order_modal2>
  </div>
</template>

<script>
import inquiry_modal2 from "./inquiry_modal2";
import order_modal2 from "./order_modal2";

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
      clientData: {},
      showInquiryModal2: false,
      showOrderModal2: false,
    };
  },
  methods: {
    close: function () {
      this.showClientModal = false;
      this.$emit("close_client_modal");
    },
    create_client(e) {
      e.preventDefault();
      // Send the creation request.
      fetch(mainUrl + "admin_content/ajax/create_client.php", {
        method: "POST",
        dataType: "json",
        mode: "cors",
        credentials: "same-origin",
        headers: {
          "Access-Control-Allow-Origin": "*",
        },
        body: JSON.stringify({
          clientName: this.clientName,
          salutation: this.salutation,
          freeText: this.freeText,
          email: this.email,
          phone: this.phone,
          place: this.place,
          houseNumber: this.houseNumber,
          postcode: this.postcode,
          country: this.country,
          centralPhone: this.centralPhone,
          contactPerson: this.contactPerson,
          street: this.street,
          informClient: this.informClient,
        }),
      })
        .then((res) => res.json())
        .then((res) => {
          console.log(res);
          if (res.success && res.hasOwnProperty("clientData")) {
            this.clientData = res.clientData;
            // Creating a client for an inquiry.
            if (this.clientType === "inquiry") {
              this.close();
              this.showInquiryModal2 = true;
            } else if (this.clientType === "order") {
              // Creating a client for an order.
              this.close();
              this.showOrderModal2 = true;
            }
          }
        })
        .catch((err) => console.log(err));
    },
  },
  components: {
    inquiry_modal2,
    order_modal2,
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

#component_client_modal #kunden_anlegen {
  width: 100%;
  height: 100%;
  max-width: 100%;
  max-height: 100%;
}

#component_client_modal #kunden_anlegen > div {
  display: grid;
  grid-gap: 10px;
}

#component_client_modal .kunden_input:nth-of-type(1),
#component_client_modal .kunden_input:nth-of-type(4),
#component_client_modal .kunden_input:nth-of-type(6),
#component_client_modal .kunden_input:nth-of-type(8),
#component_client_modal .kunden_input:nth-of-type(10),
#component_client_modal .kunden_input:nth-of-type(12) {
  grid-column-start: 1;
  grid-column-end: 2;
}

#component_client_modal .kunden_input:nth-of-type(2),
#component_client_modal .kunden_input:nth-of-type(5),
#component_client_modal .kunden_input:nth-of-type(7),
#component_client_modal .kunden_input:nth-of-type(9),
#component_client_modal .kunden_input:nth-of-type(11) {
  grid-column-start: 2;
  grid-column-end: 3;
}

#component_client_modal .kunden_input:nth-of-type(2) {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 30px;
}

#component_client_modal .kunden_input:nth-of-type(3) {
  grid-column-start: 3;
  grid-column-end: 4;
  grid-row-start: 1;
  grid-row-end: 6;
}

#component_client_modal .kunden_input:nth-of-type(3) textarea {
  height: 100%;
}

#component_client_modal .kunden_input:nth-of-type(13) {
  grid-column-start: 2;
  grid-column-end: 3;
  margin-top: 30px;
}

#component_client_modal .kunden_input:nth-of-type(14) {
  grid-column-start: 3;
  grid-column-end: 4;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>