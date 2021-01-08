<template>
  <div id="component_order_detail">
    <img v-bind:src="img.src" v-bind:alt="img.alt" v-on:click="display_order()" />
    <order_detail_modal
      :show_order_detail_modal="show_order_detail_modal"
      :order_data="order_data"
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
        src: "img/eye.png",
        alt: "Auftrag anzeigen",
      },
      show_order_detail_modal: false,
      order_data: {},
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
          if (res.success && res.hasOwnProperty("order_data")) {
            // Configure the packages for the accordion component.
            let packages = res.order_data.packages;
            packages = packages.map((package_, index) => {
              return {
                ...package_,
                id: index,
                elemId: "collapse-" + index,
              };
            });
            // Set the packages back in the res object.
            res.order_data.packages = packages;
            this.order_data = res.order_data;
            this.show_order_detail_modal = true;
          } else {
            this.$refs.snackbar.error(res.msg);
          }
        })
        .catch((err) => this.$refs.snackbar.error(err));
    },
    close_order_detail_modal: function () {
      this.show_order_detail_modal = false;
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