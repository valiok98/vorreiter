<template>
  <div id="component_inquiry_dialog1">
    <modal v-if="showModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div id="dialog_anfrage-erstellen-1" class="modal-container">
              <div class="modal-header">
                <h5>Anfrage erstellen</h5>
                <button class="modal-default-button" v-on:click="close()">X</button>
              </div>
              <div class="modal-body">
                <form
                  v-on:keyup="search_client()"
                  id="form_suche-anfrage-kunden"
                  class="form-inline"
                >
                  <input
                    class="form-control mr-sm-2"
                    type="search"
                    placeholder="Suche Kunden..."
                    aria-label="Search"
                    v-model="search_string"
                  />
                </form>
                <div v-if="search_string.trim()" id="div_suche-anfrage-ergebnisse">
                  <!-- Show the 'create client' entry only if the search string is not empty. -->
                  <div
                    v-bind:key="client.id"
                    v-for="client in clients"
                    v-on:click="select_client(client.id)"
                    v-text="client.title"
                    class="div_anfrage-kunden-ergebnis"
                  ></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </modal>
  </div>
</template>

<script>
export default {
  name: "inquiry_dialog1",
  props: ["showModal"],
  data: function () {
    return {
      search_string: "",
      img_arrow_src: "../images/auftrag/auftrag_arrow.png",
      clients: [{ id: 0, value: -1, title: "Neukunden erstellen" }],
    };
  },
  methods: {
    close: function () {
      this.$emit("close_dialog");
    },
    search_client: function () {
      let input = this.search_string.trim();
      // Empty the search list if the input string is empty.
      if (input) {
        fetch(mainUrl + "admin_content/ajax/find_client_by_name.php", {
          method: "POST",
          dataType: "json",
          mode: "cors",
          credentials: "same-origin",
          headers: {
            "Access-Control-Allow-Origin": "*",
          },
          body: JSON.stringify({ client_name: input }),
        })
          .then((res) => res.json())
          .then((res) => {
            console.log(res);
            if (res.success && res.hasOwnProperty("clients")) {
              let clientData = res.clients;
              this.clients = this.clients.slice(0, 1);

              clientData.map((client, index) =>
                this.clients.push({
                  id: index + 1,
                  value: client.id,
                  title: [client.firmenname, client.plz, client.ort].join(" "),
                })
              );
              console.log(this.clients);
            }
          })
          .catch((err) => console.log(err));
      }
    },
    select_client: function (client_id) {
      console.log(client_id);
      if (client_id === -1) {
        // create_client(mainUrl, "anfrage");
      } else {
        // Load data for an existing client.
        // create_anfrage(mainUrl, clientID);
      }
    },
  },
};
</script>

<style>
/* Modal part. */
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
/* Component part. */
#component_inquiry_dialog1 {
  position: absolute;
}
#component_inquiry_dialog1 .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}
</style>