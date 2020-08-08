<?php

/**
 * Get the HTML template of the calculator.
 * @param $type - The type of the calculator - anfrage/auftrag.
 */
function get_versandrechner($type)
{
    $prefix = '';
    $plzPart = '';
    if ($type === 'anfrage') {
        $prefix = 'an';
        $plzPart = '
            <h5>
                Wo soll das Paket abgeholt werden?
            </h5>
            <div>
                Nur nationale / in Deutschland gültige PLZ eingeben.
            </div>
            <input type="text" id="' . $prefix . '_plz-start" name="' . $prefix . '_plz-start" minlength="3" maxlength="10" size="5" pattern="[0-9]{3,10}"
                class="form-control" placeholder="Abhol-PLZ" required/>
            <br>
            <h5>
                Wohin soll das Paket geliefert werden?
            </h5>
            <div>
                Nur nationale / in Deutschland gültige PLZ eingeben.
            </div>
            <input type="text" id="' . $prefix . '_plz-ziel" name="' . $prefix . '_plz-ziel" minlength="3" maxlength="10" size="5" pattern="[0-9]{3,10}"
                class="form-control" placeholder="Ziel-PLZ" required/>
            <br>
        ';
    } else if ($type === 'auftrag') {
        $prefix = 'auf';
    }


    echo
        '<h5>Sendungsdetails</h5>
        ' . $plzPart . '
        <h4>Wann dürfen wir für Sie zustellen?</h4>
        <div class="container-fluid">
        <form id="versandrechner_' . $type . '" method="post" class="m-form">
            <div class="row">
                <div class="col-sm-5 smaller">
                    Zustellfenster:
                </div>
                <div class="col-sm-7 form-group smaller">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="' . $prefix . '_zeitfenster" id="' . $prefix . '_zeit1" value="2" required />
                        <label class="form-check-label" for="' . $prefix . '_zeit1">
                            07:30 – 08:00 Uhr
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="' . $prefix . '_zeitfenster" id="' . $prefix . '_zeit2" value="3" />
                        <label class="form-check-label" for="' . $prefix . '_zeit2">
                            08:00 – 09:00 Uhr
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="' . $prefix . '_zeitfenster" id="' . $prefix . '_zeit3" value="5" />
                        <label class="form-check-label" for="' . $prefix . '_zeit3">
                            08:00 – 10:00 Uhr
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="' . $prefix . '_zeitfenster" id="' . $prefix . '_zeit4" value="6" />
                        <label class="form-check-label" for="' . $prefix . '_zeit4">
                            08:00 – 12:00 Uhr
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="' . $prefix . '_zeitfenster" id="' . $prefix . '_zeit5" value="7" />
                        <label class="form-check-label" for="' . $prefix . '_zeit5">
                            09:00 – 17:00 Uhr
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="' . $prefix . '_zeitfenster" id="' . $prefix . '_zeitfensterfix" value="-1" />
                        <label class="form-check-label" for="' . $prefix . '_zeitfensterfix">
                            Fixtermin
                        </label>
                    </div>
                </div>
                <div class="col-sm-5 smaller">
                    Zustellung am:
                </div>
                <div class="col-sm-7 form-group smaller">

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="' . $prefix . '_zustelltag" id="' . $prefix . '_zustelltagmofr" value="1" required />
                        <label class="form-check-label" for="' . $prefix . '_zustelltagmofr">
                            Mo. – Fr. (am folgenen Werktag)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="' . $prefix . '_zustelltag" id="' . $prefix . '_zustelltagsa" value="2" />
                        <label class="form-check-label" for="' . $prefix . '_zustelltagsa">
                            Samstag
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="' . $prefix . '_zustelltag" id="' . $prefix . '_zustelltagso" value="3" />
                        <label class="form-check-label" for="' . $prefix . '_zustelltagso">
                            Sonn-/Feiertag
                        </label>
                    </div>

                </div>
            </div>
            <div class="row">
                <h4>
                    Maße und Gewicht Ihrer Sendung:
                </h4>
                <div class="form-group form-inline">
                    <input type="text" name="' . $prefix . '_groesse-x" id="' . $prefix . '_groesse-x" minlength="1" maxlength="6" size="1" pattern="[0-9]+" class="form-control grge" placeholder="Länge" required />
                    <span>&nbsp;x&nbsp;</span>
                    <input type="text" name="' . $prefix . '_groesse-y" id="' . $prefix . '_groesse-y" minlength="1" maxlength="6" size="1" pattern="[0-9]+" class="form-control grge" placeholder="Breite" required />
                    <span>&nbsp;x&nbsp;</span>
                    <input type="text" name="' . $prefix . '_groesse-z" id="' . $prefix . '_groesse-z" minlength="1" maxlength="6" size="1" pattern="[0-9]+" class="form-control grge" placeholder="Höhe" required />
                    <span>&nbsp;cm&nbsp;</span>
                    <br />
                    <span class="spaced smaller">
                        <label for="' . $prefix . '_volumengewicht">Resultierendes Volumengewicht:</label>
                        <input type="text" name="' . $prefix . '_volumengewicht" id="' . $prefix . '_volumengewicht" size="1" pattern="[0-9]+" class="form-control" value="0" disabled />&nbsp;kg
                    </span>
                    <br />
                    <!-- <label for="' . $prefix . '_volumengewicht">Resultierendes Volumengewicht:</label> -->
                    <span id="' . $prefix . '_span_gewicht">
                        <input type="text" name="' . $prefix . '_gewicht" id="' . $prefix . '_gewicht" placeholder="Gewicht" minlength="1" maxlength="6" size="1" pattern="[0-9]+" class="form-control grge" required />
                        <span>kg</span>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <button id="' . $prefix . '_neworder" type="button">
                        <img id="' . $prefix . '_neworder_img" alt="Sendung hinzufügen">
                        <h4 id="' . $prefix . '_neworder_headline">
                            <b>Sendung hinzufügen</b>
                        </h4>
                    </button>
                </div>

                <div class="form-group">
                    <h4 id="' . $prefix . '_serviceheadline">Zusätzliche Serviceleistungen<br />
                        <small>[Nachname, Empfangsbestätigung, ...] <br /><span id="' . $prefix . '_servicelink">Bitte klicken</span></small></h4>
                    <div id="' . $prefix . '_serviceauswahl">
                        <div class="btn-close" id="' . $prefix . '_serviceclose">
                            <div class="btn-close-x"></div>
                            <div class="btn-close-x"></div>

                        </div>
                        <div class="tbl">
                            <div class="tblrow">
                                <div class="tblcell">Fixe Zustellung</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">50,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service1" name="' . $prefix . '_service" value="Fixe Zustellung" />
                                    <label for="' . $prefix . '_service1"></label>
                                </div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">Bereichszustellung</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">5,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service2" name="' . $prefix . '_service" value="Bereichszustellung" />
                                    <label for="' . $prefix . '_service2"></label></div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">Empfangsbestätigung</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">4,00&nbsp;€</div>
                                <div class="tblcell"><input type="checkbox" id="' . $prefix . '_service3" name="' . $prefix . '_service" value="Empfangsbestaetigung" />
                                    <label for="' . $prefix . '_service3"></label></div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">Empfangsbestätigung (telefonisch)</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">2,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service4" name="' . $prefix . '_service" value="Empfangsbestaetigung telefonisch">
                                    <label for="' . $prefix . '_service4"></label></div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">Höherhaftung bis 2.500&nbsp;€ pro Sendung</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">3,50&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service5" name="' . $prefix . '_service" value="Hoeherhaftung">
                                    <label for="' . $prefix . '_service5"></label>
                                </div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">Indet-Zustellung mit Vertragsservice</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">7,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service6" name="' . $prefix . '_service" value="Indet-Zustellung Vertragsservice" />
                                    <label for="' . $prefix . '_service6"></label>
                                </div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">Insel-Zustellung</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">30,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service7" name="' . $prefix . '_service" value="Insel-Zustellung" />
                                    <label for="' . $prefix . '_service7"></label>
                                </div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">Lagerung nicht zugestellter Sendung je Tag</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">1,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service8" name="' . $prefix . '_service" value="Lagerung" />
                                    <label for="' . $prefix . '_service8"></label>
                                </div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">Messeservice</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">10,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service9" name="' . $prefix . '_service" value="Messeservice" />
                                    <label for="' . $prefix . '_service9"></label>
                                </div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">Nachnahme</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">8,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service11" name="' . $prefix . '_service" value="Nachnahme" />
                                    <label for="' . $prefix . '_service11"></label>
                                </div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">Persönliche Zustellung mit Dokumentation</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">5,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service12" name="' . $prefix . '_service" value="Persoenliche Zustellung" />
                                    <label for="' . $prefix . '_service12"></label>
                                </div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">Samstagszustellung</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">2,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service13" name="' . $prefix . '_service" value="Samstagszustellung">
                                    <label for="' . $prefix . '_service13"></label>
                                </div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">SmartPic</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">46,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service14" name="' . $prefix . '_service" value="SmartPic">
                                    <label for="' . $prefix . '_service14"></label>
                                </div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">SmartPic+</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">50,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service15" name="' . $prefix . '_service" value="SmartPic+">
                                    <label for="' . $prefix . '_service15"></label>
                                </div>
                            </div>
                            <div class="tblrow">
                                <div class="tblcell">Sonn- und Feiertagszustellung</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">40,00&nbsp;€</div>
                                <div class="tblcell"><input type="checkbox" id="' . $prefix . '_service16" name="' . $prefix . '_service" value="Sonntagszustellung" />
                                    <label for="' . $prefix . '_service16"></label>
                                </div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">Verpackungsrückführung</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">2,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service17" name="' . $prefix . '_service" value="Verpackungsrueckführung" />
                                    <label for="' . $prefix . '_service17"></label>
                                </div>
                            </div>

                            <div class="tblrow">
                                <div class="tblcell">X-Change</div>
                                <div class="tblcell">zzgl.</div>
                                <div class="tblcell">2,00&nbsp;€</div>
                                <div class="tblcell">
                                    <input type="checkbox" id="' . $prefix . '_service18" name="' . $prefix . '_service" value="X-Change" />
                                    <label for="' . $prefix . '_service18"></label>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>



                <div class="col-12 form-group" id="' . $prefix . '_feedbackcol">
                    <h4>Ihr Preis:</h4>
                    <h4 id="' . $prefix . '_gesamtpreis">Gesamtpreis:
                        <span id="' . $prefix . '_gesamtpreisvalue"></span>
                    </h4>
                    <h4 id="' . $prefix . '_gesamtvolumengewicht">Gesamtvolumengewicht:
                        <span id="' . $prefix . '_gesamtvolumengewichtvalue"></span>
                    </h4>
                </div>

                <div class="col-12 form-group" id="' . $prefix . '_shipmentscol">
                    <h4>Ihre Sendungen:</h4>
                    <div id="' . $prefix . '_shipmentslist">
                    </div>
                </div>


                <div class="col-12 " id="' . $prefix . '_ajaxerror">
                    <h4>Ein Fehler ist aufgetreten.</h4>
                    <span id="' . $prefix . '_" class="text"></span>
                </div>

                <div class="col-12 " id="' . $prefix . '_ajaxdone">
                    <h4>Vielen Dank!</h4>
                    <br />
                    <span class="text"></span>
                </div>

            </div>
            <div class="row form-group">
                <div class="col-12">
                    <button name="' . $prefix . '_bs" value="abs" id="' . $prefix . '_btnversandrechner_abs" class="btn btn-primary" disabled>Absenden</button>
                </div>
            </div>
            <div class="row">
                <input type="hidden" id="' . $prefix . '_token" name="' . $prefix . '_token" value="$$TOKEN$$" />
                <input type="hidden" id="' . $prefix . '_summe" name="' . $prefix . '_summe" value="" />
                <input type="text" name="' . $prefix . '_username" id="' . $prefix . '_username" value="" />
            </div>
        </form>
        <div id="' . $prefix . '_dialog_delete_shipment" title="Sind Sie sich sicher ?">
            <p>Die gewünschte Sendung wird unwiderruflich gelöscht.</p>
        </div>
    </div>
';
}
