<template>
  <div id="component_inquiry_table">
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
      <!-- Only render the rows if we're done loading & we have data to display. -->
      <tbody v-if="this.$store.state.inquiries.length && !is_loading">
        <inquiry_table_row
          v-bind:key="inquiry_row.id"
          v-for="inquiry_row in this.$store.state.inquiries"
          :id="inquiry_row.id"
          :client_data="inquiry_row.client_data"
          :packages="inquiry_row.packages"
          :created_at="inquiry_row.created_at"
          :pickup_country="inquiry_row.pickup_country"
          :pickup_postal_code="inquiry_row.pickup_postal_code"
          :delivery_country="inquiry_row.delivery_country"
          :delivery_postal_code="inquiry_row.delivery_postal_code"
          :status="inquiry_row.status"
          :status_color="inquiry_row.status_color"
        ></inquiry_table_row>
      </tbody>
      <!-- Render a 'no data available' message -->
      <tbody v-else-if="!this.$store.state.inquiries.length && !is_loading">
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td>Es gibt keine Anfragen</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
      <tbody v-else-if="is_loading">
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
import inquiry_table_row from "./inquiry_table_row.vue";
import Loading from "vue-loading-overlay";
import Snackbar from "vuejs-snackbar";

export default {
  name: "inquiry_table",
  data: function () {
    return {
      inquiry_table_rows: [],
      is_loading: true,
    };
  },
  mounted: async function () {
    // Check if we already loaded the inquiries from the previous components.
    if (!this.$store.state.inquiries.length) {
      try {
        let res = await fetch(mainUrl + "admin_content/ajax/find_inquiries.php", {
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
          this.$store.commit("set_inquiries", res.inquiries);
        } else {
          this.$store.commit("set_inquiries", []);
          this.$refs.snackbar.error(res.msg);
        }
      } catch (err) {
        this.$refs.snackbar.error(err);
      }
    } else {
      // If we already loaded the inquiries, then simply display them.
      this.is_loading = false;
    }
  },
  methods: {
    cancel_loading: function () {
      this.is_loading = false;
    },
  },
  components: { inquiry_table_row, Loading, Snackbar },
};
</script>

<style>
#component_inquiry_table,
#component_inquiry_table table {
  width: 100%;
}

#component_inquiry_table thead {
  background: lightgrey;
}

#component_inquiry_table tbody {
  margin-top: 15px;
  background: lightgrey;
}
</style>
