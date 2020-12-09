<template>
  <tr id="component_order_table_row">
    <td>
      <span>
        &nbsp;
        <img v-bind:src="clientImg.src" v-bind:alt="clientImg.alt" />
        <span>&nbsp;{{companyName}}</span>
      </span>
    </td>
    <td>{{createdAt}}</td>
    <td>{{pickupCountry}}&nbsp;{{pickupPLZ}}</td>
    <td>{{deliveryCountry}}&nbsp;{{deliveryPLZ}}</td>
    <td>
      <order_status_select
        v-if="showStatusSelect"
        :id="statusSelectId"
        :statusValue="statusValue"
        :showStatusSelect="showStatusSelect"
        v-on:optionChange="option_change($event)"
      ></order_status_select>
      <span v-else :id="statusId">{{statusValue}}</span>
    </td>
    <td class="td_actions">
      <order_detail :id="id"></order_detail>
      <img v-bind:src="EditImg.src" v-bind:alt="EditImg.alt" v-on:click="display_order_select()" />
      <img
        v-if="showOrderInvoice"
        v-bind:src="CreateInv.src"
        v-bind:alt="CreateInv.alt"
        v-on:click="order_invoice()"
      />
    </td>
    <td>
      <order_invoice :invoiceId="id" :clientData="clientData"></order_invoice>
    </td>
  </tr>
</template>

<script>
import order_detail from "./order_detail.vue";
import order_status_select from "./order_status_select.vue";
import order_invoice from "./order_invoice.vue";

export default {
  name: "order_table_row",
  props: [
    "id",
    "companyName",
    "clientId",
    "clientData",
    "createdAt",
    "pickupCountry",
    "pickupPLZ",
    "deliveryCountry",
    "deliveryPLZ",
    "statusValue",
    "statusColor",
  ],
  data: function () {
    return {
      clientImg: {
        src: "../images/an_auf_table/firmen_details.png",
        alt: "Company",
      },
      EditImg: {
        src: "../images/an_auf_table/change_status.png",
        alt: "Change status",
      },
      CreateInv: {
        src: "../images/an_auf_table/order_invoice.png",
        alt: "Download invoice",
      },
      showStatusSelect: false,
      statusSelectId: "statusSelect_" + this.id,
      statusId: "status_" + this.id,
      showOrderInvoice: false,
    };
  },
  mounted: function () {
    this.apply_status_color();
  },
  updated: function () {
    this.apply_status_color();
  },
  methods: {
    display_order_select: function () {
      this.showStatusSelect = true;
    },
    option_change: function (newOption) {
      this.showStatusSelect = false;
      this.statusValue = newOption;
      if (this.statusValue === "abgeschlossen") {
        this.showOrderInvoice = true;
      } else {
        this.showOrderInvoice = false;
      }
    },
    order_invoice: function () {
      const element = document.getElementById("orderInvoice_" + this.id);
      const opt = {
        filename: `document.pdf`,
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: "mm", format: "letter", orientation: "portrait" },
      };
      html2pdf().from(element).set(opt).save();
    },
    apply_status_color: function () {
      switch (this.statusValue) {
        case "offen":
          this.statusColor = "red";
          break;
        case "ausstehend":
          this.statusColor = "orange";
          break;
        case "abgelehnt":
          this.statusColor = "purple";
          break;
        case "beauftragt":
          this.statusColor = "green";
          break;
        case "abgeschlossen":
          this.statusColor = "black";
          break;
      }
      if (!this.showStatusSelect) {
        document.getElementById(this.statusId).style.color = this.statusColor;
      }
    },
  },
  components: { order_detail, order_status_select, order_invoice },
};
</script>

<style>
#component_order_table_row .td_actions {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
  justify-content: space-evenly;
}
#component_order_table_row .td_actions img {
  cursor: pointer;
}
#component_order_table_row .component_order_invoice {
  display: none;
}
</style>