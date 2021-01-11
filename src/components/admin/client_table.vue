<template>
  <div id="component_client_table">
    <table class="compact">
      <thead>
        <tr>
          <th scope="col">Firmenname</th>
          <th scope="col">Anrede</th>
          <th scope="col">Ansprechpartner</th>
          <th scope="col">Email</th>
          <th scope="col">Telefon</th>
          <th scope="col">Straße</th>
          <th scope="col">Hausnummer</th>
          <th scope="col">PLZ</th>
          <th scope="col">Ort</th>
          <th scope="col">Land</th>
          <th scope="col">Telefon(Zentrale)</th>
          <th scope="col">Notizen</th>
        </tr>
      </thead>
      <tbody v-if="!is_loading">
        <client_table_row
          v-bind:key="client_row.id"
          v-for="client_row in this.$store.state.clients"
          :id="client_row.id"
          :company_name="client_row.company_name"
          :salutation="client_row.salutation"
          :contact_person="client_row.contact_person"
          :email="client_row.email"
          :phone="client_row.phone"
          :street="client_row.street"
          :house_number="client_row.house_number"
          :postal_code="client_row.postal_code"
          :place="client_row.place"
          :country="client_row.country"
          :phone_central="client_row.phone_central"
          :additional_text="client_row.additional_text"
        ></client_table_row>
      </tbody>
      <tbody v-else>
        <tr id="tr_loading">
          <td></td>
          <td></td>
          <td></td>
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
import client_table_row from "./client_table_row.vue";
import Loading from "vue-loading-overlay";
import Snackbar from "vuejs-snackbar";

export default {
  name: "client_table",
  data: function () {
    return {
      client_table_rows: [],
      is_loading: true,
    };
  },
  mounted: async function () {
    // Check if we already loaded the clients from the previous components.
    if (!this.$store.state.clients.length) {
      try {
        let res = await fetch(mainUrl + "admin_content/ajax/find_clients.php", {
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
          this.$store.commit("set_clients", res.clients);
        } else {
          this.$store.commit("set_clients", []);
          this.$refs.snackbar.error(res.msg);
        }
      } catch (err) {
        this.$refs.snackbar.error(err);
      }
    } else {
      // If we already loaded the clients, then simply display them.
      this.is_loading = false;
    }
  },
  methods: {
    cancel_loading: function () {
      this.is_loading = false;
    },
  },
  components: { client_table_row, Loading, Snackbar },
};
</script>

<style>
#component_client_table,
#component_client_table table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0 15px;
}

#component_client_table table thead {
  background-color: #00cf65;
  text-align: center;
}
</style>
