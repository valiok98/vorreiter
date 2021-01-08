<template>
  <div id="component_change_password">
    <form id="form_change_password" v-on:submit="change_password($event)">
      <div class="container-fluid">
        <div class="row"><br /></div>
        <div class="row"><br /></div>
        <div class="row">
          <h6 class="text-muted">Hier können Sie Ihr Passwort ändern</h6>
        </div>
        <div class="row"><br /></div>
        <div class="row">
          <label for="input_email_username">E-Mail Adresse oder Benutzername</label>
          <input
            class="form-control mr-sm-2"
            id="input_email_username"
            type="search"
            placeholder="E-Mail/Benutzername ..."
            v-model="inputEmailUsername"
            required
          />
        </div>
        <div class="row"><br /></div>
        <div class="row">
          <label for="input_new_pass1">Neues Passwort</label>
          <input
            class="form-control mr-sm-2"
            id="input_new_pass1"
            type="password"
            placeholder="Neues Passwort ..."
            v-model="inputNewPass1"
            required
          />
        </div>
        <div class="row"><br /></div>
        <div class="row">
          <label for="input_new_pass2">Neues Passwort wiederholen</label>
          <input
            class="form-control mr-sm-2"
            id="input_new_pass2"
            type="password"
            placeholder="Neues Passwort wiederholen ..."
            v-model="inputNewPass2"
            required
          />
        </div>
        <div class="row"><br /></div>
        <div class="row"><br /></div>
        <div class="row">
          <vue-recaptcha
            sitekey="6LfzgfgZAAAAAFfjgpmEibLWHgn3Fdf0MG7jxa-c"
            v-on:verify="verify($event)"
            v-on:expired="captcha_expired()"
          >
          </vue-recaptcha>
        </div>
        <div class="row">
          <input type="hidden" v-model="inputRenewPassUrl" readonly />
        </div>
        <div class="row"><br /></div>
        <div class="row"><br /></div>
        <div class="row">
          <p v-if="inputNewPass1 !== inputNewPass2" style="color: red">
            Die Passwörter stimmen nicht überein.
          </p>
        </div>
        <div class="row">
          <b-button
            type="submit"
            value="abs"
            variant="success"
            class="btn btn-primary"
            v-bind:disabled="
              !inputEmailUsername.length ||
              !inputNewPass1 ||
              !inputNewPass2 ||
              !captchaSuccess ||
              inputNewPass1 !== inputNewPass2
            "
          >
            Ändern
          </b-button>
        </div>
        <div class="row"><br /></div>
      </div>
    </form>
    <snackbar
      ref="snackbar"
      baseSize="100px"
      position="bottom-right"
      holdTime="5000"
    ></snackbar>
  </div>
</template>

<script>
import Snackbar from "vuejs-snackbar";
import VueRecaptcha from "vue-recaptcha";

export default {
  name: "change_password",
  data: function () {
    return {
      inputEmailUsername: "",
      inputNewPass1: "",
      inputNewPass2: "",
      inputRenewPassUrl: "",
      captchaSuccess: false,
    };
  },
  mounted: function () {
    window.onload = () => {
      this.inputRenewPassUrl = localStorage.getItem("renewPassUrl");
    };
  },
  methods: {
    verify: function (response) {
      if (response) {
        this.captchaSuccess = true;
      }
    },
    captcha_expired: function () {
      this.captchaSuccess = false;
    },
    change_password: function (e) {
      e.preventDefault();
      if (
        this.inputEmailUsername.length &&
        this.inputNewPass1.length &&
        this.inputNewPass2.length &&
        this.captchaSuccess
      ) {
        // Send the request.
        fetch(mainUrl + "index_content/change_password/update_password.php", {
          method: "POST",
          dataType: "json",
          mode: "cors",
          credentials: "same-origin",
          headers: {
            "Access-Control-Allow-Origin": "*",
            Accept: "application/json;charset=UTF-8",
            "Content-Type": "application/json;charset=UTF-8",
          },
          body: JSON.stringify({
            inputEmailUsername: this.inputEmailUsername,
            inputNewPass1: this.inputNewPass1,
            inputNewPass2: this.inputNewPass2,
            inputRenewPassUrl: this.inputRenewPassUrl,
          }),
        })
          .then((res) => res.json())
          .then((res) => {
            console.log(res);
            if (res.success) {
              // Show the snackbar.
              this.$refs.snackbar.info("Das Passwort wurde erfolgreich erneuert.");
            } else {
              this.$refs.snackbar.error(res.msg);
            }
          })
          .catch((err) => this.$refs.snackbar.error(err));
      }
    },
  },
  components: {
    Snackbar,
    VueRecaptcha,
  },
};
</script>

<style></style>
