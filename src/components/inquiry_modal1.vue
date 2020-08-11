<template>
  <div id="component_inquiry_modal1">
    <modal v-if="showInquiryModal1">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>Anfrage erstellen</h5>
                <button class="modal-default-button" v-on:click="close()">X</button>
              </div>
              <div class="modal-body">
                <form id="form_suche-anfrage-kunden" class="form-inline">
                  <input
                    v-on:keyup="search_client()"
                    class="form-control mr-sm-2"
                    type="search"
                    placeholder="Suche Kunden..."
                    aria-label="Search"
                    v-model="searchString"
                  />
                </form>
                <div v-if="searchString.trim()" id="div_suche-anfrage-ergebnisse">
                  <!-- Show the 'create client' entry only if the search string is not empty. -->
                  <div
                    v-bind:key="client.id"
                    v-for="client in clients"
                    v-on:click="select_client(client.value)"
                    class="div_anfrage-kunden-ergebnis"
                  >
                    <span v-text="client.title"></span>
                    <img v-bind:src="imgArrowSrc" alt="Arrow" />
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
    <inquiry_modal2
      :clientData="clientData"
      :showInquiryModal2="showInquiryModal2"
      v-on:close_inquiry_modal2="close_inquiry_modal2()"
    ></inquiry_modal2>
  </div>
</template>

<script>
import client_modal from "./client_modal.vue";
import inquiry_modal2 from "./inquiry_modal2.vue";

export default {
  name: "inquiry_modal1",
  props: ["showInquiryModal1"],
  data: function () {
    return {
      searchString: "",
      imgArrowSrc: "../images/auftrag/auftrag_arrow.png",
      showClientModal: false,
      clientType: "inquiry",
      showInquiryModal2: false,
      clientData: [],
      clients: [{ id: 0, value: -1, title: "Neukunden erstellen" }],
    };
  },
  methods: {
    close: function () {
      this.searchString = "";
      this.showInquiryModal1 = false;
      this.$emit("close_inquiry_modal1");
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
        this.create_inquiry(clientId);
      }
    },
    create_client: function () {
      this.close();
      this.showClientModal = true;
    },
    create_inquiry: function (clientId) {
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
            this.close();
            this.showInquiryModal2 = true;
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
    close_inquiry_modal2: function () {
      this.showInquiryModal2 = false;
    },
  },
  components: {
    client_modal,
    inquiry_modal2,
  },
};
</script>

<style>
/* Component part. */
#component_inquiry_modal1 {
  position: absolute;
}

#component_inquiry_modal1 .modal-container {
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
</style>