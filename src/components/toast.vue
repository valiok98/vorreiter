<template>
  <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body"></div>
  </div>
</template>

<script>
export default {
  name: "toast",
};
</script>

<style>
.toast {
  position: absolute;
  top: 15px;
  right: 15px;
}
</style>