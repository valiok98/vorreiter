<template>
  <div id="component_change_password">
    <form id="form_change-password" v-on:submit="change_password($event)">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-4" style="text-align: left; padding: 0">
            <label for="input_email-username"
              ><b
                >E-Mail Adresse<br />oder <br />
                Benutzername</b
              ></label
            >
          </div>
          <div class="col-sm-8">
            <input
              class="form-control mr-sm-2"
              id="input_email-username"
              type="search"
              placeholder="E-Mail/Benutzername"
              v-model="inputEmailUsername"
            />
          </div>
        </div>
        <!-- Try including captcha here. -->

        <!-- <script
                              src="https://www.google.com/recaptcha/api.js"
                              async
                              defer
                            ></script>
                            <div
                              class="g-recaptcha"
                              data-sitekey="6LfzgfgZAAAAAFfjgpmEibLWHgn3Fdf0MG7jxa-c"
                            ></div> -->
        <div class="row"><br /></div>
        <div class="row"><br /></div>
        <div class="row"><br /></div>
        <div class="row">
          <b-button
            type="submit"
            value="abs"
            variant="success"
            class="btn btn-primary"
            v-bind:disabled="!inputEmailUsername.length"
          >
            Absenden
          </b-button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import Snackbar from "vuejs-snackbar";

export default {
  name: "change_password",
  data: function () {
    return {};
  },
  components: {
    Snackbar,
  },
};
</script>

<style></style>
