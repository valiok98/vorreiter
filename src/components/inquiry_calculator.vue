<template>
  <div>
    <h5>Sendungsdetails</h5>
    <h5>Wo soll das Paket abgeholt werden?</h5>
    <div>Nur nationale / in Deutschland gültige PLZ eingeben.</div>
    <input
      type="text"
      id="inq_plz-start"
      name="inq_plz-start"
      minlength="3"
      maxlength="10"
      size="5"
      pattern="[0-9]{3,10}"
      class="form-control"
      placeholder="Abhol-PLZ"
      required
    />
    <br />
    <h5>Wohin soll das Paket geliefert werden?</h5>
    <div>Nur nationale / in Deutschland gültige PLZ eingeben.</div>
    <input
      type="text"
      id="inq_plz-ziel"
      name="inq_plz-ziel"
      minlength="3"
      maxlength="10"
      size="5"
      pattern="[0-9]{3,10}"
      class="form-control"
      placeholder="Ziel-PLZ"
      required
    />
    <br />
    <h4>Wann dürfen wir für Sie zustellen?</h4>
    <div class="container-fluid">
      <form id="inq_versandrechner" method="post" class="m-form">
        <div class="row">
          <div class="col-sm-5 smaller">Zustellfenster:</div>
          <div class="col-sm-7 form-group smaller">
            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="inq_zeitfenster"
                id="inq_zeit1"
                value="2"
                required
              />
              <label class="form-check-label" for="inq_zeit1">07:30 – 08:00 Uhr</label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="inq_zeitfenster"
                id="inq_zeit2"
                value="3"
              />
              <label class="form-check-label" for="inq_zeit2">08:00 – 09:00 Uhr</label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="inq_zeitfenster"
                id="inq_zeit3"
                value="5"
              />
              <label class="form-check-label" for="inq_zeit3">08:00 – 10:00 Uhr</label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="inq_zeitfenster"
                id="inq_zeit4"
                value="6"
              />
              <label class="form-check-label" for="inq_zeit4">08:00 – 12:00 Uhr</label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="inq_zeitfenster"
                id="inq_zeit5"
                value="7"
              />
              <label class="form-check-label" for="inq_zeit5">09:00 – 17:00 Uhr</label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="inq_zeitfenster"
                id="inq_zeitfensterfix"
                value="-1"
              />
              <label class="form-check-label" for="inq_zeitfensterfix">Fixtermin</label>
            </div>
          </div>
          <div class="col-sm-5 smaller">Zustellung am:</div>
          <div class="col-sm-7 form-group smaller">
            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="inq_zustelltag"
                id="inq_zustelltagmofr"
                value="1"
                required
              />
              <label
                class="form-check-label"
                for="inq_zustelltagmofr"
              >Mo. – Fr. (am folgenen Werktag)</label>
            </div>

            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="inq_zustelltag"
                id="inq_zustelltagsa"
                value="2"
              />
              <label class="form-check-label" for="inq_zustelltagsa">Samstag</label>
            </div>

            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="inq_zustelltag"
                id="inq_zustelltagso"
                value="3"
              />
              <label class="form-check-label" for="inq_zustelltagso">Sonn-/Feiertag</label>
            </div>
          </div>
        </div>
        <div class="row">
          <h4>Maße und Gewicht Ihrer Sendung:</h4>
          <div class="form-group form-inline">
            <input
              type="text"
              name="inq_groesse-x"
              id="inq_groesse-x"
              minlength="1"
              maxlength="6"
              size="1"
              pattern="[0-9]+"
              class="form-control grge"
              placeholder="Länge"
              required
            />
            <span>&nbsp;x&nbsp;</span>
            <input
              type="text"
              name="inq_groesse-y"
              id="inq_groesse-y"
              minlength="1"
              maxlength="6"
              size="1"
              pattern="[0-9]+"
              class="form-control grge"
              placeholder="Breite"
              required
            />
            <span>&nbsp;x&nbsp;</span>
            <input
              type="text"
              name="inq_groesse-z"
              id="inq_groesse-z"
              minlength="1"
              maxlength="6"
              size="1"
              pattern="[0-9]+"
              class="form-control grge"
              placeholder="Höhe"
              required
            />
            <span>&nbsp;cm&nbsp;</span>
            <br />
            <span class="spaced smaller">
              <label for="inq_volumengewicht">Resultierendes Volumengewicht:</label>
              <input
                type="text"
                name="inq_volumengewicht"
                id="inq_volumengewicht"
                size="1"
                pattern="[0-9]+"
                class="form-control"
                value="0"
                disabled
              />&nbsp;kg
            </span>
            <br />
            <!-- <label for="inq_volumengewicht">Resultierendes Volumengewicht:</label> -->
            <span id="inq_span_gewicht">
              <input
                type="text"
                name="inq_gewicht"
                id="inq_gewicht"
                placeholder="Gewicht"
                minlength="1"
                maxlength="6"
                size="1"
                pattern="[0-9]+"
                class="form-control grge"
                required
              />
              <span>kg</span>
            </span>
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <button id="inq_neworder" type="button">
              <img id="inq_neworder_img" alt="Sendung hinzufügen" />
              <h4 id="inq_neworder_headline">
                <b>Sendung hinzufügen</b>
              </h4>
            </button>
          </div>

          <div class="form-group">
            <h4 id="inq_serviceheadline">
              Zusätzliche Serviceleistungen
              <br />
              <small>
                [Nachname, Empfangsbestätigung, ...]
                <br />
                <span id="inq_servicelink">Bitte klicken</span>
              </small>
            </h4>
            <div id="inq_serviceauswahl">
              <div class="btn-close" id="inq_serviceclose">
                <div class="btn-close-x"></div>
                <div class="btn-close-x"></div>
              </div>
              <div class="tbl">
                <div class="tblrow">
                  <div class="tblcell">Fixe Zustellung</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">50,00&nbsp;€</div>
                  <div class="tblcell">
                    <input
                      type="checkbox"
                      id="inq_service1"
                      name="inq_service"
                      value="Fixe Zustellung"
                    />
                    <label for="inq_service1"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">Bereichszustellung</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">5,00&nbsp;€</div>
                  <div class="tblcell">
                    <input
                      type="checkbox"
                      id="inq_service2"
                      name="inq_service"
                      value="Bereichszustellung"
                    />
                    <label for="inq_service2"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">Empfangsbestätigung</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">4,00&nbsp;€</div>
                  <div class="tblcell">
                    <input
                      type="checkbox"
                      id="inq_service3"
                      name="inq_service"
                      value="Empfangsbestaetigung"
                    />
                    <label for="inq_service3"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">Empfangsbestätigung (telefonisch)</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">2,00&nbsp;€</div>
                  <div class="tblcell">
                    <input
                      type="checkbox"
                      id="inq_service4"
                      name="inq_service"
                      value="Empfangsbestaetigung telefonisch"
                    />
                    <label for="inq_service4"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">Höherhaftung bis 2.500&nbsp;€ pro Sendung</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">3,50&nbsp;€</div>
                  <div class="tblcell">
                    <input
                      type="checkbox"
                      id="inq_service5"
                      name="inq_service"
                      value="Hoeherhaftung"
                    />
                    <label for="inq_service5"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">Indet-Zustellung mit Vertragsservice</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">7,00&nbsp;€</div>
                  <div class="tblcell">
                    <input
                      type="checkbox"
                      id="inq_service6"
                      name="inq_service"
                      value="Indet-Zustellung Vertragsservice"
                    />
                    <label for="inq_service6"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">Insel-Zustellung</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">30,00&nbsp;€</div>
                  <div class="tblcell">
                    <input
                      type="checkbox"
                      id="inq_service7"
                      name="inq_service"
                      value="Insel-Zustellung"
                    />
                    <label for="inq_service7"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">Lagerung nicht zugestellter Sendung je Tag</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">1,00&nbsp;€</div>
                  <div class="tblcell">
                    <input type="checkbox" id="inq_service8" name="inq_service" value="Lagerung" />
                    <label for="inq_service8"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">Messeservice</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">10,00&nbsp;€</div>
                  <div class="tblcell">
                    <input
                      type="checkbox"
                      id="inq_service9"
                      name="inq_service"
                      value="Messeservice"
                    />
                    <label for="inq_service9"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">Nachnahme</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">8,00&nbsp;€</div>
                  <div class="tblcell">
                    <input type="checkbox" id="inq_service11" name="inq_service" value="Nachnahme" />
                    <label for="inq_service11"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">Persönliche Zustellung mit Dokumentation</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">5,00&nbsp;€</div>
                  <div class="tblcell">
                    <input
                      type="checkbox"
                      id="inq_service12"
                      name="inq_service"
                      value="Persoenliche Zustellung"
                    />
                    <label for="inq_service12"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">Samstagszustellung</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">2,00&nbsp;€</div>
                  <div class="tblcell">
                    <input
                      type="checkbox"
                      id="inq_service13"
                      name="inq_service"
                      value="Samstagszustellung"
                    />
                    <label for="inq_service13"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">SmartPic</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">46,00&nbsp;€</div>
                  <div class="tblcell">
                    <input type="checkbox" id="inq_service14" name="inq_service" value="SmartPic" />
                    <label for="inq_service14"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">SmartPic+</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">50,00&nbsp;€</div>
                  <div class="tblcell">
                    <input type="checkbox" id="inq_service15" name="inq_service" value="SmartPic+" />
                    <label for="inq_service15"></label>
                  </div>
                </div>
                <div class="tblrow">
                  <div class="tblcell">Sonn- und Feiertagszustellung</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">40,00&nbsp;€</div>
                  <div class="tblcell">
                    <input
                      type="checkbox"
                      id="inq_service16"
                      name="inq_service"
                      value="Sonntagszustellung"
                    />
                    <label for="inq_service16"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">Verpackungsrückführung</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">2,00&nbsp;€</div>
                  <div class="tblcell">
                    <input
                      type="checkbox"
                      id="inq_service17"
                      name="inq_service"
                      value="Verpackungsrueckführung"
                    />
                    <label for="inq_service17"></label>
                  </div>
                </div>

                <div class="tblrow">
                  <div class="tblcell">X-Change</div>
                  <div class="tblcell">zzgl.</div>
                  <div class="tblcell">2,00&nbsp;€</div>
                  <div class="tblcell">
                    <input type="checkbox" id="inq_service18" name="inq_service" value="X-Change" />
                    <label for="inq_service18"></label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 form-group" id="inq_feedbackcol">
            <h4>Ihr Preis:</h4>
            <h4 id="inq_gesamtpreis">
              Gesamtpreis:
              <span id="inq_gesamtpreisvalue"></span>
            </h4>
            <h4 id="inq_gesamtvolumengewicht">
              Gesamtvolumengewicht:
              <span id="inq_gesamtvolumengewichtvalue"></span>
            </h4>
          </div>

          <div class="col-12 form-group" id="inq_shipmentscol">
            <h4>Ihre Sendungen:</h4>
            <div id="inq_shipmentslist"></div>
          </div>

          <div class="col-12" id="inq_ajaxerror">
            <h4>Ein Fehler ist aufgetreten.</h4>
            <span id="inq_" class="text"></span>
          </div>

          <div class="col-12" id="inq_ajaxdone">
            <h4>Vielen Dank!</h4>
            <br />
            <span class="text"></span>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-12">
            <button
              name="inq_bs"
              value="abs"
              id="inq_btnversandrechner_abs"
              class="btn btn-primary"
              disabled
            >Absenden</button>
          </div>
        </div>
        <div class="row">
          <input type="hidden" id="inq_token" name="inq_token" value="$$TOKEN$$" />
          <input type="hidden" id="inq_summe" name="inq_summe" value />
          <input type="text" name="inq_username" id="inq_username" value />
        </div>
      </form>
      <div id="inq_dialog_delete_shipment" title="Sind Sie sich sicher ?">
        <p>Die gewünschte Sendung wird unwiderruflich gelöscht.</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "inquiry_calculator",
};
</script>

<style>
</style>