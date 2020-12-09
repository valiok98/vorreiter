<template>
  <div id="component_inquiry_detail_modal">
    <modal v-if="showInquiryDetailModal">
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
                            <span
                              v-text="inquiryData.clientData.firmenname"
                            ></span>
                            <br />
                            <span>
                              <b>E-Mail Adresse</b>
                            </span>
                            <br />
                            <span v-text="inquiryData.clientData.email"></span>
                            <br />
                            <span>
                              <b>Ort</b>
                            </span>
                            <br />
                            <span v-text="inquiryData.clientData.ort"></span>
                            <br />
                            <span>
                              <b>PLZ</b>
                            </span>
                            <br />
                            <span v-text="inquiryData.clientData.plz"></span>
                            <br />
                            <span>
                              <b>Zentrale Telefonnummer</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiryData.clientData.telefon_zentrale"
                            ></span>
                            <br />
                            <span>
                              <b>Straße</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiryData.clientData.strasse"
                            ></span>
                          </div>
                          <div class="col-sm-6">
                            <h5></h5>
                            <br />
                            <span>
                              <b>Kundennummer</b>
                            </span>
                            <br />
                            <span v-text="inquiryData.clientData.id"></span>
                            <br />
                            <span>
                              <b>Anrede</b>
                            </span>
                            <br />
                            <span v-text="inquiryData.clientData.anrede"></span>
                            <br />
                            <span>
                              <b>Telefon</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiryData.clientData.telefon"
                            ></span>
                            <br />
                            <span>
                              <b>Hausnummer</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiryData.clientData.hausnummer"
                            ></span>
                            <br />
                            <span>
                              <b>Land</b>
                            </span>
                            <br />
                            <span v-text="inquiryData.clientData.land"></span>
                            <br />
                            <span>
                              <b>Freitext</b>
                            </span>
                            <br />
                            <span
                              v-text="inquiryData.clientData.freitext"
                            ></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 container-fluid">
                        <!-- here comes the data for the calculator -->
                        <div class="row" id="inqInformation">
                          <div>
                            <h5></h5>
                            <br />
                            <span>
                              <b>Abhol-PLZ</b>
                            </span>
                            <br />
                            <span v-text="inquiryData.plz_start"></span>
                            <br />
                            <span>
                              <b>Ziel-PLZ</b>
                            </span>
                            <br />
                            <span v-text="inquiryData.plz_ziel"></span>
                            <br />
                            <span>
                              <b>Zustellfenster</b>
                            </span>
                            <br />
                            <span v-text="inquiryData.zeit_fenster"></span>
                            <br />
                            <span>
                              <b>Zustellung am</b>
                            </span>
                            <br />
                            <span v-text="inquiryData.zustelltag"></span>
                            <br />
                            <div v-if="inquiryData.packages.length">
                              <div class="row">
                                <h5>Packages</h5>
                              </div>
                              <div class="row">
                                <div
                                  v-bind:key="package_.id"
                                  v-for="package_ in inquiryData.packages"
                                  class="col-sm-12"
                                  id="inqPackages"
                                >
                                  <b-h3
                                    v-on:click="
                                      collapse_accordion_item(package_.elemId)
                                    "
                                  >
                                    <span>Package {{ package_.id + 1 }}</span>
                                  </b-h3>
                                  <b-collapse
                                    v-bind:id="package_.elemId"
                                    accordion="my-accordion"
                                    class="collapseElem"
                                  >
                                    <b-ul>
                                      <li>
                                        Sendungsnummer: {{ package_.id + 1 }}
                                      </li>
                                      <li>Größe-X: {{ package_.laenge }}</li>
                                      <li>Größe-Y: {{ package_.breite }}</li>
                                      <li>Größe-Z: {{ package_.hoehe }}</li>
                                      <li>
                                        Volumengewicht:
                                        {{ package_.volumengewicht }}
                                      </li>
                                      <li>Gewicht: {{ package_.gewicht }}</li>
                                      <li>Gurtmaß: {{ package_.gurtmass }}</li>
                                      <li>Preis: {{ package_.preis }}</li>
                                      <li
                                        v-if="
                                          JSON.parse(
                                            package_.service_leistungen
                                          ).length
                                        "
                                      >
                                        <span>Dienstleistungen:</span>
                                        <br />
                                        <b-ul
                                          v-if="
                                            JSON.parse(
                                              package_.service_leistungen
                                            ).length
                                          "
                                        >
                                          <li
                                            v-bind:key="service.id"
                                            v-for="service in JSON.parse(
                                              package_.service_leistungen
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
  name: "inquiry_detail_modal",
  props: ["showInquiryDetailModal", "inquiryData"],
  data: function () {
    return {
      modalHeader: "Anfrage im Detail",
      closeImg: {
        src: "../images/modal/close_window.gif",
        alt: "Close modal",
      },
    };
  },
  methods: {
    collapse_accordion_item: function (elemId) {
      this.$root.$emit("bv::toggle::collapse", elemId);
    },
    close: function () {
      this.showInquiryDetailModal = false;
      this.$emit("close_inquiry_detail_modal");
    },
  },
};
</script>

<style>
#component_inquiry_detail_modal {
  text-align: left;
}
#component_inquiry_detail_modal .modal-container {
  overflow-y: auto;
  width: 75%;
  height: 90%;
}

#component_inquiry_detail_modal #inqInformation > div,
#component_inquiry_detail_modal #inqPackages {
  width: 100%;
}
#component_inquiry_detail_modal b-h3 {
  background: #f2f2f2;
  border: 1px solid black;
  border-radius: 3px;
  width: 100%;
  display: block;
  padding: 5px;
  cursor: pointer;
}
#component_inquiry_detail_modal .collapseElem {
  background: #f2f2f2;
}
#component_inquiry_detail_modal b-ul {
  display: block;
  padding: 20px;
  border: 1px solid black;
  border-radius: 3px;
}

#component_inquiry_detail_modal .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}
</style>