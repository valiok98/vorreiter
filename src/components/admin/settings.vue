<template>
  <div>
    <ul class="nav nav-tabs" data-tabs="tabs">
      <li class="nav-item">
        <a class="nav-link active" href="#sysestlg_rechnung" data-toggle="tab">Rechnungslayout</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#sysestlg_steuersatz" data-toggle="tab">Steuersatz</a>
      </li>
    </ul>
    <br />
    <div class="tab-content">
      <div class="tab-pane active" id="sysestlg_rechnung">
        <form
          id="rechnungslayout"
          action="ajax/create_rechnung.php"
          method="POST"
          enctype="multipart/form-data"
        >
          <div class="custom-file">
            <input
              type="file"
              class="custom-file-input"
              name="rl_logo"
              id="rl_logo"
              accept="image/*"
            />
            <label class="custom-file-label" for="rl_logo">Logo wählen</label>
          </div>
          <br />
          <br />
          <div>
            <label>Firmenname</label>
            <quick-edit v-model="companyName" :classes="vueQuickEditClasses" :emptyText="emptyText"></quick-edit>
          </div>
          <br />
          <button disabled type="submit" class="btn btn-primary">Angaben speichern</button>
        </form>
      </div>
      <div class="tab-pane" id="sysestlg_steuersatz">
        <h5 class="text-muted heading">Hier kommt der Steuersatz.</h5>
      </div>
    </div>
  </div>
</template>

<script>
import QuickEdit from "vue-quick-edit";

export default {
  name: "settings",
  data: function () {
    return {
      companyName: "",
      vueQuickEditClasses: {
        wrapper: "form-group form-inline",
        input: "form-control input-sm",
        buttons: "btn-group btn-group-sm",
        buttonOk: "btn btn-primary",
        buttonCancel: "btn btn-link",
      },
      emptyText: "Eingeben",
    };
  },
  components: {
    QuickEdit,
  },
};
</script>

<style>
</style>