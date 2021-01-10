<template>
  <div v-if="client_data" :id="order_invoice_id" class="component_order_invoice">
    <div class="logo">
      <img v-bind:src="imgLogo.src" v-bind:alt="imgLogo.alt" />
    </div>
    <div class="companyInfo1">
      <span>
        [LST-Siegen&nbsp;-&nbsp;Effertsurfer&nbsp;69&nbsp;-&nbsp;57072&nbsp;Siegen]</span
      >
      <br />
      <h5>
        <b>{{ client_data.company_name }}</b>
      </h5>
      <h5>{{ client_data.street }}&nbsp;{{ client_data.house_number }}</h5>
      <h5>{{ client_data.postal_code }}&nbsp;{{ client_data.place }}</h5>
    </div>
    <div class="companyInfo2">
      <div>
        <h6>
          <b>Kundennummer</b>
        </h6>
        <h6>{{ client_data.id }}</h6>
      </div>
      <div>
        <h6>
          <b>Liefer- /Leistungsdatum</b>
        </h6>
        <h6>{{ completed_timestamp }}</h6>
      </div>
      <div>
        <h6>
          <b>Rechnungsdatum</b>
        </h6>
        <h6>{{ invoice_timestamp }}</h6>
      </div>
    </div>
    <div class="invoiceSection">
      <h3>
        <b>Rechnung</b>
      </h3>
      <hr />
      <ul
        v-bind:key="package_.id"
        v-for="(package_, index) in packages"
        id="div_ord_packages"
      >
        <li>
          <b>Paket {{ index + 1 }}</b>
        </li>
        <li class="spaced_in_block">Länge: {{ package_.length }} cm</li>
        <li class="spaced_in_block">Breite: {{ package_.width }} cm</li>
        <li class="spaced_in_block">Höhe: {{ package_.height }} cm</li>
        <li class="spaced_in_block">Volumengewicht: {{ package_.volume_weight }} kg</li>
        <li class="spaced_in_block">Gewicht: {{ package_.weight }} kg</li>
        <li class="spaced_in_block">Gurtmaß: {{ package_.girth }} cm</li>
        <li class="spaced_in_block">Preis: €{{ package_.price.toFixed(2) }}</li>
        <li
          class="spaced_in_block"
          v-if="package_.services && JSON.parse(package_.services).length"
        >
          <span><b>Dienstleistungen:</b></span>
          <br />
          <ul
            v-if="package_.services && JSON.parse(package_.services).length"
            class="spaced_in_block"
          >
            <li v-bind:key="service.id" v-for="service in JSON.parse(package_.services)">
              {{ service.title }}
            </li>
          </ul>
        </li>
        <li><br /></li>
      </ul>
      <hr />
    </div>
    <div class="footer">
      <div>
        <div><small>LST-Siegen</small></div>
        <div><small>Effertsurfer 69</small></div>
        <div><small>57072 Siegen</small></div>
      </div>
      <div>
        <div><small>Telefon: +49(0) 271 387 59 89</small></div>
        <div><small>Mobil: +49(0) 175 713 05 73</small></div>
        <div><small>E-Mail: info@lst-siegen.de</small></div>
      </div>
      <div>
        <div><small>Bankverbindung</small></div>
        <div><small>IBAN: DE13460500010000076109</small></div>
        <div><small>BIC: WELADED1SIE</small></div>
      </div>
      <div>
        <div><small>US-t-ID: DE290318300</small></div>
        <div><small>Steuer-Nr: 342/5296/3293</small></div>
        <div><small>Inhaber: Lars Setz</small></div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";

export default {
  props: ["invoice_id", "client_data", "completed_timestamp", "packages"],
  name: "order_invoice",
  data: function () {
    return {
      imgLogo: {
        src: "img/lst_logo.png",
        alt: "LST logo",
      },
      order_invoice_id: "order_invoice_" + this.invoice_id,
      invoice_timestamp: moment().format("DD.MM.YYYY"),
    };
  },
};
</script>

<style>
.component_order_invoice {
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  justify-content: space-evenly;
}
.component_order_invoice .logo {
  align-self: flex-end;
  margin-top: 50px;
  margin-right: 50px;
}
.component_order_invoice .companyInfo1 {
  align-self: flex-start;
  margin-left: 50px;
}
.component_order_invoice .companyInfo2 {
  align-self: flex-end;
  margin-right: 50px;
}
.component_order_invoice .invoiceSection {
  align-self: flex-start;
  margin-left: 50px;
}

.component_order_invoice #div_ord_packages {
  width: 100%;
}

.component_order_invoice .spaced_in_block {
  margin-left: 10%;
  width: 100%;
}
.component_order_invoice .footer {
  width: 100%;
  margin: 0 auto;
  display: flex;
  flex-flow: row nowrap;
  padding-left: 5%;
  padding-right: 5%;
}
.component_order_invoice .footer > div {
  width: 25%;
}
</style>
