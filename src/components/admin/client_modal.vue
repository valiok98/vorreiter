<template>
  <div id="component_client_modal">
    <modal v-if="showClientModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5 v-if="clientType === 'inquiry'">
                  Legen Sie den Kunden zur Anfrage an
                </h5>
                <h5 v-else-if="clientType === 'order'">
                  Legen Sie den Kunden zum Auftrag an
                </h5>
                <button class="modal-default-button" v-on:click="close()">
                  <img v-bind:src="closeImg.src" v-bind:alt="closeImg.alt" />
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
                              <label for="bv_firmenname">Firmenname</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                placeholder="Firmenname ..."
                                v-model="clientName"
                              />
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="bv_anrede">Anrede</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                placeholder="Anrede ..."
                                v-model="salutation"
                              />
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="bv_titel">Titel</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                placeholder="Titel ..."
                                v-model="title"
                              />
                            </div>
                          </div>
                          <div class="col-sm-4"></div>
                        </div>
                        <div class="row"></div>
                      </div>
                      <div class="col-sm-8">
                        <div class="form-group">
                          <label for="bv_freitext">Freitext</label>
                          <textarea
                            class="form-control"
                            rows="5"
                            placeholder="Freitext ..."
                            v-model="freeText"
                          ></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="bv_vorname">Vorname</label>
                          <input
                            v-on:input="adjust_client_abv()"
                            required
                            type="text"
                            class="form-control"
                            placeholder="Vorname ..."
                            v-model="firstName"
                          />
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="bv_nachname">Nachname</label>
                          <input
                            v-on:input="adjust_client_abv()"
                            required
                            type="text"
                            class="form-control"
                            placeholder="Nachname ..."
                            v-model="lastName"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="bv_telefon">Telefon</label>
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
                          <label for="bv_email">Email</label>
                          <input
                            required
                            type="email"
                            class="form-control"
                            placeholder="Email Adresse ..."
                            v-model="email"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="bv_strasse">Straße</label>
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
                          <label for="bv_hausnummer">Hausnummer</label>
                          <input
                            required
                            type="number"
                            class="form-control"
                            placeholder="Hausnummer ..."
                            v-model="houseNumber"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="bv_plz">PLZ</label>
                          <input
                            required
                            type="number"
                            class="form-control"
                            placeholder="PLZ ..."
                            v-model="postcode"
                          />
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="bv_ort">Ort</label>
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
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="bv_land"
                              >Land</label
                            >
                          </div>
                          <select v-model="country" class="custom-select">
                            <option
                              v-bind:key="cntr"
                              v-for="cntr in countriesList"
                              v-bind:value="cntr"
                            >
                              {{ cntr }}
                            </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="bv_ztelefon"
                            >Zentrale Telefonnummer</label
                          >
                          <input
                            required
                            type="tel"
                            class="form-control"
                            placeholder="Zentrale Telefonnummer ..."
                            v-model="centralPhone"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="bv_fax">Fax</label>
                          <input
                            required
                            type="text"
                            class="form-control"
                            placeholder="Fax ..."
                            v-model="fax"
                          />
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="bv_mobil">Mobil</label>
                          <input
                            required
                            type="tel"
                            class="form-control"
                            placeholder="Mobil ..."
                            v-model="mobilePhone"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="bv_kundenkuerzel">Kundenkürzel</label>
                          <input
                            required
                            type="text"
                            class="form-control"
                            v-model="clientAbv"
                          />
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-check">
                          <input
                            type="checkbox"
                            class="form-check-input"
                            v-model="informClient"
                          />
                          <label
                            class="form-check-label"
                            for="bv_kunden_informieren"
                            >Kunden über Accounterstellung via E-Mail
                            informieren</label
                          >
                        </div>
                      </div>
                    </div>
                    <div class="">
                      <button type="submit" class="btn btn-primary">
                        <img
                          v-bind:src="confirmImg.src"
                          v-bind:alt="confirmImg.alt"
                        />
                      </button>
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
      :clientData="clientData"
      :showInquiryModal2="showInquiryModal2"
      v-on:close_inquiry_modal2="close_inquiry_modal2()"
    ></inquiry_modal2>
    <order_modal2
      :clientData="clientData"
      :showOrderModal2="showOrderModal2"
      v-on:close_order_modal2="close_order_modal2()"
    ></order_modal2>
    <snackbar
      ref="snackbar"
      baseSize="100px"
      position="bottom-right"
    ></snackbar>
  </div>
</template>

<script>
import inquiry_modal2 from "./inquiry_modal2";
import order_modal2 from "./order_modal2";
import Snackbar from "vuejs-snackbar";

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
      firstName: "",
      lastName: "",
      title: "",
      mobilePhone: "",
      fax: "",
      clientAbv: "",
      place: "",
      houseNumber: "",
      postcode: "",
      country: "",
      centralPhone: "",
      street: "",
      informClient: false,
      clientData: {},
      showInquiryModal2: false,
      showOrderModal2: false,
      closeImg: {
        src: "../images/modal/close_window.gif",
        alt: "Close modal",
      },
      confirmImg: {
        src: "../images/modal/button_confirm.gif",
        alt: "Confirm",
      },
      countriesList: [
        "Deutschland",
        "Österreich",
        "Schweiz",
        "Afghanistan",
        "Ägypten",
        "Åland",
        "Albanien",
        "Algerien",
        "Amerikanisch-Samoa",
        "Amerikanische Jungferninseln",
        "Andorra",
        "Angola",
        "Anguilla",
        "Antarktis",
        "Antigua und Barbuda",
        "Äquatorialguinea",
        "Argentinien",
        "Armenien",
        "Aruba",
        "Ascension",
        "Aserbaidschan",
        "Äthiopien",
        "Australien",
        "Bahamas",
        "Bahrain",
        "Bangladesch",
        "Barbados",
        "Weißrussland",
        "Belgien",
        "Belize",
        "Benin",
        "Bermuda",
        "Bhutan",
        "Bolivien",
        "Bonaire",
        "Bosnien und Herzegowina",
        "Botswana",
        "Bouvetinsel",
        "Brasilien",
        "Britische Jungferninseln",
        "Britisches Territorium im Indischen Ozean",
        "Brunei",
        "Bulgarien",
        "Burkina Faso",
        "Burundi",
        "Ceuta",
        "Chile",
        "Volksrepublik China",
        "Clipperton",
        "Cookinseln",
        "Costa Rica",
        "Curaçao",
        "Dänemark",
        "Diego Garcia",
        "Dominica",
        "Dominikanische Republik",
        "Dschibuti",
        "Ecuador",
        "Elfenbeinküste",
        "El Salvador",
        "Eritrea",
        "Estland",
        "Eswatini",
        "Europäische Gemeinschaft",
        "Europäische Union",
        "Falklandinseln",
        "Färöer",
        "Fidschi",
        "Finnland",
        "Frankreich",
        "Frankreich France métropolitaine",
        "Französisch-Guayana",
        "Französisch-Polynesien",
        "Französische Süd- und Antarktisgebiete",
        "Gabun",
        "Gambia",
        "Georgien",
        "Ghana",
        "Gibraltar",
        "Grenada",
        "Griechenland",
        "Grönland",
        "Guadeloupe",
        "Guam",
        "Guatemala",
        "Guernsey",
        "Guinea",
        "Guinea-Bissau",
        "Guyana",
        "Haiti",
        "Heard und McDonaldinseln",
        "Honduras",
        "Hongkong",
        "Indien",
        "Indonesien",
        "Isle of Man",
        "Irak",
        "Iran",
        "Irland",
        "Island",
        "Israel",
        "Italien",
        "Jamaika",
        "Japan",
        "Jemen",
        "Jersey",
        "Jordanien",
        "Cayman Islands",
        "Kambodscha",
        "Kamerun",
        "Kanada",
        "Kanarische Inseln",
        "Kap Verde",
        "Kasachstan",
        "Katar",
        "Kenia",
        "Kirgisistan",
        "Kiribati",
        "Kokosinseln",
        "Kolumbien",
        "Komoren",
        "Demokratische Republik Kongo",
        "Republik Kongo",
        "Nordkorea",
        "Südkorea",
        "Kosovo",
        "Kroatien",
        "Kuba",
        "Kuwait",
        "Laos",
        "Lesotho",
        "Lettland",
        "Libanon",
        "Liberia",
        "Libyen",
        "Liechtenstein",
        "Litauen",
        "Luxemburg",
        "Macau",
        "Madagaskar",
        "Malawi",
        "Malaysia",
        "Malediven",
        "Mali",
        "Malta",
        "Marokko",
        "Marshallinseln",
        "Martinique",
        "Mauretanien",
        "Mauritius",
        "Mayotte",
        "Mexiko",
        "Mikronesien",
        "Moldau",
        "Monaco",
        "Mongolei",
        "Montenegro",
        "Montserrat",
        "Mosambik",
        "Myanmar",
        "Namibia",
        "Nauru",
        "Nepal",
        "Neukaledonien",
        "Neuseeland",
        "Nicaragua",
        "Niederlande",
        "Niederländische Antillen",
        "Niger",
        "Nigeria",
        "Niue",
        "Nördliche Marianen",
        "Nordmazedonien",
        "Türkische Republik Nordzypern",
        "Norfolkinsel",
        "Norwegen",
        "Oman",
        "Osttimor",
        "Pakistan",
        "Palästina",
        "Palau",
        "Panama",
        "Papua-Neuguinea",
        "Paraguay",
        "Peru",
        "Philippinen",
        "Pitcairninseln",
        "Polen",
        "Portugal",
        "Puerto Rico",
        "Réunion",
        "Ruanda",
        "Rumänien",
        "Russland",
        "Salomonen",
        "Saint-Barthélemy",
        "Saint-Martin",
        "Sambia",
        "Samoa",
        "San Marino",
        "São Tomé und Príncipe",
        "Saudi-Arabien",
        "Schweden",
        "Senegal",
        "Serbien",
        "Serbien und Montenegro",
        "Seychellen",
        "Sierra Leone",
        "Simbabwe",
        "Singapur",
        "Sint Maarten",
        "Slowakei",
        "Slowenien",
        "Somalia",
        "Spanien",
        "Sri Lanka",
        "St. Helena, Ascension und Tristan da Cunha",
        "St. Kitts und Nevis",
        "St. Lucia",
        "Saint-Pierre und Miquelon",
        "St. Vincent und die Grenadinen",
        "Südafrika",
        "Sudan",
        "Südgeorgien und die Südlichen Sandwichinseln",
        "Südsudan",
        "Suriname",
        "Spitzbergen",
        "Syrien",
        "Tadschikistan",
        "Taiwan",
        "Tansania",
        "Thailand",
        "Togo",
        "Tokelau",
        "Tonga",
        "Trinidad und Tobago",
        "Tristan da Cunha",
        "Tschad",
        "Tschechien",
        "Tschechoslowakei",
        "Tunesien",
        "Türkei",
        "Turkmenistan",
        "Turks- und Caicosinseln",
        "Tuvalu",
        "Sowjetunion",
        "Uganda",
        "Ukraine",
        "Ungarn",
        "United States Minor Outlying Islands",
        "Uruguay",
        "Usbekistan",
        "Vanuatu",
        "Vatikanstadt",
        "Venezuela",
        "Vereinigte Arabische Emirate",
        "Vereinigte Staaten",
        "Vereinigtes Königreich",
        "Vietnam",
        "Wallis und Futuna",
        "Weihnachtsinsel",
        "Westsahara",
        "Zaire",
        "Zentralafrikanische Republik",
        "Zypern",
      ],
    };
  },
  methods: {
    close: function () {
      this.showClientModal = false;
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

      if (this.firstName) {
        firstChar = this.firstName[0];
        midChar = get_first_consonant(this.lastName);
        lastChar = get_first_consonant(this.lastName.substr(1));
      } else if (this.lastName) {
        firstChar = this.lastName[0];
        midChar = get_first_consonant(this.lastName.substr(1));
        lastChar = get_first_consonant(this.lastName.substr(2));
      }
      this.clientAbv = firstChar + midChar + lastChar;
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
          firstName: this.firstName,
          lastName: this.lastName,
          title: this.title,
          mobilePhone: this.mobilePhone,
          clientAbv: this.clientAbv,
          fax: this.fax,
          place: this.place,
          houseNumber: this.houseNumber,
          postcode: this.postcode,
          country: this.country,
          centralPhone: this.centralPhone,
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
            this.$refs.snackbar.info("Kunde erflogreich angelegt.");
          } else {
            let errorMsg = res.msg;
            let snackbarMsg = errorMsg;
            if (errorMsg.includes("email")) {
              snackbarMsg =
                "Die E-Mail Adresse ist schon vergeben. Bitte eine andere wählen.";
            }
            this.$refs.snackbar.error(snackbarMsg);
          }
        })
        .catch((err) => this.$refs.snackbar.error(err));
    },
    close_inquiry_modal2: function () {
      this.showInquiryModal2 = false;
    },
    close_order_modal2: function () {
      this.showOrderModal2 = false;
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
</style>