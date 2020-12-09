<template>
  <div v-if="clientData" :id="orderInvoiceId" class="component_order_invoice">
    <div class="logo">
      <img v-bind:src="logoImg.src" v-bind:alt="logoImg.alt" />
    </div>
    <div class="companyInfo1">
      <span>{{clientData.companyName}} | {{clientData.companyStreet}} | {{clientData.companyAddress}}</span>
      <br />
      <h5>
        <b>{{clientData.companyName}}</b>
      </h5>
      <h5>{{clientData.companyStreet}}</h5>
      <h5>{{clientData.companyAddress}}</h5>
    </div>
    <div class="companyInfo2">
      <div>
        <h6>
          <b>Kundennummer</b>
        </h6>
        <h6>{{clientData.clientNumber}}</h6>
      </div>
      <div>
        <h6>
          <b>Liefer- /Leistungsdatum</b>
        </h6>
        <h6>TT.MM.JJJJ</h6>
      </div>
      <div>
        <h6>
          <b>Rechnungsdatum</b>
        </h6>
        <h6>TT.MM.JJJJ</h6>
      </div>
    </div>
    <div class="invoiceSection">
      <h3>
        <b>Rechnung</b>
      </h3>
    </div>
    <div class="footer">
      <hr />
      {{clientData.companyName}}
      <hr />
    </div>
  </div>
</template>

<script>
export default {
  props: ["invoiceId", "clientData"],
  name: "order_invoice",
  data: function () {
    return {
      logoImg: {
        src: "../images/index/vorreiter_logo_pdf.jpg",
        alt: "Firmenlogo",
      },
      orderInvoiceId: "orderInvoice_" + this.invoiceId,
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

.component_order_invoice .footer {
  width: 90%;
}

/** RTL **/
.rtl {
  direction: rtl;
  font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial,
    sans-serif;
}

.rtl table {
  text-align: right;
}

.rtl table tr td:nth-child(2) {
  text-align: left;
}
</style>
