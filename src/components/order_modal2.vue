<template>
  <div>
    <modal v-if="showOrderModal2">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>Auftrag erstellen</h5>
              </div>

              <div class="modal-body">
                <div id="dialog_auftrag-erstellen-2" title="Auftrag erstellen">
                  <div id="div_auftrag-erstellen-content" class="container-fluid">
                    <div class="row">
                      <div class="col-sm-6 container-fluid">
                        <div class="row">
                          <div class="col-sm-6">
                            <h5>Auftraggeber</h5>
                            <span>
                              <b>Firmenname</b>
                            </span>
                            <br />
                            <span v-text="clientData.companyName"></span>
                            <br />
                            <span>
                              <b>Ansprechpartner</b>
                            </span>
                            <br />
                            <span v-text="clientData.contactPerson"></span>
                          </div>
                          <div class="col-sm-6">
                            <br />
                            <span>
                              <b>Kundennummer</b>
                            </span>
                            <br />
                            <span v-text="clientData.clientId"></span>
                            <br />
                            <span>
                              <b>Telefon</b>
                            </span>
                            <br />
                            <span v-text="clientData.phone"></span>
                            <br />
                            <span>
                              <b>E-Mail-Adresse</b>
                            </span>
                            <br />
                            <span v-text="clientData.email"></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <img
                          id="img_auftrag-anlegen"
                          src="../images/auftrag/auftrag_anlegen.png"
                          alt
                        />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <h5>
                          <b>Abholadresse</b>
                        </h5>
                        <div class="container-fluid">
                          <div class="row">
                            <div class="col-sm-6 form-group">
                              <label for="auf_firmenname">Firmenname</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="auf_firmenname"
                                name="auf_firmenname"
                                placeholder="Firmenname ..."
                              />
                            </div>
                            <div class="col-sm-6"></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-8 container-fluid">
                              <div class="row">
                                <h6>Ansprechpartner</h6>
                                <div class="col-sm-6 form-group">
                                  <label for="auf_anrede">Anrede</label>
                                  <input
                                    required
                                    type="text"
                                    class="form-control"
                                    id="auf_anrede"
                                    name="auf_anrede"
                                  />
                                </div>
                                <div class="col-sm-6 form-group">
                                  <label for="auf_titel">Titel</label>
                                  <input
                                    required
                                    type="text"
                                    class="form-control"
                                    id="auf_titel"
                                    name="auf_titel"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4"></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 form-group">
                              <label for="auf_vorname">Vorname</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="auf_vorname"
                                name="auf_vorname"
                                placeholder="Vorname ..."
                              />
                            </div>
                            <div class="col-sm-6 form-group">
                              <label for="auf_nachname">Nachname</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="auf_nachname"
                                name="auf_nachname"
                                placeholder="Nachname ..."
                              />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 form-group">
                              <label for="auf_telefon">Telefon</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="auf_telefon"
                                name="auf_telefon"
                                placeholder="Telefon ..."
                              />
                            </div>
                            <div class="col-sm-6 form-group">
                              <label for="auf_email">E-Mail-Adresse</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="auf_email"
                                name="auf_email"
                                placeholder="Email ..."
                              />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 form-group">
                              <label for="auf_strasse">Straße</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="auf_strasse"
                                name="auf_strasse"
                                placeholder="Straße ..."
                              />
                            </div>
                            <div class="col-sm-6 form-group">
                              <label for="auf_hausnummer">Hausnummer</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="auf_hausnummer"
                                name="auf_hausnummer"
                                placeholder="Hausnummer ..."
                              />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 form-group">
                              <label for="auf_plz">PLZ</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="auf_plz"
                                name="auf_plz"
                                placeholder="PLZ ..."
                              />
                            </div>
                            <div class="col-sm-6 form-group">
                              <label for="auf_ort">Ort</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="auf_ort"
                                name="auf_ort"
                                placeholder="Ort ..."
                              />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 form-group">
                              <label for="auf_land">Land</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="auf_land"
                                name="auf_land"
                                placeholder="Land ..."
                              />
                            </div>
                            <div class="col-sm-6"></div>
                          </div>
                          <div class="row">
                            <h5>
                              <b>Lieferadresse</b>
                            </h5>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 form-group">
                              <label for="lif_firmenname">Firmenname</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="lif_firmenname"
                                name="lif_firmenname"
                                placeholder="Firmenname ..."
                              />
                            </div>
                            <div class="col-sm-6"></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-8 container-fluid">
                              <div class="row">
                                <h6>Ansprechpartner</h6>
                                <div class="col-sm-6 form-group">
                                  <label for="lif_anrede">Anrede</label>
                                  <input
                                    required
                                    type="text"
                                    class="form-control"
                                    id="lif_anrede"
                                    name="lif_anrede"
                                  />
                                </div>
                                <div class="col-sm-6 form-group">
                                  <label for="lif_titel">Titel</label>
                                  <input
                                    required
                                    type="text"
                                    class="form-control"
                                    id="lif_titel"
                                    name="lif_titel"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4"></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 form-group">
                              <label for="lif_vorname">Vorname</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="lif_vorname"
                                name="lif_vorname"
                                placeholder="Vorname ..."
                              />
                            </div>
                            <div class="col-sm-6 form-group">
                              <label for="lif_nachname">Nachname</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="lif_nachname"
                                name="lif_nachname"
                                placeholder="Nachname ..."
                              />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 form-group">
                              <label for="lif_telefon">Telefon</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="lif_telefon"
                                name="lif_telefon"
                                placeholder="Telefon ..."
                              />
                            </div>
                            <div class="col-sm-6 form-group">
                              <label for="lif_email">E-Mail-Adresse</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="lif_email"
                                name="lif_email"
                                placeholder="Email ..."
                              />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 form-group">
                              <label for="lif_strasse">Straße</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="lif_strasse"
                                name="lif_strasse"
                                placeholder="Straße ..."
                              />
                            </div>
                            <div class="col-sm-6 form-group">
                              <label for="lif_hausnummer">Hausnummer</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="lif_hausnummer"
                                name="lif_hausnummer"
                                placeholder="Hausnummer ..."
                              />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 form-group">
                              <label for="lif_plz">PLZ</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="lif_plz"
                                name="lif_plz"
                                placeholder="PLZ ..."
                              />
                            </div>
                            <div class="col-sm-6 form-group">
                              <label for="lif_ort">Ort</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="lif_ort"
                                name="lif_ort"
                                placeholder="Ort ..."
                              />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 form-group">
                              <label for="lif_land">Land</label>
                              <input
                                required
                                type="text"
                                class="form-control"
                                id="lif_land"
                                name="lif_land"
                                placeholder="Land ..."
                              />
                            </div>
                            <div class="col-sm-6"></div>
                          </div>
                        </div>
                      </div>
                      <div id="div_auftrag-versandrechner" class="col-sm-6">
                        <order_calculator></order_calculator>
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
import order_calculator from './order_calculator.vue';

export default {
  name: "order_dialog2",
  props: ['showOrderModal2','clientData'],
  data: function () {
    return {
      showOrderModal2: false,
    };
  },
  methods: {
    close: function () {
      this.showOrderModal2 = false;
      this.$emit('close_order_modal2');
    },
  },
  components: {
    order_calculator
  }
};
</script>

<style>
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
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
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