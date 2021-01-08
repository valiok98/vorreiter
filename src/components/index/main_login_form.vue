<template>
  <div id="component_main_login_form">
    <form method="POST" v-on:submit="login($event)">
      <div class="container">
        <div class="form-group row">
          <div class="col-lg-4">
            <label for="inputEmailUsername">E-Mail/<br />Benutzername:</label>
          </div>
          <div class="col-lg-8">
            <input
              type="text"
              class="form-control"
              id="inputEmailUsername"
              placeholder="E-Mail/Benutzername"
              v-model="inputEmailUsername"
            />
          </div>
        </div>
        <div class="form-group row">
          <div class="col-lg-4">
            <label for="inputPassword">Passwort:</label>
          </div>
          <div class="col-lg-8">
            <input
              type="password"
              class="form-control"
              id="inputPassword"
              placeholder="Passwort"
              v-model="inputPassword"
            />
          </div>
        </div>
        <div class="row">
          <div class="col-lg-2">
            <!-- Empty column. Do not delete. -->
          </div>
          <div class="form-check col-lg-5 div_remember_me">
            <input
              type="checkbox"
              class="form-check-input"
              id="inputRememberMe"
              name="erinnereDich"
              v-model="inputRememberMe"
            />
            <label class="form-check-label" for="inputRememberMe"
              >Erinnere dich</label
            >
          </div>
          <div class="col-lg-5 div_forgotten_pass">
            <change_password_modal></change_password_modal>
          </div>
        </div>
      </div>
      <b-button id="buttonSubmit" type="submit" variant="primary">
        LOGIN
      </b-button>
      <br />
    </form>

    <snackbar
      ref="snackbar"
      baseSize="100px"
      position="bottom-right"
    ></snackbar>
  </div>
</template>

<script>
import change_password_modal from "./change_password_modal.vue";
import Snackbar from "vuejs-snackbar";

export default {
  name: "client_modal",
  props: ["showClientModal", "clientType"],
  data: function () {
    return {
      inputEmailUsername: "",
      inputPassword: "",
      inputRememberMe: "",
    };
  },
  mounted: function () {
    let userNameEmail = this.getCookie("rememberMeCookie");
    if (userNameEmail) {
      this.inputEmailUsername = userNameEmail;
    }
  },
  methods: {
    login: function (e) {
      e.preventDefault();
      fetch(mainUrl + "index_content/login.php", {
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
          inputPassword: this.inputPassword,
          inputRememberMe: this.inputRememberMe,
        }),
      })
        .then((res) => res.json())
        .then((res) => {
          console.log(res);
          if (res.success) {
            window.location.replace(res.url);
          } else {
            this.$refs.snackbar.error(res.msg);
          }
        })
        .catch((err) => this.$refs.snackbar.error(err));
    },
    getCookie: function (cookieName) {
      let name = cookieName + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let ca = decodedCookie.split(";");
      for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == " ") {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    },
  },
  components: {
    change_password_modal,
    Snackbar,
  },
};
</script>

<style>
#component_main_login_form {
  font-size: 1em;
}

#component_main_login_form p,
#component_main_login_form label {
  display: inline-block;
}

#component_main_login_form .container {
  padding: 0;
  text-align: right;
}

#component_main_login_form .form-group {
  display: flex;
  align-items: center;
  justify-content: center;
}

#component_main_login_form .col-lg-4 {
  padding-right: 0;
}

#component_main_login_form .div_remember_me {
  text-align: right;
  padding: 0;
}

#component_main_login_form .div_forgotten_pass {
  position: static !important;
  padding: 0;
  text-align: center;
  cursor: pointer;
}

#component_main_login_form .div_forgotten_pass p {
  text-decoration: underline;
}

#component_main_login_form #buttonSubmit {
  display: block;
  margin: 0 auto;
}
</style>