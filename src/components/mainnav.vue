<template>
  <nav class='navbar navbar-expand-lg navbar-light main-nav'>
    <button
      class='navbar-toggler'
      type='button'
      data-toggle='collapse'
      data-target='#navbarSupportedContent'
      aria-controls='navbarSupportedContent'
      aria-expanded='false'
      aria-label='Toggle navigation'
    >
      <span class='navbar-toggler-icon'></span>
    </button>

    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
      <form class='form-inline'>
        <input
          class='form-control mr-sm-2'
          type='search'
          placeholder='Suche...'
          aria-label='Search'
        />
        <img id='img_suchen' v-bind:src='img_src.suchen' alt='suchen' />
      </form>
      <ul class='navbar-nav mr-auto'>
        <li id='li_angemeldet-als' class='nav-item'>
          <a href='#' class='nav-link'>
            <span v-text='angemeldetUsername'></span>
          </a>
        </li>
        <li class='nav-item'>
          <a href='#' class='nav-link'>
            <img alt='notifications' v-bind:src='img_src.notifications' />
          </a>
        </li>
        <li class='nav-item'>
          <a class='nav-link' v-bind:href='logoutHref'>
            <img alt='logout' v-bind:src='img_src.logout' />
            <span id='span_logout'>Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'mainnav',
  data: function () {
    return {
      angemeldetUsername: 'Angemeldet als: ' + username,
      logoutHref: mainUrl + 'logout.php',
      img_src: {
        suchen: '../images/navbar/suchen.png',
        notifications: '../images/navbar/notifications.png',
        logout: '../images/navbar/logout.png',
      },
    };
  },
};
</script>

<style>
</style>