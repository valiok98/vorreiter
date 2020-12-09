<template>
  <div id="component_order_detail">
    <img v-bind:src="img.src" v-bind:alt="img.alt" v-on:click="display_order()" />
    <order_detail_modal
      :showOrderDetailModal="showOrderDetailModal"
      :orderData="orderData"
      v-on:close_order_detail_modal="close_order_detail_modal()"
    ></order_detail_modal>
    <snackbar ref="snackbar" baseSize="100px" position="bottom-right"></snackbar>
  </div>
</template>

<script>
import order_detail_modal from "./order_detail_modal.vue";
import Snackbar from "vuejs-snackbar";

export default {
  name: "order_detail",
  props: ["id"],
  data: function () {
    return {
      img: {
        src: "../images/an_auf_table/eye.png",
        alt: "View entry",
      },
      showOrderDetailModal: false,
      orderData: {},
    };
  },
  components: {
    order_detail_modal,
    Snackbar,
  },
  methods: {
    display_order: function () {
      fetch(mainUrl + "admin_content/ajax/find_order_by_id.php", {
        method: "POST",
        dataType: "json",
        mode: "cors",
        credentials: "same-origin",
        headers: {
          "Access-Control-Allow-Origin": "*",
        },
        body: JSON.stringify({
          id: this.id,
        }),
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success && res.hasOwnProperty("orderData")) {
            // Configure the packages for the accordion component.
            let packages = res.orderData.packages;
            packages = packages.map((package_, index) => {
              return {
                ...package_,
                id: index,
                elemId: "collapse-" + index,
              };
            });
            // Set the packages back in the res object.
            res.orderData.packages = packages;
            this.orderData = res.orderData;
            this.showOrderDetailModal = true;
          } else {
            this.$refs.snackbar.error(
              "Der Auftrag konnte nicht gefunden werden."
            );
          }
        })
        .catch((err) => this.$refs.snackbar.error(err));
    },
    close_order_detail_modal: function () {
      this.showOrderDetailModal = false;
    },
  },
};
</script>

<style>
#component_order_detail {
  display: inline-block;
}

#component_order_detail img {
  cursor: pointer;
}
</style>