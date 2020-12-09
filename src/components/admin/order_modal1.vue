<template>
  <div id="component_order_modal1">
    <modal v-if="showOrderModal1">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>Auftrag erstellen</h5>
                <button class="modal-default-button" v-on:click="close()">
                  <img v-bind:src="closeImg.src" v-bind:alt="closeImg.alt" />
                </button>
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
                <div
                  v-if="searchString.trim()"
                  id="div_suche-auftrag-ergebnisse"
                >
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
      closeImg: {
        src: "../images/modal/close_window.gif",
        alt: "Close modal",
      },
    };
  },
  methods: {
    close: function () {
      this.searchString = "";
      this.showOrderModal1 = false;
      this.$emit("close_order_modal1");
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
            if (res.success && res.hasOwnProperty("clientData")) {
              let clientData = res.clientData;
              this.clients = this.clients.slice(0, 1);

              clientData.map((client, index) =>
                this.clients.push({
                  id: index + 1,
                  value: client.id,
                  title:
                    client.firmenname +
                    " (" +
                    client.ort +
                    ", " +
                    client.plz +
                    ")",
                })
              );
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
      fetch(mainUrl + "admin_content/ajax/find_client_by_id.php", {
        method: "POST",
        dataType: "json",
        mode: "cors",
        credentials: "same-origin",
        headers: {
          "Access-Control-Allow-Origin": "*",
        },
        body: JSON.stringify({ id: clientId }),
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success && res.hasOwnProperty("clientData")) {
            let clientData = res.clientData;
            // Open the second inquiry modal.
            this.close();
            this.showOrderModal2 = true;
            this.clientData = {
              companyName: clientData.firmenname,
              companyStreet: clientData.strasse,
              companyAddress: clientData.ort,
              clientNumber: clientData.id,
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