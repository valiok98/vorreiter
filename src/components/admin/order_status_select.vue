<template>
  <div :id="componentId" class="component_order_status_select">
    <v-select
      v-if="show_status_select"
      :options="options"
      v-model="statusValue"
      placeholder=""
      v-on:input="option_change()"
    ></v-select>
  </div>
</template>

<script>
export default {
  name: "order_status_select",
  props: ["id", "statusValue", "show_status_select"],
  data: function () {
    return {
      options: [
        "offen",
        "ausstehend",
        "abgelehnt",
        "beauftragt",
        "abgeschlossen",
      ],
      componentId: "component_order_status_select_" + this.id,
    };
  },
  methods: {
    option_change: function () {
      this.show_status_select = false;
      console.log(this.statusValue);
      this.$emit("option_change", this.statusValue);
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
.component_order_status_select .offen {
  color: red;
}
.component_order_status_select .ausstehend {
  color: orange;
}
.component_order_status_select .abgelehnt {
  color: purple;
}
.component_order_status_select .beauftragt {
  color: green;
}
.component_order_status_select .abgeschlossen {
  color: black;
}
</style>