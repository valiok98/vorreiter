<template>
  <div id="component_search_modal">
    <modal v-if="show_search_modal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>Suchergebnisse</h5>
                <button class="modal-default-button" v-on:click="close()">
                  <img v-bind:src="close_img.src" v-bind:alt="close_img.alt" />
                </button>
              </div>
              <div class="modal-body">
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
            </div>
          </div>
        </div>
      </transition>
    </modal>
  </div>
</template>

<script>
export default {
  name: "search_modal",
  props: ["search_term", "show_search_modal"],
  data: function () {
    return {
      inquiries: [],
      orders: [],
      clients: [],
      close_img: {
        src: "img/close_window.png",
        alt: "Fenster schließen",
      },
    };
  },
  methods: {
    close: function () {
      this.show_search_modal = false;
      this.$emit("close_search_modal");
    },
  },
};
</script>

<style>
#component_search_modal .modal-container {
  overflow-y: auto;
  width: 75%;
  height: 90%;
}

#component_search_modal .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}
</style>
