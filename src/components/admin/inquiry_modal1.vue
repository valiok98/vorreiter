<template>
  <div id="component_inquiry_modal1">
    <modal v-if="show_inquiry_modal1">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h5>Anfrage erstellen</h5>
                <button class="modal-default-button" v-on:click="close()">
                  <img v-bind:src="close_img.src" v-bind:alt="close_img.alt" />
                </button>
              </div>
              <div class="modal-body">
                <form
                  id="form_search_inquiry_clients"
                  class="form-inline"
                  v-on:submit="$event.preventDefault()"
                >
                  <input
                    v-on:keyup="search_client()"
                    class="form-control mr-sm-2"
                    type="search"
                    placeholder="Suche Kunden..."
                    aria-label="Search"
                    v-model="search_string"
                  />
                </form>
                <div v-if="search_string.trim()" id="div_search_inquiry_results">
                  <!-- Show the 'create client' entry only if the search string is not empty. -->
                  <div
                    v-bind:key="client.id"
                    v-for="client in clients"
                    v-on:click="select_client(client.id)"
                    class="div_inquiry_clients_result"
                  >
                    <span v-text="client.title"></span>
                    <img v-bind:src="arrow_img.src" v-bind:alt="arrow_img.alt" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </modal>
    <client_modal
      :show_client_modal="show_client_modal"
      :client_type="client_type"
      v-on:close_client_modal="close_client_modal()"
    ></client_modal>
    <inquiry_modal2
      :client_data="client_data"
      :show_inquiry_modal2="show_inquiry_modal2"
      v-on:close_inquiry_modal2="close_inquiry_modal2()"
    ></inquiry_modal2>
  </div>
</template>

<script>
import client_modal from "./client_modal.vue";
import inquiry_modal2 from "./inquiry_modal2.vue";

export default {
  name: "inquiry_modal1",
  props: ["show_inquiry_modal1"],
  data: function () {
    return {
      search_string: "",
      show_client_modal: false,
      client_type: "inquiry",
      show_inquiry_modal2: false,
      client_data: [],
      clients: [{ value: 0, id: -1, title: "Neukunden erstellen" }],
      close_img: {
        src: "img/close_window.png",
        alt: "Fenster schließen",
      },
      arrow_img: {
        src: "img/arrow.png",
        alt: "Pfeil",
      },
    };
  },
  methods: {
    close: function () {
      this.search_string = "";
      this.show_inquiry_modal1 = false;
      this.$emit("close_inquiry_modal1");
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
            if (res.success && res.hasOwnProperty("client_data")) {
              let client_data = res.client_data;
              this.clients = this.clients.slice(0, 1);

              client_data.map((client, index) =>
                this.clients.push({
                  value: index + 1,
                  id: client.id,
                  company_name: client.company_name,
                  contact_person: client.contact_person,
                  phone: client.phone,
                  email: client.email,
                  title:
                    client.company_name +
                    " (" +
                    client.place +
                    ", " +
                    client.postal_code +
                    ")",
                })
              );
            }
          })
          .catch((err) => console.error(err));
      }
    },
    select_client: function (client_id) {
      if (client_id === -1) {
        this.create_client();
      } else {
        // Load data for an existing client.
        this.create_inquiry(client_id);
      }
    },
    create_client: function () {
      this.close();
      this.show_client_modal = true;
    },
    create_inquiry: function (client_id) {
      let client_data = this.clients.find((client) => client.id === client_id);

      if (client_data) {
        // Open the second inquiry modal.
        this.close();
        this.show_inquiry_modal2 = true;
        this.client_data = {
          company_name: client_data.company_name,
          contact_person: client_data.contact_person,
          id: client_data.id,
          phone: client_data.phone,
          email: client_data.email,
        };
      }
    },
    close_client_modal: function () {
      this.show_client_modal = false;
    },
    close_inquiry_modal2: function () {
      this.show_inquiry_modal2 = false;
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

#component_inquiry_modal1 .modal-header {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
}

#component_inquiry_modal1 #form_search_inquiry_clients {
  margin-top: 5px;
  margin-left: 5px;
}

#component_inquiry_modal1 #div_search_inquiry_results {
  margin-top: 5px;
  margin-left: 5px;
  background-color: white;
  width: 50%;
  position: static !important;
  top: 0 !important;
  left: 0 !important;
  bottom: 0 !important;
  right: 0 !important;
}

#component_inquiry_modal1 .div_inquiry_clients_result:first-of-type {
  color: blue;
  font-weight: 900;
}

#component_inquiry_modal1 .div_inquiry_clients_result {
  padding: 6px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

#component_inquiry_modal1 .div_inquiry_clients_result:hover {
  background: lightgray;
}
</style>
