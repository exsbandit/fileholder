<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue-phone-number-input@1.1.9/dist/vue-phone-number-input.css">
  <link rel="stylesheet" href="style.css">

  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue-phone-number-input@1.1.9/dist/vue-phone-number-input.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script src="https://unpkg.com/vue-snotify@3.2.1/vue-snotify.min.js"></script>
 

 </head>
 <body>

<div id="app">
  {{ title }}
  <button v-on:click="show">Click</button>
  <button v-on:click="sweetAlert">Sweet Alert</button>
  <button v-on:click="toggleShowError">show error {{ this.showError }}</button>
  <notifications group="auth"/>
  <vue-snotify></vue-snotify>
</div>

</body>
</html>
<script>

var app = new Vue({
  el: '#app',
  data: {
    title: 'test',
    showError: false
  },
  watch: {
    showError(value) {
      if (value) {
        Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',
          footer: '<a href>Why do I have this issue?</a>'
        });
        this.showError = false;
      }
    }
  },
  methods: {
    toggleShowError() {
      this.showError = !this.showError;
    },
    show() {
      console.log('test');
      // this.$notify({ group: 'auth', text: 'aaa' });
      this.$snotify.success('Example body content');
    },
    sweetAlert() {
      // Swal.fire(
      //   'Good job!',
      //   'You clicked the button!',
      //   'success'
      // );
      Swal.fire({
        position: 'top-end',
        type: 'success',
        title: 'Your work has been saved',
        text: '11',
        showConfirmButton: false,
        timer: 1500
      })
    }
  }
});



</script>