<template>
  <div>
    <modal v-if="showModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <h3>custom header</h3>
              </div>

              <div class="modal-body">
              
              <div id="dialog_anfrage-erstellen-2" title="Anfrage erstellen">
            <div id="div_anfrage-erstellen-content" class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <h5>Auftraggeber</h5>
                                <span><b>Firmenname</b></span><br>
                                <span id="span_anfrage-firmenname"></span><br>
                                <span><b>Ansprechpartner</b></span><br>
                                <span id="span_anfrage-ansprechpartner"></span>
                            </div>
                            <div class="col-sm-6">
                                <br>
                                <span><b>Kundennummer</b></span><br>
                                <span id="span_anfrage-kundennummer"></span><br>
                                <span><b>Telefon</b></span><br>
                                <span id="span_anfrage-telefon"></span><br>
                                <span><b>E-Mail-Adresse</b></span><br>
                                <span id="span_anfrage-email"></span>
                            </div>
                        </div>
                    </div>
                    <div id="div_anfrage-versandrechner" class="col-sm-6 div_versandrechner-wrapper">
                        <?php
                        get_versandrechner('anfrage');
                        ?>
                    </div>
                </div>
            </div>
        </div>

              </div>

              <div class="modal-footer">
                <h3>footer</h3>
                <button class="modal-default-button" v-on:click="close()">OK</button>
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
  name: "inquiry_dialog2",
  data: function () {
    return {
      showModal: false,
    };
  },
  methods: {
    close: function () {
      this.showModal = false;
    },
  },
};
</script>

<style>
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
</style>