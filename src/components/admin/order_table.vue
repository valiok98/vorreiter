<template>
  <table id="auftraege_table" class="compact">
    <thead>
      <tr>
        <th scope="col">Kunde</th>
        <th scope="col">Eingegangen</th>
        <th scope="col">Von</th>
        <th scope="col">Nach</th>
        <th scope="col">Status</th>
        <th scope="col">Aktionen</th>
      </tr>
    </thead>
    <tbody>
      <order_table_row
        v-bind:key="orderRow.id"
        v-for="orderRow in orderTableRows"
        :id="orderRow.id"
        :clientData="orderRow.clientData"
        :companyName="orderRow.companyName"
        :createdAt="orderRow.createdAt"
        :pickupCountry="orderRow.pickupCountry"
        :pickupPLZ="orderRow.pickupPLZ"
        :deliveryCountry="orderRow.deliveryCountry"
        :deliveryPLZ="orderRow.deliveryPLZ"
        :statusValue="orderRow.statusValue"
        :statusColor="orderRow.statusColor"
      ></order_table_row>
    </tbody>
  </table>
</template>

<script>
import order_table_row from "./order_table_row.vue";

export default {
  name: "order_table",
  props: ["order-table-rows"],
  data: function () {
    return {};
  },
  mounted: function () {
    window.onload = () => {
      this.orderTableRows = JSON.parse(localStorage.getItem("orderTableRows"));
    };
  },
  components: { order_table_row },
};
</script>

<style>
</style>