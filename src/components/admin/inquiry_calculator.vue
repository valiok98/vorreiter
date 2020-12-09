<template>
  <div class="container-fluid" id="component_inquiry_calculator">
    <form
      v-on:submit="add_package($event)"
      id="inqVersandrechner"
      class="m-form"
    >
      <div class="row">
        <h5>Sendungsdetails</h5>
        <br />
        <h5>Wo soll das Paket abgeholt werden?</h5>
        <div>
          <p>Nur nationale / in Deutschland gültige PLZ eingeben.</p>
        </div>
        <input
          type="text"
          minlength="3"
          maxlength="10"
          size="5"
          pattern="[0-9]{3,10}"
          class="form-control"
          placeholder="Abhol-PLZ"
          required
          v-model="plzStart"
        />
        <br />
        <br />
      </div>
      <div class="row">
        <h5>Wohin soll das Paket geliefert werden?</h5>
        <div>
          <p>Nur nationale / in Deutschland gültige PLZ eingeben.</p>
        </div>
        <input
          type="text"
          minlength="3"
          maxlength="10"
          size="5"
          pattern="[0-9]{3,10}"
          class="form-control"
          placeholder="Ziel-PLZ"
          required
          v-model="plzEnd"
        />
        <br />
        <br />
      </div>
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
      <div class="row" id="inqMassAndWeight">
        <h4>Maße und Gewicht Ihrer Sendung:</h4>
        <br />
        <h6>
          <i
            ><b
              >Bitte beachten Sie: - Gutmasß
              <span style="color: red">max</span>. 520 cm // Gewicht
              <span style="color: red">max</span>. 50 kg</b
            ></i
          >
        </h6>
      </div>
      <div class="row form-group form-inline row_input">
        <div class="col-lg-3">
          <span
            class="label_input_size"
            for="input_laenge"
            style="color: #29ca8e"
            ><i>Länge</i></span
          >
          <br />
          <input
            type="number"
            min="1"
            max="390"
            class="form-control inqSizeInput"
            placeholder="Länge"
            required
            v-on:input="calculate_units()"
            v-model="sizeX"
          />
          <span><b>x</b></span>
        </div>
        <div class="col-lg-3">
          <span
            class="label_input_size"
            for="input_laenge"
            style="color: #29ca8e"
            ><i>Breite</i></span
          >
          <br />
          <input
            type="number"
            min="1"
            maxlength="999999"
            class="form-control inqSizeInput"
            placeholder="Breite"
            required
            v-on:input="calculate_units()"
            v-model="sizeY"
          />
          <span><b>x</b></span>
        </div>
        <div class="col-lg-3">
          <span
            class="label_input_size"
            for="input_laenge"
            style="color: #29ca8e"
            ><i>Höhe</i></span
          >
          <br />
          <input
            type="number"
            min="1"
            max="999999"
            class="form-control inqSizeInput"
            placeholder="Höhe"
            required
            v-on:input="calculate_units()"
            v-model="sizeZ"
          />
        </div>
        <div class="col-lg-1">
          <br />
          <span><b>cm</b></span>
        </div>
      </div>
      <div class="row form-group form-inline row_input"><br /></div>
      <div class="row form-group form-inline row_input">
        <div class="col-lg-6">
          <span>Resultierendes Gurtmaß:</span>
        </div>
        <div class="col-lg-3">
          <span style="color: #29ca8e"><i>Gewicht</i></span>
        </div>
      </div>
      <div class="row form-group form-inline row_input">
        <div class="col-lg-3">
          <input
            type="number"
            min="1"
            class="form-control inqWeightInput"
            value="0"
            disabled
            v-model="girth"
          />
        </div>
        <div class="col-lg-1">
          <span><b>cm</b></span>
        </div>
        <div class="col-lg-2"></div>
        <div class="col-lg-3">
          <input
            type="number"
            placeholder="Gewicht"
            min="1"
            max="50"
            class="form-control inqWeightInput"
            required
            id="inputWeight"
            v-on:input="calculate_units()"
            v-model="weight"
          />
        </div>
        <div class="col-lg-1">
          <span><b>kg</b></span>
        </div>
      </div>
      <div class="row form-group form-inline row_input"><br /></div>
      <div class="row row_input">
        <div>
          <span>Resultierendes Volumengewicht:</span>
        </div>
      </div>
      <div class="row form-group form-inline row_input">
        <div class="col-lg-3">
          <input
            type="text"
            size="1"
            pattern="[0-9]+"
            class="form-control inqWeightInput"
            value="0"
            disabled
            v-model="volumeWeight"
          />
        </div>
        <div class="col-lg-2">
          <span><b>kg</b></span>
        </div>
      </div>
      <div class="row form-group form-inline row_input"><br /></div>
      <div class="row form-group">
        <h4 id="inq_serviceheadline">
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
        <div v-if="showServiceSelection" id="inqServiceSelection">
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
        <button type="submit" id="inqNeworder">
          <div>
            <img v-bind:src="packageImg.src" v-bind:alt="packageImg.alt" />
          </div>
          <div>
            <h5>
              <b>Sendung kalkulieren</b>
            </h5>
          </div>
        </button>
      </div>
      <div v-if="packages.length" id="inqPackages" class="row">
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
                <li>PLZ Start: {{ package_.plzStart }}</li>
                <li>PLZ Ziel: {{ package_.plzEnd }}</li>
                <li>Zeitfenster: {{ package_.deliveryTime }}</li>
                <li>Zustelltag: {{ package_.deliveryDay }}</li>
                <li>Größe-X: {{ package_.sizeX }}</li>
                <li>Größe-Y: {{ package_.sizeY }}</li>
                <li>Größe-Z: {{ package_.sizeZ }}</li>
                <li>Volumengewicht: {{ package_.volumeWeight }}</li>
                <li>Gewicht: {{ package_.weight }}</li>
                <li>Gurtmaß: {{ package_.girth }}</li>
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
      <div class="row form-group form-inline row_input"><br /></div>
      <div class="row form-group">
        <div id="inqSendPackages">
          <b-button
            type="button"
            v-on:click="send_packages()"
            value="abs"
            variant="success"
            class="btn btn-primary"
            v-bind:disabled="!packages.length"
          >
            <img v-bind:src="checkmarkImg.src" v-bind:alt="checkmarkImg.alt" />
            <div class="div_small_border">
              <p></p>
            </div>
            <h4>Produkt anlegen</h4>
          </b-button>
        </div>

        <div class="ml-auto" id="inqConvertToOrder">
          <b-button
            type="button"
            v-on:click="convert_to_order()"
            value="abs"
            variant="warning"
            class="btn btn-primary"
            v-bind:disabled="!packages.length"
          >
            <img v-bind:src="checkmarkImg.src" v-bind:alt="checkmarkImg.alt" />
            <div class="div_small_border">
              <p></p>
            </div>
            <h4>Zum Auftrag</h4>
          </b-button>
        </div>
      </div>
    </form>
    <convert_inquiry_order_modal
      :showConvertInquiryOrderModal="showConvertInquiryOrderModal"
      v-on:close_convert_inquiry_order_modal="
        close_convert_inquiry_order_modal()
      "
    ></convert_inquiry_order_modal>
    <snackbar
      ref="snackbar"
      baseSize="100px"
      position="bottom-right"
    ></snackbar>
  </div>
</template>

<script>
import delete_package_modal from "./delete_package_modal.vue";
import Snackbar from "vuejs-snackbar";
import convert_inquiry_order_modal from "./convert_inquiry_order_modal.vue";

export default {
  name: "inquiry_calculator",
  props: ["clientData"],
  data: function () {
    return {
      plzStart: "",
      plzEnd: "",
      deliveryTimeIndex: "",
      deliveryTime: "",
      deliveryDay: "",
      sizeX: "",
      sizeY: "",
      sizeZ: "",
      volumeWeight: "",
      girth: "",
      weight: "",
      price: "",
      priceString: "",
      taxString: "",
      services: [],
      showServiceSelection: false,
      showDeletePackageModal: false,
      showConvertInquiryOrderModal: false,
      packageId: -1,
      DeletePackageModalHeader: "Deleting a package",
      DeletePackageModalBody:
        "Deleting the package is irrevirsible. Are you sure ?",
      packageImg: {
        src: "../images/auftrag/icon_add.png",
        alt: "Sendung hinzufügen",
      },
      checkmarkImg: {
        src: "../images/modal/checkmark.png",
        alt: "Bestätigen",
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
    Snackbar,
    convert_inquiry_order_modal,
  },
  methods: {
    collapse_accordion_item: function (elemId) {
      this.$root.$emit("bv::toggle::collapse", elemId);
    },
    convert_to_order: function () {
      this.showConvertInquiryOrderModal = true;
      this.close();
    },
    send_packages: function () {
      fetch(mainUrl + "admin_content/ajax/create_inquiry.php", {
        method: "POST",
        dataType: "json",
        mode: "cors",
        credentials: "same-origin",
        headers: {
          "Access-Control-Allow-Origin": "*",
        },
        body: JSON.stringify({
          plzStart: this.plzStart,
          plzEnd: this.plzEnd,
          deliveryTime: this.deliveryTime,
          deliveryDay: this.deliveryDay,
          volumeWeight: this.volumeWeight,
          clientId: this.clientData.clientId,
          packages: this.packages,
        }),
      })
        .then((res) => res.json())
        .then((res) => {
          console.log(res);
          if (res.success) {
            this.$refs.snackbar.info("Anfrage erflogreich angelegt.");
            return new Promise((resolve, reject) => setTimeout(resolve, 1000));
          } else {
            this.$refs.snackbar.error(res.msg);
          }
        })
        .then((res) => this.$emit("close_inquiry_modal2"))
        .catch((err) => this.$refs.snackbar.error(err));
    },
    close: function () {
      this.$emit("close_inquiry_modal2");
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
        plzStart: this.plzStart,
        plzEnd: this.plzEnd,
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
    calculate_units: function () {
      let faulty = false;

      this.sizeX = parseInt(this.sizeX);
      this.sizeY = parseInt(this.sizeY);
      this.sizeZ = parseInt(this.sizeZ);

      if (!this.sizeX || !this.sizeY || !this.sizeZ) {
        faulty = true;
      }

      if (this.sizeX < 0 || this.sizeY < 0 || this.sizeZ < 0) {
        faulty = true;
      }

      // Perform a check for the length.
      if (this.sizeX > 390) {
        this.sizeX = 390;
      }

      // Perform a check for the weight.
      if (this.weight > 50) {
        this.weight = 50;
      }

      // Calculate the volume weight.
      this.volumeWeight = Math.ceil(
        (this.sizeX * this.sizeY * this.sizeZ) / 6000,
        -1
      );

      // Check if the calculated volume weight is valid.
      if (isNaN(this.volumeWeight)) {
        faulty = true;
      }

      // Calculate the girth.
      this.girth = this.sizeX + this.sizeY * 2 + this.sizeZ * 2;

      if (faulty) {
        this.volumeWeight = 0;
        return;
      }
    },
    calculate_price: function () {
      let zone = parseInt(this.deliveryTimeIndex);

      let kg = parseInt(this.weight);
      if (parseInt(this.weight) < parseInt(this.volumeWeight)) {
        kg = parseInt(this.volumeWeight);
      }

      let price = 0;

      console.log("Zone: " + zone);
      console.log("Kg: " + kg);

      if (zone === -1) {
        price = this.get_price_zone_1(kg);
      } else if (zone === 2) {
        price = this.get_price_zone_2(kg);
      } else if (zone === 3) {
        price = this.get_price_zone_3(kg);
      } else if (zone === 5) {
        price = this.get_price_zone_5(kg);
      } else if (zone === 6) {
        price = this.get_price_zone_6(kg);
      } else if (zone === 7) {
        price = this.get_price_zone_7(kg);
      }

      if (this.deliveryDay === "Samstag") {
        price += 2;
      } else if (this.deliveryDay === "Sonn-/Feiertag") {
        price += 40;
      }

      let serviceValues = this.services.map((s) => s.id);

      if (serviceValues.includes(0)) price = price + 50;
      if (serviceValues.includes(1)) price = price + 5;
      if (serviceValues.includes(2)) price = price + 4;
      if (serviceValues.includes(3)) price = price + 2;
      if (serviceValues.includes(4)) price = price + 3.5;
      if (serviceValues.includes(5)) price = price + 7;
      if (serviceValues.includes(6)) price = price + 30;
      if (serviceValues.includes(7)) price = price + 1;
      if (serviceValues.includes(8)) price = price + 10;
      if (serviceValues.includes(9)) price = price + 8;
      if (serviceValues.includes(10)) price = price + 5;
      if (serviceValues.includes(11)) price = price + 46;
      if (serviceValues.includes(12)) price = price + 50;
      if (serviceValues.includes(13)) price = price + 2;
      if (serviceValues.includes(14)) price = price + 2;

      this.priceString = "€ " + price.toFixed(2).replace(".", ",");

      this.price = price.toFixed(2);
    },

    get_price_zone_7: function (kg) {
      const PRICES_ZONE_7 = [
        16.2,
        16.8,
        17.4,
        18.0,
        18.6,
        19.2,
        19.8,
        20.4,
        21.0,
        21.6,
        22.2,
        22.8,
        23.4,
        24.0,
        24.6,
        25.2,
        25.8,
        26.4,
        27.0,
        27.6,
        28.2,
        28.8,
        29.4,
        30.0,
        30.6,
        31.2,
        31.8,
        32.4,
        33.0,
        33.6,
        34.4,
        35.2,
        36.0,
        36.8,
        37.6,
        38.4,
        39.2,
        40.0,
        40.8,
        41.6,
        42.4,
        43.2,
        44.0,
        44.8,
        45.6,
        46.4,
        47.2,
        48.0,
        48.8,
        49.6,
        63.96,
        64.76,
        65.56,
        66.36,
        67.16,
        67.96,
        68.76,
        69.56,
        70.36,
        71.16,
        71.96,
        72.76,
        73.56,
        74.36,
        75.16,
        75.96,
        76.76,
        77.56,
        78.36,
        79.16,
        79.96,
        80.76,
        81.56,
        82.36,
        83.16,
        83.96,
        84.76,
        85.56,
        86.36,
        87.16,
        87.96,
        88.76,
        89.56,
        90.36,
        91.16,
        91.96,
        92.76,
        93.56,
        94.36,
        95.16,
        95.96,
        96.76,
        97.56,
        98.36,
        99.16,
        99.96,
        100.76,
        101.56,
        102.36,
        103.16,
        124.3,
        125.1,
        125.9,
        126.7,
        127.5,
        128.3,
        129.1,
        129.9,
        130.7,
        131.5,
        132.3,
        133.1,
        133.9,
        134.7,
        135.5,
        136.3,
        137.1,
        137.9,
        138.7,
        139.5,
        140.3,
        141.1,
        141.9,
        142.7,
        143.5,
        144.3,
        145.1,
        145.9,
        146.7,
        147.5,
        148.3,
        149.1,
        149.9,
        150.7,
        151.5,
        152.3,
        153.1,
        153.9,
        154.7,
        155.5,
        156.3,
        157.1,
        157.9,
        158.7,
        159.5,
        160.3,
        161.1,
        161.9,
        162.7,
        163.5,
        164.3,
        165.1,
        165.9,
        166.7,
        167.5,
        168.3,
        169.1,
        169.9,
        170.7,
        171.5,
        172.3,
        173.1,
        173.9,
        174.7,
        175.5,
        176.3,
        177.1,
        177.9,
        178.7,
        179.5,
        180.3,
        181.1,
        181.9,
        182.7,
        183.5,
        184.3,
        185.1,
        185.9,
        186.7,
        187.5,
        188.3,
        189.1,
        189.9,
        190.7,
        191.5,
        192.3,
        193.1,
        193.9,
        194.7,
        195.5,
        196.3,
        197.1,
        197.9,
        198.7,
        199.5,
        200.3,
        201.1,
        201.9,
        202.7,
        203.5,
        231.42,
        232.22,
        233.02,
        233.82,
        234.62,
        235.42,
        236.22,
        237.02,
        237.82,
        238.62,
        239.42,
        240.22,
        241.02,
        241.82,
        242.62,
        243.42,
        244.22,
        245.02,
        245.82,
        246.62,
        247.42,
        248.22,
        249.02,
        249.82,
        250.62,
        251.42,
        252.22,
        253.02,
        253.82,
        254.62,
        255.42,
        256.22,
        257.02,
        257.82,
        258.62,
        259.42,
        260.22,
        261.02,
        261.82,
        262.62,
        263.42,
        264.22,
        265.02,
        265.82,
        266.62,
        267.42,
        268.22,
        269.02,
        269.82,
        270.62,
        271.42,
        272.22,
        273.02,
        273.82,
        274.62,
        275.42,
        276.22,
        277.02,
        277.82,
        278.62,
        279.42,
        280.22,
        281.02,
        281.82,
        282.62,
        283.42,
        284.22,
        285.02,
        285.82,
        286.62,
        287.42,
        288.22,
        289.02,
        289.82,
        290.62,
        291.42,
        292.22,
        293.02,
        293.82,
        294.62,
        295.42,
        296.22,
        297.02,
        297.82,
        298.62,
        299.42,
        300.22,
        301.02,
        301.82,
        302.62,
        303.42,
        304.22,
        305.02,
        305.82,
        306.62,
        307.42,
        308.22,
        309.02,
        309.82,
        310.62,
      ];

      if (kg <= 300) {
        return PRICES_ZONE_7[kg - 1];
      }
      return 0;
    },

    get_price_zone_6: function (kg) {
      const PRICES_ZONE_6 = [
        25.59,
        26.19,
        26.79,
        27.39,
        27.99,
        28.59,
        29.19,
        29.79,
        30.39,
        30.99,
        31.59,
        32.19,
        32.79,
        33.39,
        33.99,
        34.59,
        35.19,
        35.79,
        36.39,
        36.99,
        37.59,
        38.19,
        38.79,
        39.39,
        39.99,
        40.59,
        41.19,
        41.79,
        42.39,
        42.99,
        43.79,
        44.59,
        45.39,
        46.19,
        46.99,
        47.79,
        48.59,
        49.39,
        50.19,
        50.99,
        51.79,
        52.59,
        53.39,
        54.19,
        54.99,
        55.79,
        56.59,
        57.39,
        58.19,
        58.99,
        73.35,
        74.15,
        74.95,
        75.75,
        76.55,
        77.35,
        78.15,
        78.95,
        79.75,
        80.55,
        81.35,
        82.15,
        82.95,
        83.75,
        84.55,
        85.35,
        86.15,
        86.95,
        87.75,
        88.55,
        89.35,
        90.15,
        90.95,
        91.75,
        92.55,
        93.35,
        94.15,
        94.95,
        95.75,
        96.55,
        97.35,
        98.15,
        98.95,
        99.75,
        100.55,
        101.35,
        102.15,
        102.95,
        103.75,
        104.55,
        105.35,
        106.15,
        106.95,
        107.75,
        108.55,
        109.35,
        110.15,
        110.95,
        111.75,
        112.55,
        133.68,
        134.48,
        135.28,
        136.08,
        136.88,
        137.68,
        138.48,
        139.28,
        140.08,
        140.88,
        141.68,
        142.48,
        143.28,
        144.08,
        144.88,
        145.68,
        146.48,
        147.28,
        148.08,
        148.88,
        149.68,
        150.48,
        151.28,
        152.08,
        152.88,
        153.68,
        154.48,
        155.28,
        156.08,
        156.88,
        157.68,
        158.48,
        159.28,
        160.08,
        160.88,
        161.68,
        162.48,
        163.28,
        164.08,
        164.88,
        165.68,
        166.48,
        167.28,
        168.08,
        168.88,
        169.68,
        170.48,
        171.28,
        172.08,
        172.88,
        173.68,
        174.48,
        175.28,
        176.08,
        176.88,
        177.68,
        178.48,
        179.28,
        180.08,
        180.88,
        181.68,
        182.48,
        183.28,
        184.08,
        184.88,
        185.68,
        186.48,
        187.28,
        188.08,
        188.88,
        189.68,
        190.48,
        191.28,
        192.08,
        192.88,
        193.68,
        194.48,
        195.28,
        196.08,
        196.88,
        197.68,
        198.48,
        199.28,
        200.08,
        200.88,
        201.68,
        202.48,
        203.28,
        204.08,
        204.88,
        205.68,
        206.48,
        207.28,
        208.08,
        208.88,
        209.68,
        210.48,
        211.28,
        212.08,
        212.88,
        240.8,
        241.6,
        242.4,
        243.2,
        244.0,
        244.8,
        245.6,
        246.4,
        247.2,
        248.0,
        248.8,
        249.6,
        250.4,
        251.2,
        252.0,
        252.8,
        253.6,
        254.4,
        255.2,
        256.0,
        256.8,
        257.6,
        258.4,
        259.2,
        260.0,
        260.8,
        261.6,
        262.4,
        263.2,
        264.0,
        264.8,
        265.6,
        266.4,
        267.2,
        268.0,
        268.8,
        269.6,
        270.4,
        271.2,
        272.0,
        272.8,
        273.6,
        274.4,
        275.2,
        276.0,
        276.8,
        277.6,
        278.4,
        279.2,
        280.0,
        280.8,
        281.6,
        282.4,
        283.2,
        284.0,
        284.8,
        285.6,
        286.4,
        287.2,
        288.0,
        288.8,
        289.6,
        290.4,
        291.2,
        292.0,
        292.8,
        293.6,
        294.4,
        295.2,
        296.0,
        296.8,
        297.6,
        298.4,
        299.2,
        300.0,
        300.8,
        301.6,
        302.4,
        303.2,
        304.0,
        304.8,
        305.6,
        306.4,
        307.2,
        308.0,
        308.8,
        309.6,
        310.4,
        311.2,
        312.0,
        312.8,
        313.6,
        314.4,
        315.2,
        316.0,
        316.8,
        317.6,
        318.4,
        319.2,
        320.0,
      ];

      if (kg <= 300) {
        return PRICES_ZONE_6[kg - 1];
      }
      return 0;
    },

    get_price_zone_5: function (kg) {
      const PRICES_ZONE_5 = [
        29.34,
        29.94,
        30.54,
        31.14,
        31.74,
        32.34,
        32.94,
        33.54,
        34.14,
        34.74,
        35.34,
        35.94,
        36.54,
        37.14,
        37.74,
        38.34,
        38.94,
        39.54,
        40.14,
        40.74,
        41.34,
        41.94,
        42.54,
        43.14,
        43.74,
        44.34,
        44.94,
        45.54,
        46.14,
        46.74,
        47.54,
        48.34,
        49.14,
        49.94,
        50.74,
        51.54,
        52.34,
        53.14,
        53.94,
        54.74,
        55.54,
        56.34,
        57.14,
        57.94,
        58.74,
        59.54,
        60.34,
        61.14,
        61.94,
        62.74,
        77.1,
        77.9,
        78.7,
        79.5,
        80.3,
        81.1,
        81.9,
        82.7,
        83.5,
        84.3,
        85.1,
        85.9,
        86.7,
        87.5,
        88.3,
        89.1,
        89.9,
        90.7,
        91.5,
        92.3,
        93.1,
        93.9,
        94.7,
        95.5,
        96.3,
        97.1,
        97.9,
        98.7,
        99.5,
        100.3,
        101.1,
        101.9,
        102.7,
        103.5,
        104.3,
        105.1,
        105.9,
        106.7,
        107.5,
        108.3,
        109.1,
        109.9,
        110.7,
        111.5,
        112.3,
        113.1,
        113.9,
        114.7,
        115.5,
        116.3,
        137.44,
        138.24,
        139.04,
        139.84,
        140.64,
        141.44,
        142.24,
        143.04,
        143.84,
        144.64,
        145.44,
        146.24,
        147.04,
        147.84,
        148.64,
        149.44,
        150.24,
        151.04,
        151.84,
        152.64,
        153.44,
        154.24,
        155.04,
        155.84,
        156.64,
        157.44,
        158.24,
        159.04,
        159.84,
        160.64,
        161.44,
        162.24,
        163.04,
        163.84,
        164.64,
        165.44,
        166.24,
        167.04,
        167.84,
        168.64,
        169.44,
        170.24,
        171.04,
        171.84,
        172.64,
        173.44,
        174.24,
        175.04,
        175.84,
        176.64,
        177.44,
        178.24,
        179.04,
        179.84,
        180.64,
        181.44,
        182.24,
        183.04,
        183.84,
        184.64,
        185.44,
        186.24,
        187.04,
        187.84,
        188.64,
        189.44,
        190.24,
        191.04,
        191.84,
        192.64,
        193.44,
        194.24,
        195.04,
        195.84,
        196.64,
        197.44,
        198.24,
        199.04,
        199.84,
        200.64,
        201.44,
        202.24,
        203.04,
        203.84,
        204.64,
        205.44,
        206.24,
        207.04,
        207.84,
        208.64,
        209.44,
        210.24,
        211.04,
        211.84,
        212.64,
        213.44,
        214.24,
        215.04,
        215.84,
        216.64,
        244.56,
        245.36,
        246.16,
        246.96,
        247.76,
        248.56,
        249.36,
        250.16,
        250.96,
        251.76,
        252.56,
        253.36,
        254.16,
        254.96,
        255.76,
        256.56,
        257.36,
        258.16,
        258.96,
        259.76,
        260.56,
        261.36,
        262.16,
        262.96,
        263.76,
        264.56,
        265.36,
        266.16,
        266.96,
        267.76,
        268.56,
        269.36,
        270.16,
        270.96,
        271.76,
        272.56,
        273.36,
        274.16,
        274.96,
        275.76,
        276.56,
        277.36,
        278.16,
        278.96,
        279.76,
        280.56,
        281.36,
        282.16,
        282.96,
        283.76,
        284.56,
        285.36,
        286.16,
        286.96,
        287.76,
        288.56,
        289.36,
        290.16,
        290.96,
        291.76,
        292.56,
        293.36,
        294.16,
        294.96,
        295.76,
        296.56,
        297.36,
        298.16,
        298.96,
        299.76,
        300.56,
        301.36,
        302.16,
        302.96,
        303.76,
        304.56,
        305.36,
        306.16,
        306.96,
        307.76,
        308.56,
        309.36,
        310.16,
        310.96,
        311.76,
        312.56,
        313.36,
        314.16,
        314.96,
        315.76,
        316.56,
        317.36,
        318.16,
        318.96,
        319.76,
        320.56,
        321.36,
        322.16,
        322.96,
        323.76,
      ];

      if (kg <= 300) {
        return PRICES_ZONE_5[kg - 1];
      }
      return 0;
    },

    get_price_zone_3: function (kg) {
      const PRICES_ZONE_3 = [
        36.38,
        36.98,
        37.58,
        38.18,
        38.78,
        39.38,
        39.98,
        40.58,
        41.18,
        41.78,
        42.38,
        42.98,
        43.58,
        44.18,
        44.78,
        45.38,
        45.98,
        46.58,
        47.18,
        47.78,
        48.38,
        48.98,
        49.58,
        50.18,
        50.78,
        51.38,
        51.98,
        52.58,
        53.18,
        53.78,
        54.58,
        55.38,
        56.18,
        56.98,
        57.78,
        58.58,
        59.38,
        60.18,
        60.98,
        61.78,
        62.58,
        63.38,
        64.18,
        64.98,
        65.78,
        66.58,
        67.38,
        68.18,
        68.98,
        69.78,
        84.14,
        84.94,
        85.74,
        86.54,
        87.34,
        88.14,
        88.94,
        89.74,
        90.54,
        91.34,
        92.14,
        92.94,
        93.74,
        94.54,
        95.34,
        96.14,
        96.94,
        97.74,
        98.54,
        99.34,
        100.14,
        100.94,
        101.74,
        102.54,
        103.34,
        104.14,
        104.94,
        105.74,
        106.54,
        107.34,
        108.14,
        108.94,
        109.74,
        110.54,
        111.34,
        112.14,
        112.94,
        113.74,
        114.54,
        115.34,
        116.14,
        116.94,
        117.74,
        118.54,
        119.34,
        120.14,
        120.94,
        121.74,
        122.54,
        123.34,
        144.48,
        145.28,
        146.08,
        146.88,
        147.68,
        148.48,
        149.28,
        150.08,
        150.88,
        151.68,
        152.48,
        153.28,
        154.08,
        154.88,
        155.68,
        156.48,
        157.28,
        158.08,
        158.88,
        159.68,
        160.48,
        161.28,
        162.08,
        162.88,
        163.68,
        164.48,
        165.28,
        166.08,
        166.88,
        167.68,
        168.48,
        169.28,
        170.08,
        170.88,
        171.68,
        172.48,
        173.28,
        174.08,
        174.88,
        175.68,
        176.48,
        177.28,
        178.08,
        178.88,
        179.68,
        180.48,
        181.28,
        182.08,
        182.88,
        183.68,
        184.48,
        185.28,
        186.08,
        186.88,
        187.68,
        188.48,
        189.28,
        190.08,
        190.88,
        191.68,
        192.48,
        193.28,
        194.08,
        194.88,
        195.68,
        196.48,
        197.28,
        198.08,
        198.88,
        199.68,
        200.48,
        201.28,
        202.08,
        202.88,
        203.68,
        204.48,
        205.28,
        206.08,
        206.88,
        207.68,
        208.48,
        209.28,
        210.08,
        210.88,
        211.68,
        212.48,
        213.28,
        214.08,
        214.88,
        215.68,
        216.48,
        217.28,
        218.08,
        218.88,
        219.68,
        220.48,
        221.28,
        222.08,
        222.88,
        223.68,
        251.6,
        252.4,
        253.2,
        254.0,
        254.8,
        255.6,
        256.4,
        257.2,
        258.0,
        258.8,
        259.6,
        260.4,
        261.2,
        262.0,
        262.8,
        263.6,
        264.4,
        265.2,
        266.0,
        266.8,
        267.6,
        268.4,
        269.2,
        270.0,
        270.8,
        271.6,
        272.4,
        273.2,
        274.0,
        274.8,
        275.6,
        276.4,
        277.2,
        278.0,
        278.8,
        279.6,
        280.4,
        281.2,
        282.0,
        282.8,
        283.6,
        284.4,
        285.2,
        286.0,
        286.8,
        287.6,
        288.4,
        289.2,
        290.0,
        290.8,
        291.6,
        292.4,
        293.2,
        294.0,
        294.8,
        295.6,
        296.4,
        297.2,
        298.0,
        298.8,
        299.6,
        300.4,
        301.2,
        302.0,
        302.8,
        303.6,
        304.4,
        305.2,
        306.0,
        306.8,
        307.6,
        308.4,
        309.2,
        310.0,
        310.8,
        311.6,
        312.4,
        313.2,
        314.0,
        314.8,
        315.6,
        316.4,
        317.2,
        318.0,
        318.8,
        319.6,
        320.4,
        321.2,
        322.0,
        322.8,
        323.6,
        324.4,
        325.2,
        326.0,
        326.8,
        327.6,
        328.4,
        329.2,
        330.0,
        330.8,
      ];

      if (kg <= 300) {
        return PRICES_ZONE_3[kg - 1];
      }
      return 0;
    },

    get_price_zone_2: function (kg) {
      const PRICES_ZONE_2 = [
        53.75,
        54.35,
        54.95,
        55.55,
        56.15,
        56.75,
        57.35,
        57.95,
        58.55,
        59.15,
        59.75,
        60.35,
        60.95,
        61.55,
        62.15,
        62.75,
        63.35,
        63.95,
        64.55,
        65.15,
        65.75,
        66.35,
        66.95,
        67.55,
        68.15,
        68.75,
        69.35,
        69.95,
        70.55,
        71.15,
        71.95,
        72.75,
        73.55,
        74.35,
        75.15,
        75.95,
        76.75,
        77.55,
        78.35,
        79.15,
        79.95,
        80.75,
        81.55,
        82.35,
        83.15,
        83.95,
        84.75,
        85.55,
        86.35,
        87.15,
        101.51,
        102.31,
        103.11,
        103.91,
        104.71,
        105.51,
        106.31,
        107.11,
        107.91,
        108.71,
        109.51,
        110.31,
        111.11,
        111.91,
        112.71,
        113.51,
        114.31,
        115.11,
        115.91,
        116.71,
        117.51,
        118.31,
        119.11,
        119.91,
        120.71,
        121.51,
        122.31,
        123.11,
        123.91,
        124.71,
        125.51,
        126.31,
        127.11,
        127.91,
        128.71,
        129.51,
        130.31,
        131.11,
        131.91,
        132.71,
        133.51,
        134.31,
        135.11,
        135.91,
        136.71,
        137.51,
        138.31,
        139.11,
        139.91,
        140.71,
        161.85,
        162.65,
        163.45,
        164.25,
        165.05,
        165.85,
        166.65,
        167.45,
        168.25,
        169.05,
        169.85,
        170.65,
        171.45,
        172.25,
        173.05,
        173.85,
        174.65,
        175.45,
        176.25,
        177.05,
        177.85,
        178.65,
        179.45,
        180.25,
        181.05,
        181.85,
        182.65,
        183.45,
        184.25,
        185.05,
        185.85,
        186.65,
        187.45,
        188.25,
        189.05,
        189.85,
        190.65,
        191.45,
        192.25,
        193.05,
        193.85,
        194.65,
        195.45,
        196.25,
        197.05,
        197.85,
        198.65,
        199.45,
        200.25,
        201.05,
        201.85,
        202.65,
        203.45,
        204.25,
        205.05,
        205.85,
        206.65,
        207.45,
        208.25,
        209.05,
        209.85,
        210.65,
        211.45,
        212.25,
        213.05,
        213.85,
        214.65,
        215.45,
        216.25,
        217.05,
        217.85,
        218.65,
        219.45,
        220.25,
        221.05,
        221.85,
        222.65,
        223.45,
        224.25,
        225.05,
        225.85,
        226.65,
        227.45,
        228.25,
        229.05,
        229.85,
        230.65,
        231.45,
        232.25,
        233.05,
        233.85,
        234.65,
        235.45,
        236.25,
        237.05,
        237.85,
        238.65,
        239.45,
        240.25,
        241.05,
        268.96,
        269.76,
        270.56,
        271.36,
        272.16,
        272.96,
        273.76,
        274.56,
        275.36,
        276.16,
        276.96,
        277.76,
        278.56,
        279.36,
        280.16,
        280.96,
        281.76,
        282.56,
        283.36,
        284.16,
        284.96,
        285.76,
        286.56,
        287.36,
        288.16,
        288.96,
        289.76,
        290.56,
        291.36,
        292.16,
        292.96,
        293.76,
        294.56,
        295.36,
        296.16,
        296.96,
        297.76,
        298.56,
        299.36,
        300.16,
        300.96,
        301.76,
        302.56,
        303.36,
        304.16,
        304.96,
        305.76,
        306.56,
        307.36,
        308.16,
        308.96,
        309.76,
        310.56,
        311.36,
        312.16,
        312.96,
        313.76,
        314.56,
        315.36,
        316.16,
        316.96,
        317.76,
        318.56,
        319.36,
        320.16,
        320.96,
        321.76,
        322.56,
        323.36,
        324.16,
        324.96,
        325.76,
        326.56,
        327.36,
        328.16,
        328.96,
        329.76,
        330.56,
        331.36,
        332.16,
        332.96,
        333.76,
        334.56,
        335.36,
        336.16,
        336.96,
        337.76,
        338.56,
        339.36,
        340.16,
        340.96,
        341.76,
        342.56,
        343.36,
        344.16,
        344.96,
        345.76,
        346.56,
        347.36,
        348.16,
      ];

      if (kg <= 300) {
        return PRICES_ZONE_2[kg - 1];
      }
      return 0;
    },

    get_price_zone_1: function (kg) {
      const PRICES_ZONE_1 = [
        91.3,
        91.9,
        92.5,
        93.1,
        93.7,
        94.3,
        94.9,
        95.5,
        96.1,
        96.7,
        97.3,
        97.9,
        98.5,
        99.1,
        99.7,
        100.3,
        100.9,
        101.5,
        102.1,
        102.7,
        103.3,
        103.9,
        104.5,
        105.1,
        105.7,
        106.3,
        106.9,
        107.5,
        108.1,
        108.7,
        109.5,
        110.3,
        111.1,
        111.9,
        112.7,
        113.5,
        114.3,
        115.1,
        115.9,
        116.7,
        117.5,
        118.3,
        119.1,
        119.9,
        120.7,
        121.5,
        122.3,
        123.1,
        123.9,
        124.7,
        139.06,
        139.86,
        140.66,
        141.46,
        142.26,
        143.06,
        143.86,
        144.66,
        145.46,
        146.26,
        147.06,
        147.86,
        148.66,
        149.46,
        150.26,
        151.06,
        151.86,
        152.66,
        153.46,
        154.26,
        155.06,
        155.86,
        156.66,
        157.46,
        158.26,
        159.06,
        159.86,
        160.66,
        161.46,
        162.26,
        163.06,
        163.86,
        164.66,
        165.46,
        166.26,
        167.06,
        167.86,
        168.66,
        169.46,
        170.26,
        171.06,
        171.86,
        172.66,
        173.46,
        174.26,
        175.06,
        175.86,
        176.66,
        177.46,
        178.26,
        199.39,
        200.19,
        200.99,
        201.79,
        202.59,
        203.39,
        204.19,
        204.99,
        205.79,
        206.59,
        207.39,
        208.19,
        208.99,
        209.79,
        210.59,
        211.39,
        212.19,
        212.99,
        213.79,
        214.59,
        215.39,
        216.19,
        216.99,
        217.79,
        218.59,
        219.39,
        220.19,
        220.99,
        221.79,
        222.59,
        223.39,
        224.19,
        224.99,
        225.79,
        226.59,
        227.39,
        228.19,
        228.99,
        229.79,
        230.59,
        231.39,
        232.19,
        232.99,
        233.79,
        234.59,
        235.39,
        236.19,
        236.99,
        237.79,
        238.59,
        239.39,
        240.19,
        240.99,
        241.79,
        242.59,
        243.39,
        244.19,
        244.99,
        245.79,
        246.59,
        247.39,
        248.19,
        248.99,
        249.79,
        250.59,
        251.39,
        252.19,
        252.99,
        253.79,
        254.59,
        255.39,
        256.19,
        256.99,
        257.79,
        258.59,
        259.39,
        260.19,
        260.99,
        261.79,
        262.59,
        263.39,
        264.19,
        264.99,
        265.79,
        266.59,
        267.39,
        268.19,
        268.99,
        269.79,
        270.59,
        271.39,
        272.19,
        272.99,
        273.79,
        274.59,
        275.39,
        276.19,
        276.99,
        277.79,
        278.59,
        306.51,
        307.31,
        308.11,
        308.91,
        309.71,
        310.51,
        311.31,
        312.11,
        312.91,
        313.71,
        314.51,
        315.31,
        316.11,
        316.91,
        317.71,
        318.51,
        319.31,
        320.11,
        320.91,
        321.71,
        322.51,
        323.31,
        324.11,
        324.91,
        325.71,
        326.51,
        327.31,
        328.11,
        328.91,
        329.71,
        330.51,
        331.31,
        332.11,
        332.91,
        333.71,
        334.51,
        335.31,
        336.11,
        336.91,
        337.71,
        338.51,
        339.31,
        340.11,
        340.91,
        341.71,
        342.51,
        343.31,
        344.11,
        344.91,
        345.71,
        346.51,
        347.31,
        348.11,
        348.91,
        349.71,
        350.51,
        351.31,
        352.11,
        352.91,
        353.71,
        354.51,
        355.31,
        356.11,
        356.91,
        357.71,
        358.51,
        359.31,
        360.11,
        360.91,
        361.71,
        362.51,
        363.31,
        364.11,
        364.91,
        365.71,
        366.51,
        367.31,
        368.11,
        368.91,
        369.71,
        370.51,
        371.31,
        372.11,
        372.91,
        373.71,
        374.51,
        375.31,
        376.11,
        376.91,
        377.71,
        378.51,
        379.31,
        380.11,
        380.91,
        381.71,
        382.51,
        383.31,
        384.11,
        384.91,
        385.71,
      ];

      if (kg <= 300) {
        return PRICES_ZONE_1[kg - 1];
      }
      return 0;
    },
  },
};
</script>

<style>
#component_inquiry_calculator .tbl {
  display: inline-table;
  padding: 5px;
  width: 100%;
}

#component_inquiry_calculator .tblrow {
  display: table-row;
  width: 100%;
}

#component_inquiry_calculator .tblcell {
  display: table-cell;
  text-align: right;
  padding-left: 4px;
  padding-top: 5px;
}

#component_inquiry_calculator .tblcell:first-of-type {
  text-align: left;
  padding-left: 0;
}

#component_inquiry_calculator .col-sm-7 {
  font-size: 0.9em;
}

#component_inquiry_calculator #inq_serviceheadline small {
  font-size: 0.6em;
}

#component_inquiry_calculator #inqNeworder {
  border: 1px solid black;
  padding: 1px 6px;
}
/* Mass and Weight part. */
#component_inquiry_calculator #inqMassAndWeight .form-inline {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
  justify-content: space-between;
}
#component_inquiry_calculator .form-inline input.inqSizeInput,
#component_inquiry_calculator .form-inline input.inqWeightInput {
  width: 88%;
}
/* Accordion part. */
#component_inquiry_calculator #inqPackages {
  width: 100%;
}
#component_inquiry_calculator b-h3 {
  background: #f2f2f2;
  border: 1px solid black;
  border-radius: 3px;
  width: 100%;
  display: block;
  padding: 5px;
  cursor: pointer;
}
#component_inquiry_calculator .collapseElem {
  background: #f2f2f2;
}
#component_inquiry_calculator b-ul {
  display: block;
  padding: 20px;
  border: 1px solid black;
  border-radius: 3px;
}

#component_inquiry_calculator .deleteAccItem {
  background: none;
  color: black;
  border: none;
  float: right;
  margin: 0;
  padding: 0;
  padding-right: 5px;
}

#component_inquiry_calculator #inqSendPackages,
#component_inquiry_calculator #inqConvertToOrder {
  padding: 0;
}
#component_inquiry_calculator #inqSendPackages button,
#component_inquiry_calculator #inqConvertToOrder button {
  float: left;
  display: flex;
  flex-flow: row nowrap;
  justify-content: space-between;
  align-items: center;
}

#component_inquiry_calculator #inqSendPackages .div_small_border,
#component_inquiry_calculator #inqConvertToOrder .div_small_border {
  border-left: 2px solid white;
  height: 45px;
  margin-left: 5px;
  margin-right: 5px;
}

#component_inquiry_calculator #inqSendPackages h4,
#component_inquiry_calculator #inqConvertToOrder h4 {
  margin: 0;
}
#component_inquiry_calculator .row_input {
  margin-bottom: 0%;
}

#component_inquiry_calculator .row_input > div {
  padding: 0;
}

#component_inquiry_calculator .label_input_size {
  width: 100%;
}
</style>