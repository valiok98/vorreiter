<template>
  <tr id="component_order_table_row">
    <td>
      <span>
        &nbsp;
        <img v-bind:src="clientImg.src" v-bind:alt="clientImg.alt" />
        <span>&nbsp;{{ client_data.company_name }}</span>
      </span>
    </td>
    <td>{{ created_at }}</td>
    <td>{{ pickup_country }}&nbsp;{{ pickup_postal_code }}</td>
    <td>{{ delivery_country }}&nbsp;{{ delivery_postal_code }}</td>
    <td>
      <order_status_select
        v-if="show_status_select"
        :id="status_select_id"
        :status="status"
        :show_status_select="show_status_select"
        v-on:option_change="option_change($event)"
      ></order_status_select>
      <span v-else :id="status_id">{{ status }}</span>
    </td>
    <td class="td_actions">
      <order_detail :id="id"></order_detail>
      <img
        v-bind:src="editImg.src"
        v-bind:alt="editImg.alt"
        v-on:click="display_order_select()"
      />
      <img
        v-if="show_order_invoice"
        v-bind:src="createInvoiceImg.src"
        v-bind:alt="createInvoiceImg.alt"
        v-on:click="order_invoice()"
      />
    </td>
    <td>
      <order_invoice
        :invoice_id="id"
        :client_data="client_data"
        :packages="packages"
        :completed_timestamp="completed_timestamp"
      ></order_invoice>
    </td>
  </tr>
</template>

<script>
import order_detail from "./order_detail.vue";
import order_status_select from "./order_status_select.vue";
import order_invoice from "./order_invoice.vue";
import moment from "moment";

export default {
  name: "order_table_row",
  props: [
    "id",
    "client_data",
    "packages",
    "created_at",
    "pickup_country",
    "pickup_postal_code",
    "delivery_country",
    "delivery_postal_code",
    "status",
    "status_color",
  ],
  data: function () {
    return {
      clientImg: {
        src: "img/company_details.png",
        alt: "Firma",
      },
      editImg: {
        src: "img/change_status.png",
        alt: "Status ändern",
      },
      createInvoiceImg: {
        src: "img/order_invoice.png",
        alt: "Rechnung herunterladen",
      },
      show_status_select: false,
      status_select_id: "status_select_" + this.id,
      status_id: "status_" + this.id,
      show_order_invoice: false,
      completed_timestamp: "",
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
      this.show_status_select = true;
    },
    option_change: function (newOption) {
      this.show_status_select = false;
      this.status = newOption;
      if (this.status === "abgeschlossen") {
        this.completed_timestamp = moment().format("DD.MM.YYYY");
        this.show_order_invoice = true;
      } else {
        this.show_order_invoice = false;
      }
    },
    order_invoice: function () {
      const element = document.getElementById("order_invoice_" + this.id);
      const opt = {
        filename: `document.pdf`,
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: "mm", format: "letter", orientation: "portrait" },
      };
      html2pdf().from(element).set(opt).save();
    },
    apply_status_color: function () {
      switch (this.status) {
        case "offen":
          this.status_color = "#f01e28";
          break;
        case "ausstehend":
          this.status_color = "#ff6e0f";
          break;
        case "beauftragt":
          this.status_color = "#82ff00";
          break;
        case "in Auslieferung":
          this.status_color = "#fac300";
          break;
        case "ausgeliefert":
          this.status_color = "#0082ff";
          break;
        case "abgeschlossen":
          this.status_color = "#008200";
          break;
        case "fakturiert":
          this.status_color = "#0000ff";
          break;
        case "abgelehnt":
          this.status_color = "#af00af";
          break;
        case "beschädigt":
          this.status_color = "#707070";
          break;
        case "Retoure":
          this.status_color = "#8c3c2d";
          break;
      }
      if (!this.show_status_select) {
        document.getElementById(this.status_id).style.color = this.status_color;
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
  justify-content: flex-start;
}
#component_order_table_row .td_actions img {
  cursor: pointer;
}
#component_order_table_row .component_order_invoice {
  display: none;
}
</style>
