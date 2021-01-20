<template>
  <div id="component_admin_content">
    <b-tabs vertical lazy fill>
      <!-- Vorreiter tab. -->
      <b-tab active>
        <template #title>
          <img
            v-bind:id="navitems[0].img_id"
            v-bind:src="navitems[0].img_src"
            v-bind:alt="navitems[0].img_alt"
            v-on:click="toggleImgSrc(navitems[0].id)"
          />
        </template>
        <sidenav_components :component_id="navitems[0].component_id"></sidenav_components>
      </b-tab>
      <!-- Clients tab. -->
      <b-tab>
        <template #title>
          <img
            v-if="navitems[1].bw"
            v-bind:id="navitems[1].img_id"
            v-bind:src="navitems[1].img_bw_src"
            v-bind:alt="navitems[1].img_alt"
            v-on:click="toggleImgSrc(navitems[1].id)"
          />
          <img
            v-else
            v-bind:id="navitems[1].img_id"
            v-bind:src="navitems[1].img_cl_src"
            v-bind:alt="navitems[1].img_alt"
            v-on:click="toggleImgSrc(navitems[1].id)"
          />
        </template>
        <sidenav_components :component_id="navitems[1].component_id"></sidenav_components>
      </b-tab>
      <!-- Inquiries & orders tab. -->
      <b-tab>
        <template #title>
          <img
            v-if="navitems[2].bw"
            v-bind:id="navitems[2].img_id"
            v-bind:src="navitems[2].img_bw_src"
            v-bind:alt="navitems[2].img_alt"
            v-on:click="toggleImgSrc(navitems[2].id)"
          />
          <img
            v-else
            v-bind:id="navitems[2].img_id"
            v-bind:src="navitems[2].img_cl_src"
            v-bind:alt="navitems[2].img_alt"
            v-on:click="toggleImgSrc(navitems[2].id)"
          />
        </template>
        <sidenav_components :component_id="navitems[2].component_id"></sidenav_components>
      </b-tab>
      <!-- Tracking tab. -->
      <b-tab>
        <template #title>
          <img
            v-if="navitems[3].bw"
            v-bind:id="navitems[3].img_id"
            v-bind:src="navitems[3].img_bw_src"
            v-bind:alt="navitems[3].img_alt"
            v-on:click="toggleImgSrc(navitems[3].id)"
          />
          <img
            v-else
            v-bind:id="navitems[3].img_id"
            v-bind:src="navitems[3].img_cl_src"
            v-bind:alt="navitems[3].img_alt"
            v-on:click="toggleImgSrc(navitems[3].id)"
          />
        </template>
        <sidenav_components :component_id="navitems[3].component_id"></sidenav_components>
      </b-tab>
      <!-- Fleet tab. -->
      <b-tab>
        <template #title>
          <img
            v-if="navitems[4].bw"
            v-bind:id="navitems[4].img_id"
            v-bind:src="navitems[4].img_bw_src"
            v-bind:alt="navitems[4].img_alt"
            v-on:click="toggleImgSrc(navitems[4].id)"
          />
          <img
            v-else
            v-bind:id="navitems[4].img_id"
            v-bind:src="navitems[4].img_cl_src"
            v-bind:alt="navitems[4].img_alt"
            v-on:click="toggleImgSrc(navitems[4].id)"
          />
        </template>
        <sidenav_components :component_id="navitems[4].component_id"></sidenav_components>
      </b-tab>
      <!-- Support tab. -->
      <b-tab>
        <template #title>
          <img
            v-if="navitems[5].bw"
            v-bind:id="navitems[5].img_id"
            v-bind:src="navitems[5].img_bw_src"
            v-bind:alt="navitems[5].img_alt"
            v-on:click="toggleImgSrc(navitems[5].id)"
          />
          <img
            v-else
            v-bind:id="navitems[5].img_id"
            v-bind:src="navitems[5].img_cl_src"
            v-bind:alt="navitems[5].img_alt"
            v-on:click="toggleImgSrc(navitems[5].id)"
          />
        </template>
        <sidenav_components :component_id="navitems[5].component_id"></sidenav_components>
      </b-tab>
      <!-- Stats tab. -->
      <b-tab>
        <template #title>
          <img
            v-if="navitems[6].bw"
            v-bind:id="navitems[6].img_id"
            v-bind:src="navitems[6].img_bw_src"
            v-bind:alt="navitems[6].img_alt"
            v-on:click="toggleImgSrc(navitems[6].id)"
          />
          <img
            v-else
            v-bind:id="navitems[6].img_id"
            v-bind:src="navitems[6].img_cl_src"
            v-bind:alt="navitems[6].img_alt"
            v-on:click="toggleImgSrc(navitems[6].id)"
          />
        </template>
        <sidenav_components :component_id="navitems[6].component_id"></sidenav_components>
      </b-tab>

      <!-- Settings tab. -->
      <b-tab>
        <template #title>
          <img
            v-if="navitems[7].bw"
            v-bind:id="navitems[7].img_id"
            v-bind:src="navitems[7].img_bw_src"
            v-bind:alt="navitems[7].img_alt"
            v-on:click="toggleImgSrc(navitems[7].id)"
          />
          <img
            v-else
            v-bind:id="navitems[7].img_id"
            v-bind:src="navitems[7].img_cl_src"
            v-bind:alt="navitems[7].img_alt"
            v-on:click="toggleImgSrc(navitems[7].id)"
          />
        </template>
        <sidenav_components :component_id="navitems[7].component_id"></sidenav_components>
      </b-tab>
    </b-tabs>
  </div>
</template>

<script>
import sidenav_components from "./sidenav_components.vue";

export default {
  name: "admin_content",
  data: function () {
    return {
      navitems: [
        {
          id: 0,
          bw: true,
          component_id: "component_vorreiter",
          img_id: "img_vorreiter",
          img_src: "img/vorreiter_logo.png",
          img_alt: "Vorreiter",
        },
        {
          id: 1,
          bw: true,
          component_id: "component_clients",
          img_id: "img_clients",
          img_bw_src: "img/clients_b_w.png",
          img_cl_src: "img/clients_color.png",
          img_alt: "Kunden",
        },
        {
          id: 2,
          bw: true,
          component_id: "component_inq_ord",
          img_id: "img_inq_ord_data",
          img_bw_src: "img/inq_ord_b_w.png",
          img_cl_src: "img/inq_ord_color.png",
          img_alt: "Anfragen&Aufträge",
        },
        {
          id: 3,
          bw: true,
          component_id: "component_tracking",
          img_id: "img_tracking",
          img_bw_src: "img/tracking_b_w.png",
          img_cl_src: "img/tracking_color.png",
          img_alt: "Tracking",
        },
        {
          id: 4,
          bw: true,
          component_id: "component_fleet",
          img_id: "img_fleet",
          img_bw_src: "img/fleet_b_w.png",
          img_cl_src: "img/fleet_color.png",
          img_alt: "Flotte",
        },
        {
          id: 5,
          bw: true,
          component_id: "component_support",
          img_id: "img_support",
          img_bw_src: "img/support_b_w.png",
          img_cl_src: "img/support_color.png",
          img_alt: "Support",
        },
        {
          id: 6,
          bw: true,
          component_id: "component_stats",
          img_id: "img_stats",
          img_bw_src: "img/stats_b_w.png",
          img_cl_src: "img/stats_color.png",
          img_alt: "Stats",
        },
        {
          id: 7,
          bw: true,
          component_id: "component_settings",
          img_id: "img_settings",
          img_bw_src: "img/settings_b_w.png",
          img_cl_src: "img/settings_color.png",
          img_alt: "Einstellungen",
        },
      ],
    };
  },
  methods: {
    toggleImgSrc: function (imgId) {
      this.navitems = this.navitems.map((navitem) => {
        if (navitem.id === imgId) {
          navitem.bw = false;
        } else {
          navitem.bw = true;
        }
        return navitem;
      });
    },
  },
  mounted: function () {
    this.$el.querySelector("tabs>div:nth-of-type(1)").classList.add("col-lg-1");
    this.$el.querySelector("tabs>div:nth-of-type(2)").classList.add("col-lg-11");
  },
  components: {
    sidenav_components,
  },
};
</script>

<style>
#component_admin_content .nav {
  height: 100vh;
  border-right: 1px solid black;
  display: flex;
  flex-flow: column nowrap;
  justify-content: space-between;
}
#component_admin_content a.nav-link {
  padding: 0;
}

@media only screen and (max-width: 1013px) {
  #component_sidenav {
    border: none;
  }
}
</style>
