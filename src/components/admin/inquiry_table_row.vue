<template>
  <tr id="component_inquiry_table_row">
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
      <span :id="status_id">
        {{ status }}
      </span>
    </td>
    <td class="td_actions">
      <inquiry_detail :id="id"></inquiry_detail>
    </td>
  </tr>
</template>

<script>
import inquiry_detail from "./inquiry_detail.vue";
import moment from "moment";

export default {
  name: "inquiry_table_row",
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
        src: "img/inquiry_invoice.png",
        alt: "Rechnung herunterladen",
      },
      status_id: "status_" + this.id,
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
    apply_status_color: function () {
      document.getElementById(this.status_id).style.color = this.status_color;
    },
  },
  components: { inquiry_detail },
};
</script>

<style>
#component_inquiry_table_row .td_actions {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
  justify-content: flex-start;
}
#component_inquiry_table_row .td_actions img {
  cursor: pointer;
}
#component_inquiry_table_row .component_inquiry_invoice {
  display: none;
}
</style>
