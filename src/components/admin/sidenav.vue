<template>
  <div id="component_sidenav" class="col-sm-1">
    <nav class="navbar navbar-expand-lg navbar-light">
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#div_sidenav_collapsed"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="div_sidenav_collapsed" class="collapse navbar-collapse">
        <ul class="nav navbar-nav mr-auto flex-column" data-tabs="tabs">
          <li v-bind:key="navitem.id" class="nav-item" v-for="navitem in navitems">
            <a
              v-if="navitem.id === 0"
              class="nav-link active"
              v-bind:href="navitem.href"
              data-toggle="tab"
            >
              <img
                v-bind:id="navitem.img_id"
                v-bind:src="navitem.img_src"
                v-bind:alt="navitem.img_alt"
                v-on:click="toggleImgSrc(navitem.id)"
              />
            </a>
            <a v-else class="nav-link" v-bind:href="navitem.href" data-toggle="tab">
              <img
                v-if="navitem.bw"
                v-bind:id="navitem.img_id"
                v-bind:src="navitem.img_bw_src"
                v-bind:alt="navitem.img_alt"
                v-on:click="toggleImgSrc(navitem.id)"
              />
              <img
                v-else
                v-bind:id="navitem.img_id"
                v-bind:src="navitem.img_cl_src"
                v-bind:alt="navitem.img_alt"
                v-on:click="toggleImgSrc(navitem.id)"
              />
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: "sidenav",
  props: ["navitem"],
  data: function () {
    return {
      navitems: [
        {
          id: 0,
          bw: true,
          href: "#tab_vorreiter",
          img_id: "img_vorreiter",
          img_src: "img/vorreiter_logo.png",
          img_alt: "vorreiter",
        },
        {
          id: 1,
          bw: true,
          href: "#tab_clients",
          img_id: "img_clients",
          img_bw_src: "img/clients_b_w.png",
          img_cl_src: "img/clients_color.png",
          img_alt: "Kunden",
        },
        {
          id: 2,
          bw: true,
          href: "#tab_inq_ord_data",
          img_id: "img_inq_ord_data",
          img_bw_src: "img/inq_ord_b_w.png",
          img_cl_src: "img/inq_ord_color.png",
          img_alt: "Anfragen&Aufträge",
        },
        {
          id: 3,
          bw: true,
          href: "#tab_tracking",
          img_id: "img_tracking",
          img_bw_src: "img/tracking_b_w.png",
          img_cl_src: "img/tracking_color.png",
          img_alt: "Tracking",
        },
        {
          id: 4,
          bw: true,
          href: "#tab_fleet",
          img_id: "img_fleet",
          img_bw_src: "img/fleet_b_w.png",
          img_cl_src: "img/fleet_color.png",
          img_alt: "Flotte",
        },
        {
          id: 5,
          bw: true,
          href: "#tab_support",
          img_id: "img_support",
          img_bw_src: "img/support_b_w.png",
          img_cl_src: "img/support_color.png",
          img_alt: "Support",
        },
        {
          id: 6,
          bw: true,
          href: "#tab_stats",
          img_id: "img_stats",
          img_bw_src: "img/stats_b_w.png",
          img_cl_src: "img/stats_color.png",
          img_alt: "Stats",
        },
        {
          id: 7,
          bw: true,
          href: "#tab_settings",
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
};
</script>

<style>
#component_sidenav {
  border-right: 1px solid black;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}
#component_sidenav .navbar-toggler {
  margin: 5px auto 0 auto;
}
#component_sidenav nav {
  height: 100%;
  max-width: 100%;
  padding: 0;
}

#component_sidenav #div_sidenav_collapsed {
  max-height: 100%;
  height: 100%;
}

#component_sidenav a.nav-link {
  padding: 0 !important;
}

#component_sidenav a.nav-link img {
  display: block;
  margin: 0 auto;
}

#component_sidenav li:last-of-type {
  position: relative;
  bottom: 0;
  left: 0;
  right: 0;
}

#component_sidenav ul {
  height: 100%;
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  justify-content: center;
}

#component_sidenav li:first-of-type,
#component_sidenav li:last-of-type {
  flex: 1 1 0;
}

#component_sidenav li:last-of-type {
  display: flex;
  align-items: flex-end;
}

@media only screen and (max-width: 1013px) {
  #component_sidenav {
    border: none;
  }
}
</style>