<template>
  <div :id="componentId" class="component_order_status_select">
    <v-select
      v-if="showStatusSelect"
      :options="options"
      v-model="statusValue"
      placeholder="Hello world"
      v-on:input="optionChange()"
    ></v-select>
  </div>
</template>

<script>
export default {
  name: "order_status_select",
  props: ["id", "statusValue", "showStatusSelect"],
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
      placeholder: "hello world"
    };
  },
  methods: {
    optionChange: function () {
      this.showStatusSelect = false;
      console.log(this.statusValue);
      this.$emit("optionChange", this.statusValue);
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