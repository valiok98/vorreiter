<template>
  <nav id="component_mainnav" class="navbar navbar-expand-lg navbar-light main-nav">
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#div_navbar_supported_content"
      aria-controls="div_navbar_supported_content"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="div_navbar_supported_content">
      <form class="form-inline">
        <input
          class="form-control mr-sm-2"
          type="search"
          placeholder="Suche..."
          aria-label="Search"
        />
        <img id="img_search" v-bind:src="search_img.src" v-bind:alt="search_img.alt" />
        <ul class="navbar-nav mr-auto">
          <li id="li_loggedin_as" class="nav-item">
            <a href="#" class="nav-link">
              <span v-text="logged_in_username"></span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <img
                v-bind:alt="notifications_img.alt"
                v-bind:src="notifications_img.src"
              />
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" v-bind:href="logout_href">
              <img v-bind:alt="logout_img.alt" v-bind:src="logout_img.src" />
              <span id="span_logout">Logout</span>
            </a>
          </li>
        </ul>
      </form>
    </div>
  </nav>
</template>

<script>
export default {
  name: "mainnav",
  data: function () {
    return {
      logged_in_username: "Angemeldet als: " + username,
      logout_href: mainUrl + "index_content/logout.php",
      search_img: {
        src: "img/search.png",
        alt: "Suchen",
      },
      notifications_img: {
        src: "img/notifications.png",
        alt: "Benachrichtigungen",
      },
      logout_img: {
        src: "img/logout.png",
        alt: "Ausloggen",
      },
    };
  },
};
</script>

<style>
#component_mainnav ul.navbar-nav {
  position: absolute;
  right: 0;
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
  justify-content: center;
}

#component_mainnav #li_loggedin_as {
  display: flex;
  align-items: center;
  justify-content: center;
}

#component_mainnav #li_loggedin_as a {
  all: unset;
}

#component_mainnav #span_logout {
  margin-left: -15%;
}

#component_mainnav #img_search {
  cursor: pointer;
}
</style>
