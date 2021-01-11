<template>
  <div id="component_search_results" v-if="show_search_results && search_term.length">
    <h5>Suchergebnisse</h5>
    <h5 v-if="!inquiries.length && !orders.length && !clients.length">
      Es gibt keine Ergebnisse zum Suchterm:&nbsp;"{{ search_term }}"
    </h5>
    <div v-else class="modal-container">
      <div v-if="inquiries.length" class="row">
        <div class="col-lg-12">
          <h5><b>Anfragen</b></h5>
        </div>
      </div>
      <div v-if="orders.length" class="row">
        <div class="col-lg-12">
          <h5><b>Aufträge</b></h5>
        </div>
      </div>
      <div v-if="clients.length" class="row">
        <div class="col-lg-12">
          <h5><b>Kunden</b></h5>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "search_results",
  props: ["search_term", "show_search_results"],
  data: function () {
    return {
      inquiries: [],
      orders: [],
      clients: [],
    };
  },
  methods: {
  },
};
</script>

<style>
</style>
