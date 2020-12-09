<template>
  <div id="component_inquiry_order_theader">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a
          class="nav-link active"
          href="#anfragen"
          data-toggle="tab"
          v-on:click="activate_inquiry()"
        >
          <h4>Anfragen</h4>
          <span>&nbsp;&nbsp;</span>
        </a>
        <inquiry_theader v-if="inquiryActive" class="activeCreateButton"></inquiry_theader>
        <inquiry_theader v-else></inquiry_theader>
      </li>
      <span class="span_white-space">&nbsp;</span>
      <li class="nav-item">
        <a class="nav-link" href="#auftraege" data-toggle="tab" v-on:click="activate_order()">
          <h4>Aufträge</h4>
          <span>&nbsp;&nbsp;</span>
        </a>
        <order_theader v-if="orderActive" class="activeCreateButton"></order_theader>
        <order_theader v-else></order_theader>
      </li>
      <li class="nav-item"></li>
    </ul>
  </div>
</template>

<script>
import inquiry_theader from "./inquiry_theader.vue";
import order_theader from "./order_theader.vue";

export default {
  name: "inquiry_order_theader",
  data: function () {
    return {
      inquiryActive: true,
      orderActive: false,
    };
  },
  components: {
    inquiry_theader,
    order_theader,
  },
  methods: {
    activate_inquiry: function () {
      this.inquiryActive = true;
      this.orderActive = false;
    },
    activate_order: function () {
      this.orderActive = true;
      this.inquiryActive = false;
    },
  },
};
</script>

<style>
#component_inquiry_order_theader .nav-link {
  font-weight: 900;
  color: black;
  border: none;
  border-radius: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  padding-right: 0;
  height: 100%;
}

#component_inquiry_order_theader .nav-item {
  display: flex;
  align-items: center;
  justify-content: center;
}

#component_inquiry_order_theader .nav-item h4 {
  margin: 0;
  padding: 0;
}

#component_inquiry_order_theader .span_white-space {
  background-color: white;
}

#component_inquiry_order_theader .nav-item:last-child {
  background-color: white;
}

#component_inquiry_order_theader .active,
#component_inquiry_order_theader .activeCreateButton {
  background-color: #00cf65;
}
</style>