<template>
  <div class="container-fluid" id="component_inquiry_calculator">
    <form v-on:submit="add_package($event)" id="form_inq_calculator" class="m-form">
      <div class="row">
        <h5>Sendungsdetails</h5>
      </div>
      <div class="row">
        <h5>Wo soll das Paket abgeholt werden?</h5>
      </div>
      <div class="row">
        <p>Nur nationale / in Deutschland gültige PLZ eingeben.</p>
      </div>
      <div class="row">
        <input
          type="text"
          minlength="3"
          maxlength="10"
          size="5"
          pattern="[0-9]{3,10}"
          class="form-control"
          placeholder="Abhol-PLZ"
          required
          v-model="postal_code_start"
        />
        <br />
        <br />
      </div>
      <div class="row">
        <h5>Wohin soll das Paket geliefert werden?</h5>
      </div>
      <div class="row">
        <p>Nur nationale / in Deutschland gültige PLZ eingeben.</p>
      </div>
      <div class="row">
        <input
          type="text"
          minlength="3"
          maxlength="10"
          size="5"
          pattern="[0-9]{3,10}"
          class="form-control"
          placeholder="Ziel-PLZ"
          required
          v-model="postal_code_end"
        />
        <br />
        <br />
      </div>
      <div class="row">
        <h4>Wann soll zugestellt werden?</h4>
      </div>
      <div class="row">
        <div class="col-lg-5 smaller">Zustellfenster:</div>
        <div class="col-lg-7 form-group smaller">
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="2"
              required
              name="input_timew_window"
              v-model="time_window_index"
            />
            <label class="form-check-label">07:30 – 08:00 Uhr</label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="3"
              required
              name="input_timew_window"
              v-model="time_window_index"
            />
            <label class="form-check-label">08:00 – 09:00 Uhr</label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="5"
              required
              name="input_timew_window"
              v-model="time_window_index"
            />
            <label class="form-check-label">08:00 – 10:00 Uhr</label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="6"
              required
              name="input_timew_window"
              v-model="time_window_index"
            />
            <label class="form-check-label">08:00 – 12:00 Uhr</label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="7"
              required
              name="input_timew_window"
              v-model="time_window_index"
            />
            <label class="form-check-label">09:00 – 17:00 Uhr</label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="-1"
              required
              name="input_timew_window"
              v-model="time_window_index"
            />
            <label class="form-check-label">Fixtermin</label>
          </div>
        </div>
        <div class="col-lg-5 smaller">Zustellung am:</div>
        <div class="col-lg-7 form-group smaller">
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="Mo. – Fr. (am folgenden Werktag)"
              required
              name="input_delivery_day"
              v-model="delivery_day"
            />
            <label class="form-check-label">Mo. – Fr. (am folgenen Werktag)</label>
          </div>

          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="Samstag"
              required
              name="input_delivery_day"
              v-model="delivery_day"
            />
            <label class="form-check-label">Samstag</label>
          </div>

          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              value="Sonn-/Feiertag"
              required
              name="input_delivery_day"
              v-model="delivery_day"
            />
            <label class="form-check-label">Sonn-/Feiertag</label>
          </div>
        </div>
      </div>
      <div class="row" id="div_inq_mass_weight">
        <h4>Maße und Gewicht der Sendung:</h4>
        <br />
      </div>
      <div class="row">
        <h6>
          <i
            ><b
              >Bitte beachten Sie: - Gutmasß <span style="color: red">max</span>. 520 cm
              // Gewicht <span style="color: red">max</span>. 50 kg</b
            ></i
          >
        </h6>
      </div>
      <div class="row form-group form-inline row_input">
        <div class="col-lg-3">
          <span class="label_input_size" style="color: #29ca8e"><i>Länge</i></span>
          <br />
          <input
            type="number"
            min="1"
            max="390"
            class="form-control input_inquiry_size_data"
            placeholder="Länge"
            required
            v-on:input="calculate_units()"
            v-model="length"
          />
          <span><b>x</b></span>
        </div>
        <div class="col-lg-3">
          <span class="label_input_size" style="color: #29ca8e"><i>Breite</i></span>
          <br />
          <input
            type="number"
            min="1"
            maxlength="999999"
            class="form-control input_inquiry_size_data"
            placeholder="Breite"
            required
            v-on:input="calculate_units()"
            v-model="width"
          />
          <span><b>x</b></span>
        </div>
        <div class="col-lg-3">
          <span class="label_input_size" style="color: #29ca8e"><i>Höhe</i></span>
          <br />
          <input
            type="number"
            min="1"
            max="999999"
            class="form-control input_inquiry_size_data"
            placeholder="Höhe"
            required
            v-on:input="calculate_units()"
            v-model="height"
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
            class="form-control input_inquiry_data"
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
            class="form-control input_inquiry_data"
            required
            id="input_weight"
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
            class="form-control input_inquiry_data"
            value="0"
            disabled
            v-model="volume_weight"
          />
        </div>
        <div class="col-lg-2">
          <span><b>kg</b></span>
        </div>
      </div>
      <div class="row form-group form-inline row_input"><br /></div>
      <div class="row form-group" id="div_inq_service_selection_wrapper">
        <h4 id="h4_inq_serviceheadline">
          Zusätzliche Serviceleistungen
          <br />
          <small>
            [Nachname, Empfangsbestätigung, ...]
            <br />
            <a v-if="!showservice_selection" v-on:click="showservice_selection = true">
              <button id="button_expand_services">Bitte klicken</button>
            </a>
            <a v-else v-on:click="showservice_selection = false">Ausklappen</a>
          </small>
        </h4>
        <div v-if="showservice_selection">
          <div class="tbl">
            <div class="tblrow">
              <div class="tblcell">Fixe Zustellung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">50,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="0" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Bereichszustellung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">5,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="1" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Empfangsbestätigung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">4,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="2" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Empfangsbestätigung (telefonisch)</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">2,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="3" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Höherhaftung bis 2.500&nbsp;€ pro Sendung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">3,50&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="4" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Indet-Zustellung mit Vertragsservice</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">7,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="5" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Insel-Zustellung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">30,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="6" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Lagerung nicht zugestellter Sendung je Tag</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">1,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="7" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Messeservice</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">10,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="8" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Nachnahme</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">8,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="9" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Persönliche Zustellung mit Dokumentation</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">5,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="10" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Samstagszustellung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">2,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="11" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">SmartPic</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">46,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="12" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">SmartPic+</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">50,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="13" v-model="service_values" />
              </div>
            </div>
            <div class="tblrow">
              <div class="tblcell">Sonn- und Feiertagszustellung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">40,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="14" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">Verpackungsrückführung</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">2,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="15" v-model="service_values" />
              </div>
            </div>

            <div class="tblrow">
              <div class="tblcell">X-Change</div>
              <div class="tblcell">zzgl.</div>
              <div class="tblcell">2,00&nbsp;€</div>
              <div class="tblcell">
                <input type="checkbox" value="16" v-model="service_values" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row form-group">
        <button type="submit" id="button_inq_new_package">
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
      <div v-if="packages.length" id="div_inq_packages" class="row">
        <div class="row">
          <br />
        </div>
        <div class="row">
          <h5>Pakete</h5>
        </div>
        <div class="row">
          <div v-bind:key="package_.id" v-for="package_ in packages" class="col-lg-12">
            <b-h3 v-on:click="collapse_accordion_item(package_.elemId)">
              <span>Paket {{ package_.id + 1 }}</span>
              <b-button
                v-on:click="delete_accordion_item(package_.id)"
                type="button"
                class="button_delete_acc_item"
                >X</b-button
              >
            </b-h3>
            <b-collapse
              v-bind:id="package_.elemId"
              accordion="my-accordion"
              class="collapse_elem"
            >
              <b-ul>
                <li>Sendungsnummer: {{ package_.id + 1 }}</li>
                <li>PLZ Start: {{ package_.postal_code_start }}</li>
                <li>PLZ Ziel: {{ package_.postal_code_end }}</li>
                <li>Zeitfenster: {{ package_.time_window }}</li>
                <li>Zustelltag: {{ package_.delivery_day }}</li>
                <li>Größe-X: {{ package_.length }}</li>
                <li>Größe-Y: {{ package_.width }}</li>
                <li>Größe-Z: {{ package_.height }}</li>
                <li>Volumengewicht: {{ package_.volume_weight }}</li>
                <li>Gewicht: {{ package_.weight }}</li>
                <li>Gurtmaß: {{ package_.girth }}</li>
                <li>Preis: {{ package_.price }}</li>
                <li v-if="package_.services.length">
                  <span>Dienstleistungen:</span>
                  <br />
                  <b-ul v-if="package_.services.length">
                    <li v-bind:key="service.id" v-for="service in package_.services">
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
          :show_delete_package_modal="show_delete_package_modal"
          :package_id="package_id"
          :modalHeader="delete_package_modal_header"
          :modalBody="delete_package_modal_body"
          v-on:cancel_item_deletion="cancel_item_deletion()"
          v-on:confirm_item_deletion="confirm_item_deletion($event)"
        ></delete_package_modal>
        <br />
        <br />
      </div>
      <div class="row form-group form-inline row_input"><br /></div>
      <div class="row form-group">
        <div id="div_inq_send_packages">
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
            <h4>Anfrage anlegen</h4>
          </b-button>
        </div>

        <div class="ml-auto" id="div_inq_convert_to_order">
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
    <snackbar ref="snackbar" baseSize="100px" position="bottom-right"></snackbar>
  </div>
</template>

<script>
import delete_package_modal from "./delete_package_modal.vue";
import Snackbar from "vuejs-snackbar";
import {
  get_price_zone_1,
  get_price_zone_2,
  get_price_zone_3,
  get_price_zone_5,
  get_price_zone_6,
  get_price_zone_7,
} from "../general/PRICES";

export default {
  name: "inquiry_calculator",
  props: ["client_data", "from_address", "to_address"],
  data: function () {
    return {
      postal_code_start: "",
      postal_code_end: "",
      time_window_index: "",
      time_window: "",
      delivery_day: "",
      length: 0,
      width: 0,
      height: 0,
      volume_weight: 0,
      girth: 0,
      weight: 0,
      price: 0,
      price_string: "",
      tax_string: "",
      service_values: [],
      services: [],
      showservice_selection: false,
      show_delete_package_modal: false,
      package_id: -1,
      delete_package_modal_header: "Paket löschen",
      delete_package_modal_body:
        "Das Löschen vom Paket ist unwiderruflich. Sind Sie sicher ?",
      packageImg: {
        src: "img/icon_add.png",
        alt: "Sendung kalkulieren",
      },
      checkmarkImg: {
        src: "img/checkmark.png",
        alt: "Bestätigen",
      },
      default_pickup_address: false,
      default_delivery_address: false,
      time_windows: [
        { value: 2, title: "07:30 – 08:00 Uhr" },
        { value: 3, title: "08:00 – 09:00 Uhr" },
        { value: 5, title: "08:00 – 10:00 Uhr" },
        { value: 6, title: "08:00 – 12:00 Uhr" },
        { value: 7, title: "09:00 – 17:00 Uhr" },
        { value: -1, title: "Fixtermin" },
      ],
      service_selection: [
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
  },
  updated: function () {
    // Check if we're using the default pickup address.
    if (
      !this.from_address.same_address.length &&
      (!this.from_address.company_name ||
        !this.from_address.salutation ||
        !this.from_address.first_name ||
        !this.from_address.last_name ||
        !this.from_address.phone ||
        !this.from_address.email ||
        !this.from_address.street ||
        !this.from_address.house_number ||
        !this.from_address.postal_code ||
        !this.from_address.place ||
        !this.from_address.country)
    ) {
      this.default_pickup_address = false;
    } else {
      this.default_pickup_address = true;
    }

    // Check if we're using the default delivery address.
    if (
      !this.to_address.same_address.length &&
      (!this.to_address.company_name ||
        !this.to_address.salutation ||
        !this.to_address.first_name ||
        !this.to_address.last_name ||
        !this.to_address.phone ||
        !this.to_address.email ||
        !this.to_address.street ||
        !this.to_address.house_number ||
        !this.to_address.postal_code ||
        !this.to_address.place ||
        !this.to_address.country)
    ) {
      this.default_delivery_address = false;
    } else {
      this.default_delivery_address = true;
    }
  },
  methods: {
    collapse_accordion_item: function (elemId) {
      this.$root.$emit("bv::toggle::collapse", elemId);
    },
    convert_to_order: function () {
      fetch(mainUrl + "admin_content/ajax/create_order.php", {
        method: "POST",
        dataType: "json",
        mode: "cors",
        credentials: "same-origin",
        headers: {
          "Access-Control-Allow-Origin": "*",
        },
        body: JSON.stringify({
          time_window: this.time_window,
          delivery_day: this.delivery_day,
          client_id: this.client_data.id,
          from_address: this.from_address,
          to_address: this.to_address,
          packages: this.packages,
        }),
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success) {
            this.$refs.snackbar.info("Auftrag erflogreich erstellt.");
          } else {
            this.$refs.snackbar.error(res.msg);
          }
          return new Promise((resolve, reject) => setTimeout(resolve, 1000));
        })
        .then((res) => this.$emit("close_inquiry_modal2"))
        .catch((err) => this.$refs.snackbar.error(err));
    },
    send_packages: function () {
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

      fetch(mainUrl + "admin_content/ajax/create_inquiry.php", {
        method: "POST",
        dataType: "json",
        mode: "cors",
        credentials: "same-origin",
        headers: {
          "Access-Control-Allow-Origin": "*",
        },
        body: JSON.stringify({
          postal_code_start: this.postal_code_start,
          postal_code_end: this.postal_code_end,
          time_window: this.time_window,
          delivery_day: this.delivery_day,
          client_id: this.client_data.id,
          from_address: this.from_address,
          to_address: this.to_address,
          packages: this.packages,
        }),
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success) {
            // Update the store by adding the newly created inquiry.
            this.$store.commit("add_inquiry", res.inquiry);

            this.$refs.snackbar.info("Anfrage erflogreich erstellt.");
          } else {
            this.$refs.snackbar.error(res.msg);
          }
          return new Promise((resolve, reject) => setTimeout(resolve, 1000));
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
      // Fix the time_window.
      this.time_window = this.time_windows.find(
        (delTime) => delTime.value === parseInt(this.time_window_index)
      ).title;

      // Set the services.
      this.services = this.service_values.map((service) => ({
        id: parseInt(service),
        title: this.service_selection.find((s) => s.id === parseInt(service)).title,
      }));

      // Calculate the price.
      this.calculate_price();

      this.packages.push({
        id: pId,
        elemId: "collapse-" + pId,
        postal_code_start: this.postal_code_start,
        postal_code_end: this.postal_code_end,
        time_window: this.time_window,
        delivery_day: this.delivery_day,
        length: this.length,
        width: this.width,
        height: this.height,
        volume_weight: this.volume_weight,
        weight: this.weight,
        girth: this.girth,
        price: this.price,
        services: this.services,
      });

      // Collapse the sevices inputs.
      this.showservice_selection = false;

      // Reset the package form.
      this.length = 0;
      this.width = 0;
      this.height = 0;
      this.girth = 0;
      this.weight = 0;
      this.volume_weight = 0;
      this.service_values = [];
    },
    delete_accordion_item: function (package_id) {
      this.show_delete_package_modal = true;
      this.package_id = package_id;
    },
    cancel_item_deletion: function () {
      this.show_delete_package_modal = false;
    },
    confirm_item_deletion: function (package_id) {
      this.show_delete_package_modal = false;
      this.packages = this.packages.filter((package_) => package_.id !== package_id);
    },
    calculate_units: function () {
      let faulty = false;

      this.length = parseInt(this.length);
      this.width = parseInt(this.width);
      this.height = parseInt(this.height);

      if (!this.length || !this.width || !this.height) {
        faulty = true;
      }

      if (this.length < 0 || this.width < 0 || this.height < 0) {
        faulty = true;
      }

      // Perform a check for the length.
      if (this.length > 390) {
        this.length = 390;
      }

      // Perform a check for the weight.
      if (this.weight > 50) {
        this.weight = 50;
      }

      // Calculate the volume weight.
      this.volume_weight = Math.ceil((this.length * this.width * this.height) / 6000, -1);

      // Check if the calculated volume weight is valid.
      if (isNaN(this.volume_weight)) {
        faulty = true;
      }

      // Calculate the girth.
      this.girth = this.length + this.width * 2 + this.height * 2;

      if (faulty) {
        this.volume_weight = 0;
        return;
      }
    },
    calculate_price: function () {
      let zone = parseInt(this.time_window_index);

      let kg = parseInt(this.weight);
      if (parseInt(this.weight) < parseInt(this.volume_weight)) {
        kg = parseInt(this.volume_weight);
      }

      let price = 0;

      console.log("Zone: " + zone);
      console.log("Kg: " + kg);

      if (zone === -1) {
        price = get_price_zone_1(kg);
      } else if (zone === 2) {
        price = get_price_zone_2(kg);
      } else if (zone === 3) {
        price = get_price_zone_3(kg);
      } else if (zone === 5) {
        price = get_price_zone_5(kg);
      } else if (zone === 6) {
        price = get_price_zone_6(kg);
      } else if (zone === 7) {
        price = get_price_zone_7(kg);
      }

      if (this.delivery_day === "Samstag") {
        price += 2;
      } else if (this.delivery_day === "Sonn-/Feiertag") {
        price += 40;
      }

      if (this.service_values.includes("0")) price = price + 50;
      if (this.service_values.includes("1")) price = price + 5;
      if (this.service_values.includes("2")) price = price + 4;
      if (this.service_values.includes("3")) price = price + 2;
      if (this.service_values.includes("4")) price = price + 3.5;
      if (this.service_values.includes("5")) price = price + 7;
      if (this.service_values.includes("6")) price = price + 30;
      if (this.service_values.includes("7")) price = price + 1;
      if (this.service_values.includes("8")) price = price + 10;
      if (this.service_values.includes("9")) price = price + 8;
      if (this.service_values.includes("10")) price = price + 5;
      if (this.service_values.includes("11")) price = price + 46;
      if (this.service_values.includes("12")) price = price + 50;
      if (this.service_values.includes("13")) price = price + 2;
      if (this.service_values.includes("14")) price = price + 2;

      this.price_string = "€ " + price.toFixed(2).replace(".", ",");

      this.price = price.toFixed(2);
    },
  },
};
</script>

<style>
#component_inquiry_calculator input[type="radio"] {
  cursor: pointer;
}

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

#component_inquiry_calculator .col-lg-7 {
  font-size: 0.9em;
}

#component_inquiry_calculator #h4_inq_serviceheadline small {
  font-size: 0.6em;
}

/* Mass and Weight part. */
#component_inquiry_calculator #div_inq_mass_weight .form-inline {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
  justify-content: space-between;
}
#component_inquiry_calculator .form-inline input.input_inquiry_size_data,
#component_inquiry_calculator .form-inline input.input_inquiry_data {
  width: 88%;
}

#component_inquiry_calculator #div_inq_service_selection_wrapper {
  display: flex;
  flex-flow: column nowrap;
}

#component_inquiry_calculator #button_expand_services {
  background: #d0009f;
  color: #fafe00;
  padding: 5px;
  border: none;
  border-radius: 3px;
}

/* Accordion part. */
#component_inquiry_calculator #div_inq_packages {
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
#component_inquiry_calculator .collapse_elem {
  background: #f2f2f2;
}
#component_inquiry_calculator b-ul {
  display: block;
  padding: 20px;
  border: 1px solid black;
  border-radius: 3px;
}

#component_inquiry_calculator .button_delete_acc_item {
  background: none;
  color: black;
  border: none;
  float: right;
  margin: 0;
  padding: 0;
  padding-right: 5px;
}

#component_inquiry_calculator #div_inq_send_packages,
#component_inquiry_calculator #div_inq_convert_to_order {
  padding: 0;
}
#component_inquiry_calculator #div_inq_send_packages button,
#component_inquiry_calculator #div_inq_convert_to_order button {
  float: left;
  display: flex;
  flex-flow: row nowrap;
  justify-content: space-between;
  align-items: center;
}

#component_inquiry_calculator #div_inq_send_packages .div_small_border,
#component_inquiry_calculator #div_inq_convert_to_order .div_small_border {
  border-left: 2px solid white;
  height: 45px;
  margin-left: 5px;
  margin-right: 5px;
}

#component_inquiry_calculator #div_inq_send_packages h4,
#component_inquiry_calculator #div_inq_convert_to_order h4 {
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
