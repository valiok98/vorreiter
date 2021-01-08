<template>
  <div id="component_change_password_modal">
    <p v-on:click="showChangePasswordModal = true">Passwort vergessen ?</p>
    <div>
      <modal v-if="showChangePasswordModal">
        <transition name="modal">
          <div class="modal-mask">
            <div class="modal-wrapper">
              <div class="modal-container">
                <div class="modal-header">
                  <h5>Passwort ändern</h5>
                  <button class="modal-default-button" v-on:click="close()">
                    <img v-bind:src="closeImg.src" v-bind:alt="closeImg.alt" />
                  </button>
                </div>
                <div class="modal-body">
                  <div class="container-fluid">
                    <div class="row">
                      <h5>
                        Bitte geben Sie Ihre E-Mail Adresse oder Ihren Benutzernamen ein
                      </h5>
                    </div>
                    <div class="row"><br /></div>
                    <div class="row">
                      <div class="col-sm-12" style="padding: 0">
                        <form
                          id="form_change_password"
                          v-on:submit="change_password($event)"
                        >
                          <div class="container-fluid">
                            <div class="row">
                              <div class="col-sm-4" style="text-align: left; padding: 0">
                                <label for="input_email_username"
                                  ><b
                                    >E-Mail Adresse<br />oder <br />
                                    Benutzername</b
                                  ></label
                                >
                              </div>
                              <div class="col-sm-8">
                                <input
                                  class="form-control mr-sm-2"
                                  id="input_email_username"
                                  type="search"
                                  placeholder="E-Mail/Benutzername"
                                  v-model="inputEmailUsername"
                                  required
                                />
                              </div>
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
                            <div class="row"><br /></div>
                            <div class="row"><br /></div>
                            <div class="row"><br /></div>
                            <div class="row">
                              <b-button
                                type="submit"
                                value="abs"
                                variant="success"
                                class="btn btn-primary"
                                v-bind:disabled="
                                  !inputEmailUsername.length || !captchaSuccess
                                "
                              >
                                Absenden
                              </b-button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </transition>
      </modal>
    </div>
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
  name: "change_password_modal",
  data: function () {
    return {
      closeImg: {
        src: "index_content/img/close_window.png",
        alt: "Close modal",
      },
      showChangePasswordModal: false,
      inputEmailUsername: "",
      captchaSuccess: false,
    };
  },
  methods: {
    document_close_event_listener: function (e) {
      if (e.key === "Escape") {
        this.close();
      }
    },
    verify: function (response) {
      if (response) {
        this.captchaSuccess = true;
      }
    },
    captcha_expired: function () {
      this.captchaSuccess = false;
    },
    close: function () {
      this.showChangePasswordModal = false;
      this.captchaSuccess = false;
      this.inputEmailUsername = "";
      document.body.removeEventListener("keyup", this.document_close_event_listener);
    },
    updated() {
      if (this.showChangePasswordModal) {
        console.log("adding EL");
        document.body.addEventListener("keyup", this.document_close_event_listener);
      }
    },
    change_password: function (e) {
      e.preventDefault();
      if (this.inputEmailUsername.length && this.captchaSuccess) {
        // Send the request.
        fetch(mainUrl + "index_content/change_password/change_password.php", {
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
          }),
        })
          .then((res) => res.json())
          .then((res) => {
            if (res.success) {
              // Show the snackbar.
              this.$refs.snackbar.info(
                "Eine Email wurde an die eingegebene E-Mail Adresse(oder Benutzername) gesendet.\r\nBitte checken Sie auch Ihre Spambox."
              );
            } else {
              this.$refs.snackbar.error(res.msg);
            }
          })
          .catch((err) => this.$refs.snackbar.error(err));
      }
      // Close the window.
      this.close();
    },
  },
  components: {
    Snackbar,
    VueRecaptcha,
  },
};
</script>

<style>
/* Component part. */
#component_change_password_modal {
  color: black;
  overflow-y: auto;
}

#component_change_password_modal > p {
  color: white;
}

#component_change_password_modal .modal-container {
  overflow-y: auto;
}

#component_change_password_modal .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}

#component_change_password_modal p {
  text-decoration: underline;
}

#component_change_password_modal modal {
  position: absolute;
}
</style>
