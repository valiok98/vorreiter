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
                        Bitte geben Sie Ihre E-Mail Adresse oder Ihren
                        Benutzernamen ein
                      </h5>
                    </div>
                    <div class="row"><br /></div>
                    <div class="row">
                      <div class="col-sm-12" style="padding: 0">
                        <form
                          id="form_change-password"
                          v-on:submit="change_password($event)"
                        >
                          <div class="container-fluid">
                            <div class="row">
                              <div
                                class="col-sm-4"
                                style="text-align: left; padding: 0"
                              >
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
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </transition>
      </modal>
    </div>
  </div>
</template>

<script>
import Snackbar from "vuejs-snackbar";

export default {
  name: "change_password_modal",
  data: function () {
    return {
      closeImg: {
        src: "images/modal/close_window.gif",
        alt: "Close modal",
      },
      showChangePasswordModal: false,
      inputEmailUsername: "",
    };
  },
  methods: {
    close: function () {
      this.showChangePasswordModal = false;
    },
    change_password: function (e) {
      e.preventDefault();
      // Close the window.
      this.close();
      // Send the request.
      fetch(
        mainUrl + "admin_content/ajax/change_password/change_password.php",
        {
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
        }
      )
        .then((res) => res.json())
        .then((res) => {
          console.log(res);
          if (res.success) {
            // Show the snackbar.
            this.$refs.snackbar.open(
              "Es wurde eine Email an die eingegebene E-Mail Adresse(oder Benutzername) gesendet."
            );
          } else {
            this.$refs.snackbar.error(res.msg);
          }
        })
        .catch((err) => this.$refs.snackbar.error(err));
    },
  },
  components: {
    Snackbar,
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