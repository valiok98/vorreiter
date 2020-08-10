<template>
  <div id="component_order_modal1">
    <modal v-if="showOrderModal1">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>Auftrag erstellen</h5>
                <button class="modal-default-button" v-on:click="close()">X</button>
              </div>
              <div class="modal-body">
                <form id="form_suche-auftrag-kunden" class="form-inline">
                  <input
                    v-on:keyup="search_client()"
                    class="form-control mr-sm-2"
                    type="search"
                    placeholder="Suche Kunden..."
                    aria-label="Search"
                    v-model="searchString"
                  />
                </form>
                <div v-if="searchString.trim()" id="div_suche-auftrag-ergebnisse">
                  <!-- Show the 'create client' entry only if the search string is not empty. -->
                  <div
                    v-bind:key="client.id"
                    v-for="client in clients"
                    v-on:click="select_client(client.value)"
                    class="div_auftrag-kunden-ergebnis"
                  >
                    <span v-text="client.title"></span>
                    <img v-bind:src="img_arrow_src" alt="Arrow" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </modal>
    <client_modal
      :showClientModal="showClientModal"
      :clientType="clientType"
      v-on:close_client_modal="close_client_modal()"
    ></client_modal>
    <order_modal2
      :clientData="clientData"
      :showOrderModal2="showOrderModal2"
      v-on:close_order_modal2="close_order_modal2()"
    ></order_modal2>
  </div>
</template>

<script>
import client_modal from "./client_modal.vue";
import order_modal2 from "./order_modal2.vue";

export default {
  name: "order_modal1",
  props: ["showOrderModal1"],
  data: function () {
    return {
      searchString: "",
      img_arrow_src: "../images/auftrag/auftrag_arrow.png",
      showClientModal: false,
      clientType: "order",
      showOrderModal2: false,
      clientData: [],
      clients: [{ id: 0, value: -1, title: "Neukunden erstellen" }],
    };
  },
  methods: {
    close: function () {
      this.searchString = "";
      this.showOrderModal1 = false;
      this.$emit("close_order_modal");
    },
    search_client: function () {
      let input = this.searchString.trim();
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
          body: JSON.stringify({ clientName: input }),
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
    select_client: function (clientId) {
      if (clientId === -1) {
        this.create_client();
      } else {
        // Load data for an existing client.
        this.create_order(clientId);
      }
    },
    create_client: function () {
      this.close();
      this.showClientModal = true;
    },
    create_order: function (clientId) {
      this.close();
      fetch(mainUrl + "admin_content/ajax/find_client_by_id.php", {
        method: "POST",
        dataType: "json",
        mode: "cors",
        credentials: "same-origin",
        headers: {
          "Access-Control-Allow-Origin": "*",
        },
        body: JSON.stringify({ clientId: clientId }),
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success && res.hasOwnProperty("clientData")) {
            let clientData = res.clientData;
            // Open the second inquiry modal.
            this.showOrderModal2 = true;
            this.clientData = {
              companyName: clientData.firmenname,
              contactPerson: clientData.ansprechpartner,
              clientId: clientData.id,
              phone: clientData.telefon,
              email: clientData.email,
            };
          }
        })
        .catch((err) => console.log(err));
    },
    close_client_modal: function () {
      this.showClientModal = false;
    },
    close_order_modal2: function () {
      this.showOrderModal2 = false;
    },
  },
  components: {
    client_modal,
    order_modal2,
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
  width: 50%;
  height: 90%;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
  border: none;
  background: none;
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
#component_order_modal1 {
  position: absolute;
}
#component_order_modal1 .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}
</style>