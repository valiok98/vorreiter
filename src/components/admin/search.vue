<template>
  <div id="component_search">
    <input
      class="form-control mr-sm-2"
      type="search"
      placeholder="Suche..."
      aria-label="Search"
      v-model="search_term"
      v-on:input="display_search_results()"
    />
    <img
      id="img_search"
      v-bind:src="img_search.src"
      v-bind:alt="img_search.alt"
      v-on:click="display_search_results()"
    />
    <search_results
      :show_search_results="show_search_results"
      :search_term="search_term"
    ></search_results>
  </div>
</template>

<script>
import search_results from "./search_results.vue";
export default {
  name: "search",
  data: function () {
    return {
      img_search: {
        src: "img/search.png",
        alt: "Suchen",
      },
      search_term: "",
      show_search_results: false,
    };
  },
  methods: {
    display_search_results: function () {
      this.show_search_results = true;
    },
  },
  components: {
    search_results,
  },
};
</script>

<style>
#component_search #img_search {
  cursor: pointer;
}
</style>
