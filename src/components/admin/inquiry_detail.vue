<template>
  <div id="component_inquiry_detail">
    <img v-bind:src="img.src" v-bind:alt="img.alt" v-on:click="display_inquiry()" />
    <inquiry_detail_modal
      :show_inquiry_detail_modal="show_inquiry_detail_modal"
      :inquiry_data="inquiry_data"
      v-on:close_inquiry_detail_modal="close_inquiry_detail_modal()"
    ></inquiry_detail_modal>
    <snackbar ref="snackbar" baseSize="100px" position="bottom-right"></snackbar>
  </div>
</template>

<script>
import inquiry_detail_modal from "./inquiry_detail_modal.vue";
import Snackbar from "vuejs-snackbar";

export default {
  name: "inquiry_detail",
  props: ["id"],
  data: function () {
    return {
      img: {
        src: "img/eye.png",
        alt: "Anfrage anzeigen",
      },
      show_inquiry_detail_modal: false,
      inquiry_data: {},
    };
  },
  components: {
    inquiry_detail_modal,
    Snackbar,
  },
  methods: {
    display_inquiry: function () {
      fetch(mainUrl + "admin_content/ajax/find_inquiry_by_id.php", {
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
          if (res.success && res.hasOwnProperty("inquiry_data")) {
            // Configure the packages for the accordion component.
            let packages = res.inquiry_data.packages;
            packages = packages.map((package_, index) => {
              return {
                ...package_,
                id: index,
                elemId: "collapse-" + index,
              };
            });
            // Set the packages back in the res object.
            res.inquiry_data.packages = packages;
            this.inquiry_data = res.inquiry_data;
            this.show_inquiry_detail_modal = true;
          } else {
            this.$refs.snackbar.error(res.msg);
          }
        })
        .catch((err) => this.$refs.snackbar.error(err));
    },
    close_inquiry_detail_modal: function () {
      this.show_inquiry_detail_modal = false;
    },
  },
};
</script>

<style>
#component_inquiry_detail {
  display: flex;
  align-items: center;
  justify-content: center;
}

#component_inquiry_detail img {
  cursor: pointer;
}
</style>