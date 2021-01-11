<template>
  <div id="component_order_table">
    <table class="compact">
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
      <tbody v-if="!is_loading">
        <order_table_row
          v-bind:key="order_row.id"
          v-for="order_row in this.$store.state.orders"
          :id="order_row.id"
          :client_data="order_row.client_data"
          :packages="order_row.packages"
          :created_at="order_row.created_at"
          :pickup_country="order_row.pickup_country"
          :pickup_postal_code="order_row.pickup_postal_code"
          :delivery_country="order_row.delivery_country"
          :delivery_postal_code="order_row.delivery_postal_code"
          :status="order_row.status"
          :status_color="order_row.status_color"
        ></order_table_row>
      </tbody>
      <tbody v-else>
        <tr id="tr_loading">
          <td></td>
          <td></td>
          <td></td>
          <td>
            <loading
              :active.sync="is_loading"
              :can-cancel="true"
              :on-cancel="cancel_loading"
              :is-full-page="false"
            ></loading>
          </td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
    <snackbar ref="snackbar" baseSize="100px" position="bottom-right"></snackbar>
  </div>
</template>

<script>
import order_table_row from "./order_table_row.vue";
import Loading from "vue-loading-overlay";
import Snackbar from "vuejs-snackbar";

export default {
  name: "order_table",
  data: function () {
    return {
      order_table_rows: [],
      is_loading: true,
    };
  },
  mounted: async function () {
    // Check if we already loaded the orders from the previous components.
    if (!this.$store.state.orders.length) {
      try {
        let res = await fetch(mainUrl + "admin_content/ajax/find_orders.php", {
          method: "POST",
          dataType: "json",
          mode: "cors",
          credentials: "same-origin",
          headers: {
            "Access-Control-Allow-Origin": "*",
          },
        });

        res = await res.json();
        this.is_loading = false;
        if (res.success) {
          this.$store.commit("set_orders", res.orders);
        } else {
          this.$store.commit("set_orders", []);
          this.$refs.snackbar.error(res.msg);
        }
      } catch (err) {
        this.$refs.snackbar.error(err);
      }
    } else {
      // If we already loaded the orders, then simply display them.
      this.is_loading = false;
    }
  },
  methods: {
    cancel_loading: function () {
      this.is_loading = false;
    },
  },
  components: { order_table_row, Loading, Snackbar },
};
</script>

<style>
#component_order_table,
#component_order_table table {
  width: 100%;
}
</style>
