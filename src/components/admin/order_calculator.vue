<template>
  <div class="container-fluid" id="component_order_calculator">
    <form
      v-on:submit="add_package($event)"
      id="ordVersandrechner"
      class="m-form"
    >
      <div class="row">
        <h4>Wann dürfen wir für Sie zustellen?</h4>
      </div>
      <div class="row">
        <div class="col-sm-5 smaller">Zustellfenster:</div>
        <div class="col-sm-7 form-group smaller">
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="2"
              required
              v-model="deliveryTimeIndex"
            />
            <label class="form-check-label">07:30 – 08:00 Uhr</label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="3"
              v-model="deliveryTimeIndex"
            />
            <label class="form-check-label">08:00 – 09:00 Uhr</label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="5"
              v-model="deliveryTimeIndex"
            />
            <label class="form-check-label">08:00 – 10:00 Uhr</label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="6"
              v-model="deliveryTimeIndex"
            />
            <label class="form-check-label">08:00 – 12:00 Uhr</label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="7"
              v-model="deliveryTimeIndex"
            />
            <label class="form-check-label">09:00 – 17:00 Uhr</label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="-1"
              v-model="deliveryTimeIndex"
            />
            <label class="form-check-label">Fixtermin</label>
          </div>
        </div>
        <div class="col-sm-5 smaller">Zustellung am:</div>
        <div class="col-sm-7 form-group smaller">
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="Mo. – Fr. (am folgenen Werktag)"
              required
              v-model="deliveryDay"
            />
            <label class="form-check-label"
              >Mo. – Fr. (am folgenen Werktag)</label
            >
          </div>

          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="Samstag"
              v-model="deliveryDay"
            />
            <label class="form-check-label">Samstag</label>
          </div>

          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="Sonn-/Feiertag"
              v-model="deliveryDay"
            />
            <label class="form-check-label">Sonn-/Feiertag</label>
          </div>
        </div>
      </div>
      <div class="row" id="ordMassAndWeight">
        <h4>Maße und Gewicht Ihrer Sendung:</h4>
      </div>
      <div class="row form-group">
        <input
          type="text"
          minlength="1"
          maxlength="6"
          size="1"
          pattern="[0-9]+"
          class="form-control ordSizeInput"
          placeholder="Länge"
          required
          v-on:input="calculate_volumeweight()"
          v-model="sizeX"
        />
        <span>&nbsp;x&nbsp;</span>
        <input
          type="text"
          minlength="1"
          maxlength="6"
          size="1"
          pattern="[0-9]+"
          class="form-control ordSizeInput"
          placeholder="Breite"
          required
          v-on:input="calculate_volumeweight()"
          v-model="sizeY"
        />
        <span>&nbsp;x&nbsp;</span>
        <input
          type="text"
          minlength="1"
          maxlength="6"
          size="1"
          pattern="[0-9]+"
          class="form-control ordSizeInput"
          placeholder="Höhe"
          required
          v-on:input="calculate_volumeweight()"
          v-model="sizeZ"
        />
        <span>&nbsp;cm&nbsp;</span>
      </div>
      <div class="row form-group">
        <div class="col-sm-6">
          <div>
            <label>Resultierendes Volumengewicht:</label>
          </div>
          <div class="col-sm-6 form-inline">
            <input
              type="text"
              size="1"
              pattern="[0-9]+"
              class="form-control ordWeightInput"
              value="0"
              disabled
              v-model="volumeWeight"
            />
            <span>&nbsp;kg&nbsp;&nbsp;</span>
          </div>
        </div>
        <div class="col-sm-6 form-inline">
          <input
            type="text"
            placeholder="Gewicht"
            minlength="1"
            maxlength="6"
            size="1"
            pattern="[0-9]+"
            class="form-control ordWeightInput"
            required
            id="inputWeight"
            v-on:input="calculate_volumeweight()"
            v-model="weight"
          />
          <span>&nbsp;kg&nbsp;&nbsp;</span>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-sm-6">
          <button type="submit" id="ordNeworder">
            <img v-bind:src="packageImg.src" v-bind:alt="packageImg.alt" />
            <h5>
              <b>Sendung hinzufügen</b>
            </h5>
          </button>
        </div>
        <div class="col-sm-6">
          <div class="form-check">
            <input
              type="checkbox"
              class="form-check-input"
              v-model="createInvoice"
            />
            <label class="form-check-label" for="bv_rechnung_erstellen"
              >Rechnung automatisch erstellen</label
            >
          </div>
        </div>
      </div>
      <div v-if="packages.length" id="ordPackages" class="row">
        <div class="row">
          <h5>Packages</h5>
        </div>
        <div class="row">
          <div
            v-bind:key="package_.id"
            v-for="package_ in packages"
            class="col-sm-12"
          >
            <b-h3 v-on:click="collapse_accordion_item(package_.elemId)">
              <span>Package {{ package_.id + 1 }}</span>
              <b-button
                v-on:click="delete_accordion_item(package_.id)"
                type="button"
                class="deleteAccItem"
                >X</b-button
              >
            </b-h3>
            <b-collapse
              v-bind:id="package_.elemId"
              accordion="my-accordion"
              class="collapseElem"
            >
              <b-ul>
                <li>Sendungsnummer: {{ package_.id + 1 }}</li>
                <li>Zeitfenster: {{ package_.deliveryTime }}</li>
                <li>Zustelltag: {{ package_.deliveryDay }}</li>
                <li>Größe-X: {{ package_.sizeX }}</li>
                <li>Größe-Y: {{ package_.sizeY }}</li>
                <li>Größe-Z: {{ package_.sizeZ }}</li>
                <li>Volumengewicht: {{ package_.volumeWeight }}</li>
                <li>Gewicht: {{ package_.weight }}</li>
                <li>Preis: {{ package_.price }}</li>
                <li v-if="package_.services.length">
                  <span>Dienstleistungen:</span>
                  <br />
                  <b-ul v-if="package_.services.length">
                    <li
                      v-bind:key="service.id"
                      v-for="service in package_.services"
                    >
                      {{ service.title }}
                    </li>
                  </b-ul>
                </li>
              </b-ul>
            </b-collapse>
          </div>
        </div>
        <!-- The modal responsible for deleting the accordion items. -->
        <delete_package_modal
          :showDeletePackageModal="showDeletePackageModal"
          :packageId="packageId"
          :modalHeader="DeletePackageModalHeader"
          :modalBody="DeletePackageModalBody"
          v-on:cancel_item_deletion="cancel_item_deletion()"
          v-on:confirm_item_deletion="confirm_item_deletion($event)"
        ></delete_package_modal>
        <br />
        <br />
      </div>
      <div class="form-group row">
        <h4 id="ord_serviceheadline">
          Zusätzliche Serviceleistungen
          <br />
          <small>
            [Nachname, Empfangsbestätigung, ...]
            <br />
            <a
              v-if="!showServiceSelection"
              v-on:click="showServiceSelection = true"
              >Bitte klicken</a
            >
            <a v-else v-on:click="showServiceSelection = false">Ausklappen</a>
          </small>
        </h4>
        <div v-if="showServiceSelection" id="ordServiceSelection">
          <div class="tbl">
            <div class="tblrow">
              <div class="tblcell">Fixe Zustellung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">50,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="0" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Bereichszustellung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">5,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="1" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Empfangsbestätigung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">4,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="2" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Empfangsbestätigung (telefonisch)</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">2,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="3" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">
                Höherhaftung bis 2.500&nbsp;€ pro Sendung
              </div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">3,50&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="4" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Indet-Zustellung mit Vertragsservice</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">7,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="5" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Insel-Zustellung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">30,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="6" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">
                Lagerung nicht zugestellter Sendung je Tag
              </div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">1,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="7" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Messeservice</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">10,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="8" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Nachnahme</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">8,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="9" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">
                Persönliche Zustellung mit Dokumentation
              </div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">5,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="10" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Samstagszustellung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">2,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="11" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">SmartPic</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">46,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="12" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">SmartPic+</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">50,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="13" v-model="services" />
              </div>
            </div>
            <div class="tblrow">
              <div class="tblcell">Sonn- und Feiertagszustellung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">40,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="14" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Verpackungsrückführung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">2,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="15" v-model="services" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">X-Change</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">2,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="16" v-model="services" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-12" id="ordSendPackages">
          <b-button
            type="button"
            v-on:click="send_packages()"
            value="abs"
            class="btn btn-primary"
            variant="success"
            v-bind:disabled="!packages.length"
          >
            <img v-bind:src="confirmImg.src" v-bind:alt="confirmImg.alt" />
          </b-button>
        </div>
      </div>
    </form>
    <snackbar
      ref="snackbar"
      baseSize="100px"
      position="bottom-right"
    ></snackbar>
    <order_invoice :invoiceId="''" :clientData="clientData"></order_invoice>
  </div>
</template>

<script>
import delete_package_modal from "./delete_package_modal.vue";
import order_invoice from "./order_invoice.vue";
import Snackbar from "vuejs-snackbar";

export default {
  name: "order_calculator",
  props: ["clientData", "fromAddress", "toAddress"],
  data: function () {
    return {
      deliveryTimeIndex: "",
      deliveryTime: "",
      deliveryDay: "",
      sizeX: "",
      sizeY: "",
      sizeZ: "",
      volumeWeight: "",
      weight: "",
      price: "",
      priceString: "",
      taxString: "",
      services: [],
      showServiceSelection: false,
      showDeletePackageModal: false,
      packageId: -1,
      DeletePackageModalHeader: "Deleting a package",
      DeletePackageModalBody:
        "Deleting the package is irrevirsible. Are you sure ?",
      packageImg: {
        src: "../images/auftrag/icon_add.png",
        alt: "Sendung hinzufügen",
      },
      confirmImg: {
        src: "../images/modal/button_confirm.gif",
        alt: "Close modal",
      },

      deliveryTimes: [
        { value: 2, title: "07:30 – 08:00 Uhr" },
        { value: 3, title: "08:00 – 09:00 Uhr" },
        { value: 5, title: "08:00 – 10:00 Uhr" },
        { value: 6, title: "08:00 – 12:00 Uhr" },
        { value: 7, title: "09:00 – 17:00 Uhr" },
        { value: -1, title: "Fixtermin" },
      ],
      serviceSelection: [
        { id: 0, title: "Fixe Zustellung" },
        { id: 1, title: "Bereichszustellung" },
        { id: 2, title: "Empfangsbestaetigung" },
        { id: 3, title: "Empfangsbestaetigung telefonisch" },
        { id: 4, title: "Hoeherhaftung" },
        { id: 5, title: "Indet-Zustellung Vertragsservice" },
        { id: 6, title: "Insel-Zustellung" },
        { id: 7, title: "Lagerung" },
        { id: 8, title: "Messeservice" },
        { id: 9, title: "Nachnahme" },
        { id: 10, title: "Persoenliche Zustellung" },
        { id: 11, title: "Samstagszustellung" },
        { id: 12, title: "SmartPic" },
        { id: 13, title: "SmartPic+" },
        { id: 14, title: "Sonntagszustellung" },
        { id: 15, title: "Verpackungsrueckführung" },
        { id: 16, title: "X-Change" },
      ],
      packages: [],
    };
  },
  components: {
    delete_package_modal,
    order_invoice,
    Snackbar,
  },
  methods: {
    collapse_accordion_item: function (elemId) {
      this.$root.$emit("bv::toggle::collapse", elemId);
    },
    order_invoice: function () {
      const element = document.getElementById("orderInvoice_");
      const opt = {
        filename: `document.pdf`,
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: "mm", format: "letter", orientation: "portrait" },
      };
      html2pdf().from(element).set(opt).save();
    },
    send_packages: function () {
      fetch(mainUrl + "admin_content/ajax/create_order.php", {
        method: "POST",
        dataType: "json",
        mode: "cors",
        credentials: "same-origin",
        headers: {
          "Access-Control-Allow-Origin": "*",
        },
        body: JSON.stringify({
          deliveryTime: this.deliveryTime,
          deliveryDay: this.deliveryDay,
          volumeWeight: this.volumeWeight,
          clientId: this.clientData.clientId,
          fromAddress: this.fromAddress,
          toAddress: this.toAddress,
          packages: this.packages,
        }),
      })
        .then((res) => res.json())
        .then((res) => {
          console.log(res);
          if (res.success) {
            this.$refs.snackbar.info("Auftrag erflogreich angelegt.");
            this.order_invoice();
            return new Promise((resolve, reject) => setTimeout(resolve, 1000));
          } else {
            this.$refs.snackbar.error(res.msg);
          }
        })
        .then((res) => this.$emit("close_order_modal2"))
        .catch((err) => this.$refs.snackbar.error(err));
    },
    add_package: function (e) {
      e.preventDefault();
      let pLength = this.packages.length;
      // Form the new package id similar to Database principles. No id change on deletion.
      let pId = pLength === 0 ? 0 : this.packages[pLength - 1].id + 1;
      // Fix the deliveryTime.
      this.deliveryTime = this.deliveryTimes.find(
        (delTime) => delTime.value === parseInt(this.deliveryTimeIndex)
      ).title;
      // Calculate the price.
      this.calculate_price();
      console.log(this.services);

      this.packages.push({
        id: pId,
        elemId: "collapse-" + pId,
        deliveryTime: this.deliveryTime,
        deliveryDay: this.deliveryDay,
        sizeX: this.sizeX,
        sizeY: this.sizeY,
        sizeZ: this.sizeZ,
        volumeWeight: this.volumeWeight,
        weight: this.weight,
        price: this.price,
        services: this.services.map((service) => ({
          id: parseInt(service),
          title: this.serviceSelection.find((s) => s.id === parseInt(service))
            .title,
        })),
      });
    },
    delete_accordion_item: function (packageId) {
      this.showDeletePackageModal = true;
      this.packageId = packageId;
    },
    cancel_item_deletion: function () {
      this.showDeletePackageModal = false;
    },
    confirm_item_deletion: function (packageId) {
      this.showDeletePackageModal = false;
      this.packages = this.packages.filter(
        (package_) => package_.id !== packageId
      );
    },
    calculate_volumeweight: function () {
      this.volumeWeight = Math.ceil(
        (this.sizeX * this.sizeY * this.sizeZ) / 6000,
        -1
      );
      if (isNaN(this.volumeWeight)) {
        this.volumeWeight = 0;
      }
    },
    calculate_price: function () {
      let zone = parseInt(this.deliveryTimeIndex);
      let basicPrice = {
        7: 16.2,
        6: 25.59,
        5: 29.45,
        3: 36.39,
        2: 54.74,
        0: 0,
        "-1": 0,
      };
      let misalignmentPrice = {
        7: 0,
        6: 0,
        5: 0,
        3: 0,
        2: 0,
        0: 0,
        "-1": 0,
      };
      let priceIncrease = {
        7: 0.8,
        6: 0.8,
        5: 0.8,
        3: 0.8,
        2: 0.8,
        0: 0,
        "-1": 0,
      };
      let priceIncreaseHigh = {
        7: 1.0,
        6: 0.8, // ausnahme
        5: 1.0,
        3: 1.0,
        2: 1.0,
        0: 0,
        "-1": 0,
      };

      let additional = 0;

      if (this.weight < 31) {
        this.price =
          (basicPrice[zone] + (this.weight - 1) * priceIncrease[zone]) * 1.3 +
          1;
      } else {
        this.price =
          (basicPrice[zone] + 29 * priceIncrease[zone]) * 1.3 +
          1 +
          (this.weight - 30) * priceIncreaseHigh[zone] * 1.3;
      }
      // sonderheit bei zone 2
      if (this.weight > 1) {
        this.price =
          this.price - misalignmentPrice[zone] * priceIncrease[zone] * 1.3;
      }

      let serviceValues = this.services.map((s) => s.id);
      if (serviceValues.includes(1)) additional = additional + 50;
      if (serviceValues.includes(2)) additional = additional + 5;
      if (serviceValues.includes(3)) additional = additional + 4;
      if (serviceValues.includes(4)) additional = additional + 2;
      if (serviceValues.includes(5)) additional = additional + 3.5;
      if (serviceValues.includes(6)) additional = additional + 7;
      if (serviceValues.includes(7)) additional = additional + 30;
      if (serviceValues.includes(8)) additional = additional + 1;
      if (serviceValues.includes(9)) additional = additional + 10;
      if (serviceValues.includes(11)) additional = additional + 8;
      if (serviceValues.includes(12)) additional = additional + 5;
      if (serviceValues.includes(13)) additional = additional + 2;
      if (serviceValues.includes(14)) additional = additional + 46;
      if (serviceValues.includes(15)) additional = additional + 50;
      if (serviceValues.includes(16)) additional = additional + 40;
      if (serviceValues.includes(17)) additional = additional + 2;
      if (serviceValues.includes(18)) additional = additional + 2;

      this.price = Math.round((this.price + additional) * 100) / 100;

      if (this.weight < 50) {
        this.priceString = "€ " + this.price.toFixed(2).replace(".", ",");
        this.taxString =
          "€ " + (this.price * 0.19).toFixed(2).replace(".", ",");
      }
    },
  },
};
</script>

<style>
#component_order_calculator .row .col-sm-6 {
  padding: 0;
  text-align: left;
}
#component_order_calculator .tbl {
  display: inline-table;
  padding: 5px;
  width: 100%;
}

#component_order_calculator .tblrow {
  display: table-row;
  width: 100%;
}

#component_order_calculator .tblcell {
  display: table-cell;
  text-align: right;
  padding-left: 4px;
  padding-top: 5px;
}

#component_order_calculator .tblcell:first-of-type {
  text-align: left;
  padding-left: 0;
}

#component_order_calculator .col-sm-7 {
  font-size: 0.9em;
}

#component_order_calculator #ord_serviceheadline small {
  font-size: 0.6em;
}

#component_order_calculator #ordNeworder {
  border: none;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
}
/* Mass and Weight part. */
#component_order_calculator input.ordSizeInput {
  width: 25%;
}
#component_order_calculator input.ordWeightInput {
  width: 75%;
}

/* Accordion part. */
#component_order_calculator #ordPackages {
  width: 100%;
}
#component_order_calculator b-h3 {
  background: #f2f2f2;
  border: 1px solid black;
  border-radius: 3px;
  width: 100%;
  display: block;
  padding: 5px;
  cursor: pointer;
}
#component_order_calculator .collapseElem {
  background: #f2f2f2;
}
#component_order_calculator b-ul {
  display: block;
  padding: 20px;
  border: 1px solid black;
  border-radius: 3px;
}

#component_order_calculator .deleteAccItem {
  background: none;
  color: black;
  border: none;
  float: right;
  margin: 0;
  padding: 0;
  padding-right: 5px;
}

#component_order_calculator #ordSendPackages {
  padding: 0;
}
#component_order_calculator #ordSendPackages button {
  float: left;
}

#component_order_calculator .component_order_invoice {
  display: none;
}
</style>