<template>
  <div id="component_search">
    <input
      class="form-control mr-sm-2"
      type="search"
      placeholder="Suche..."
      aria-label="Search"
      v-model="search_term"
    />
    <img
      id="img_search"
      v-bind:src="img_search.src"
      v-bind:alt="img_search.alt"
      v-on:click="display_search_results()"
    />
    <search_modal
      :show_search_modal="show_search_modal"
      :search_term="search_term"
      v-on:close_search_modal="close_search_modal()"
    ></search_modal>
  </div>
</template>

<script>
import search_modal from "./search_modal.vue";
export default {
  name: "search",
  data: function () {
    return {
      img_search: {
        src: "img/search.png",
        alt: "Suchen",
      },
      search_term: "",
      show_search_modal: false,
    };
  },
  methods: {
    display_search_results: function () {
      this.show_search_modal = true;
    },
    close_search_modal: function () {
      this.show_search_modal = false;
    },
  },
  components: {
    search_modal,
  },
};
</script>

<style>
#component_search #img_search {
  cursor: pointer;
}
</style>
