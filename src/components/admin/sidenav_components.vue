<template>
  <div id="component_sidenav_components">
    <!-- mainnav component. -->
    <mainnav></mainnav>
    <div v-if="component_id === 'component_vorreiter'" class="container-fluid">
      <div class="row">
        <div class="col-lg-6 container-fluid">
          <div class="row div_table_header">
            <h3>Anfragen</h3>
            <div>
              <inquiry_theader></inquiry_theader>
            </div>
          </div>

          <div class="row div_inq_ord_table_data">
            <inquiry_table></inquiry_table>
          </div>
        </div>
        <div class="col-lg-6 container-fluid">
          <div class="row div_table_header">
            <h3>Aufträge</h3>
            <div>
              <order_theader></order_theader>
            </div>
          </div>
          <div class="row div_inq_ord_table_data">
            <order_table></order_table>
          </div>
        </div>
      </div>
    </div>
    <div v-else-if="component_id === 'component_clients'" class="container-fluid">
      <create_client_button></create_client_button>
      <client_table></client_table>
    </div>
    <div v-else-if="component_id === 'component_inq_ord'" class="container-fluid">
      <inquiry_order_theader></inquiry_order_theader>
      <div class="tab-content">
        <div id="div_inquiries" class="tab-pane active">
          <inquiry_table v-if="this.$store.state.inquiries.length"></inquiry_table>
        </div>
        <div id="div_orders" class="tab-pane">
          <order_table v-if="this.$store.state.orders.length"></order_table>
        </div>
      </div>
    </div>
    <div v-else-if="component_id === 'component_settings'" class="container-fluid">
      <!-- settings component. -->
      <settings></settings>
    </div>
    <div v-else-if="component_id === 'component_tracking'" class="container-fluid">
      <h1>Tracking</h1>
    </div>
    <div v-else-if="component_id === 'component_fleet'" class="container-fluid">
      <h1>Flotte</h1>
    </div>
    <div v-else-if="component_id === 'component_support'" class="container-fluid">
      <h1>Support</h1>
    </div>
    <div v-else-if="component_id === 'component_stats'" class="container-fluid">
      <h1>Stats</h1>
    </div>
  </div>
</template>

<script>
import mainnav from "./mainnav.vue";
import inquiry_table from "./inquiry_table.vue";
import order_table from "./order_table.vue";
import client_table from "./client_table.vue";
import create_client_button from "./create_client_button.vue";
import settings from "./settings.vue";

export default {
  name: "sidenav_components",
  props: ["component_id"],
  data: function () {
    return {};
  },
  components: {
    mainnav,
    inquiry_table,
    order_table,
    client_table,
    create_client_button,
    settings,
    
  },
};
</script>

<style>
#component_sidenav_components {
  height: 100vh;
  overflow-y: auto;
}
</style>
