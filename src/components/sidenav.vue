<template>
  <div id='div_sidenav' class='col-sm-1'>
    <nav class='navbar navbar-expand-lg navbar-light'>
      <button
        class='navbar-toggler'
        type='button'
        data-toggle='collapse'
        data-target='#div_sidenav-collapsed'
        aria-controls='navbarSupportedContent'
        aria-expanded='false'
        aria-label='Toggle navigation'
      >
        <span class='navbar-toggler-icon'></span>
      </button>
      <div id='div_sidenav-collapsed' class='collapse navbar-collapse'>
        <ul class='nav navbar-nav mr-auto flex-column' data-tabs='tabs'>
          <li v-bind:key='navitem.id' class='nav-item' v-for='navitem in navitems'>
            <a
              v-if='navitem.id === 0'
              class='nav-link active'
              v-bind:href='navitem.href'
              data-toggle='tab'
            >
              <img
                v-bind:id='navitem.img_id'
                v-bind:src='navitem.img_src'
                v-bind:alt='navitem.img_alt'
                v-on:click='toggleImgSrc(navitem.id)'
              />
            </a>
            <a v-else class='nav-link' v-bind:href='navitem.href' data-toggle='tab'>
              <img
                v-if='navitem.bw'
                v-bind:id='navitem.img_id'
                v-bind:src='navitem.img_bw_src'
                v-bind:alt='navitem.img_alt'
                v-on:click='toggleImgSrc(navitem.id)'
              />
              <img
                v-else
                v-bind:id='navitem.img_id'
                v-bind:src='navitem.img_cl_src'
                v-bind:alt='navitem.img_alt'
                v-on:click='toggleImgSrc(navitem.id)'
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
  name: 'sidenav',
  props: ['navitem'],
  data: function () {
    return {
      navitems: [
        {
          id: 0,
          bw: true,
          href: '#vorreiter',
          img_id: 'img_vorreiter',
          img_src: '../images/navbar/vorreiter_logo.png',
          img_alt: 'vorreiter',
        },
        {
          id: 1,
          bw: true,
          href: '#kunden',
          img_id: 'img_kunden',
          img_bw_src: '../images/navbar/kunden_b_w.png',
          img_cl_src: '../images/navbar/kunden_color.png',
          img_alt: 'kunden',
        },
        {
          id: 2,
          bw: true,
          href: '#an_auf_data',
          img_id: 'img_an_auf_data',
          img_bw_src: '../images/navbar/an_auf_b_w.png',
          img_cl_src: '../images/navbar/an_auf_color.png',
          img_alt: 'an_auf_data',
        },
        {
          id: 3,
          bw: true,
          href: '#tracking',
          img_id: 'img_tracking',
          img_bw_src: '../images/navbar/tracking_b_w.png',
          img_cl_src: '../images/navbar/tracking_color.png',
          img_alt: 'tracking',
        },
        {
          id: 4,
          bw: true,
          href: '#flotte',
          img_id: 'img_flotte',
          img_bw_src: '../images/navbar/flotte_b_w.png',
          img_cl_src: '../images/navbar/flotte_color.png',
          img_alt: 'flotte',
        },
        {
          id: 5,
          bw: true,
          href: '#support',
          img_id: 'img_support',
          img_bw_src: '../images/navbar/support_b_w.png',
          img_cl_src: '../images/navbar/support_color.png',
          img_alt: 'support',
        },
        {
          id: 6,
          bw: true,
          href: '#stats',
          img_id: 'img_stats',
          img_bw_src: '../images/navbar/stats_b_w.png',
          img_cl_src: '../images/navbar/stats_color.png',
          img_alt: 'stats',
        },
        {
          id: 7,
          bw: true,
          href: '#settings',
          img_id: 'img_settings',
          img_bw_src: '../images/navbar/settings_b_w.png',
          img_cl_src: '../images/navbar/settings_color.png',
          img_alt: 'settings',
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
#div_sidenav {
  border-right: 1px solid black;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

#div_sidenav nav {
  height: 100%;
  max-width: 100%;
  padding: 0;
}

#div_sidenav-collapsed {
  max-height: 100%;
  height: 100%;
}

#div_sidenav a.nav-link {
  padding: 0 !important;
}

#div_sidenav a.nav-link img {
  display: block;
  margin: 0 auto;
}

#div_sidenav li:last-of-type {
  position: relative;
  bottom: 0;
  left: 0;
  right: 0;
}

#div_sidenav ul {
  height: 100%;
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  justify-content: center;
}

#div_sidenav li:first-of-type,
li:last-of-type {
  flex: 1 1 0;
}

#div_sidenav li:last-of-type {
  display: flex;
  align-items: flex-end;
}

/* 1012.800 */
@media only screen and (max-width: 1013px) {
  #div_sidenav {
    border: none;
  }
}
</style>