<template>
  <div :id="component_id" class="component_order_status_select">
    <v-select
      v-if="show_status_select"
      :options="options"
      v-model="status_value"
      placeholder=""
      v-on:input="option_change()"
    ></v-select>
  </div>
</template>

<script>
export default {
  name: "order_status_select",
  props: ["id", "status_value", "show_status_select"],
  data: function () {
    return {
      options: [
        "offen",
        "ausstehend",
        "beauftragt",
        "in Auslieferung",
        "ausgeliefert",
        "abgeschlossen",
        "fakturiert",
        "abgelehnt",
        "beschädigt",
        "Retoure",
      ],
      component_id: "component_order_status_select_" + this.id,
    };
  },
  methods: {
    option_change: function () {
      this.show_status_select = false;
      this.$emit("option_change", this.status_value);
    },
  },
};
</script>

<style>
.component_order_status_select .vs__clear {
  display: none;
}
.component_order_status_select span {
  margin: 0;
  text-align: center;
}
</style>
