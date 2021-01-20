<template>
  <tr id="component_client_table_row">
    <td>{{ company_name }}</td>
    <td>{{ salutation }}</td>
    <td>{{ contact_person }}</td>
    <td>{{ email }}</td>
    <td>{{ phone }}</td>
    <td>{{ street }}</td>
    <td>{{ house_number }}</td>
    <td>{{ postal_code }}</td>
    <td>{{ place }}</td>
    <td>{{ country }}</td>
    <td>{{ phone_central }}</td>
    <td>{{ additional_text }}</td>
  </tr>
</template>

<script>
import moment from "moment";

export default {
  name: "client_table_row",
  props: [
    "id",
    "company_name",
    "salutation",
    "contact_person",
    "email",
    "phone",
    "street",
    "house_number",
    "postal_code",
    "place",
    "country",
    "phone_central",
    "additional_text",
  ],
  data: function () {
    return {
      clientImg: {
        src: "img/company_details.png",
        alt: "Firma",
      },
    };
  },
};
</script>

<style>
#component_client_table_row .td_actions {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
  justify-content: flex-start;
}
#component_client_table_row .td_actions img {
  cursor: pointer;
}
#component_client_table_row .component_client_invoice {
  display: none;
}
</style>
