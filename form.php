
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
  <div class="container" id="formApp">
   <br />
   <h3 align="center">Trem Global Application Form</h3>
   <br />
   <div class="panel panel-default">
    <div class="panel-heading">
     <div class="row">
      <div class="col-md-6">
       <h3 class="panel-title">Trem Global</h3>
      </div>
      <div class="col-md-6" align="right">
      <h3 class="panel-title">Created by Erdem ATEŞ</h3>
      </div>
     </div>
    </div>
    <div class="panel-body">
    <div class="form-group">
           <label>First Name :</label>
           <input type="text" class="form-control" placeholder="First Name" v-model="first_name" />
          </div>
          <div class="form-group">
           <label>Last Name :</label>
           <input type="text" class="form-control" placeholder="Last Name" v-model="last_name" />
          </div>
          
          <div class="form-group">
           <label>Email :</label>
           <div class="input-group" :class="mailstatus">
                <span class="input-group-addon" id="basic-addon1"><span class="fa fa-envelope"></span></span>
                <input type="email" class="form-control" placeholder="Email Address" v-model="email_address"  @keyup="isEmailValid()" />
            </div>
        </div>
        <div class="form-group">
           <label>Phone Number :</label>
           <vue-phone-number-input v-model="phone_number" :disabled-fetching-country="false" :no-use-browser-locale="false" @update="phoneresults = $event"></vue-phone-number-input>
          </div>
          <div class="form-group">
           <label>Language</label>
           <select class="form-control" v-model="language">
            <option value="">Select Language</option>
            <option v-for="data in feedlanguage" :value="data.id">{{ data.name }}</option>
            </select>
          </div>
          <div class="form-group">
           <label>Reference :</label>
           <input type="text" class="form-control" placeholder="Referer (First Name & Last Name)" v-model="reference" />
          </div>
          <div class="form-group">
           <label>Message :</label>
           <textarea v-model="message" class="form-control"></textarea>
          </div>
          <br />
          <div align="center">
           <input type="hidden" v-model="hiddenId" />
           <i class="bi bi-telegram"></i>
           <input type="button" class="btn btn-success" v-model="submit" @click="submitData" />
           <a href="index.php" class="btn btn-primary" target="_self">Home Page</a>
          </div>
    </div>
   </div>
  </div>

 </body>
</html>
<script>
  const VuePhoneNumberInput = window['vue-phone-number-input'];
  Vue.component('vue-phone-number-input', VuePhoneNumberInput);
  var mailcontrol = false;
  var countrydial = '';
var application = new Vue({
 el:'#formApp',
 data: {
    mailstatus: '',
    first_name: '', 
    last_name: '',
    phone_number: '',
    email_address: '',
    language: '',
    feedlanguage: '',
    message: '',
    reference: '',
    hiddenId: '',
    email:'',
    dynamic_class:true,
    status:'',
    password:'',
    is_disable:false,
    class_name:'',
    phoneresults: null,
    submit: 'Submit',
    actionButton:'submit_form',
    dynamicTitle:'Add Data',
    reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
  },
  
  created:function(){
    this.fetchLanguage();
  },
 methods:{
    isEmailValid: function() {
        if (this.email_address == "") {
            return '';
        } else {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
                this.timer = setTimeout(() => {
                var email = application.email_address.trim();
                if (this.reg.test(this.email_address)) {
                    axios.post('action.php', {
                    action:'checkmail',
                    email:email
                    }).then(function(response){
                        if(response.data.is_available == true) {
                            Swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: 'This e-mail address is available for application',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            mailcontrol = true;
                            this.mailstatus = 'has-success';
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                type: 'error',
                                title: 'This e-mail address is already application :' + application.email_address,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            this.mailstatus = 'has-error';
                            mailcontrol = false;
                        
                        }
                    });
                } else {
                    Swal.fire({
                        position: 'top-end',
                        type: 'warning',
                        title: 'This e-mail address is not available for application',
                        showConfirmButton: false,
                        timer: 1500
                    });
                        this.mailstatus = 'has-error';
                        mailcontrol = false;
                }
            }, 800);
        }
    },
   fetchLanguage:function(){
   axios.post("action.php", {
    action:'language'
   }).then(function(response){
    application.feedlanguage = response.data;
   });
  },
    submitData:function(){
        if((application.first_name).trim() != '' && application.last_name != '' &&
            mailcontrol && application.phoneresults && application.phoneresults.isValid &&
            application.language && application.message != '')
        {
            if(application.actionButton == 'submit_form')
            {
                axios.post('action.php', {
                    action:'insert',
                    firstName:application.first_name, 
                    lastName:application.last_name,
                    phoneNumber:application.phoneresults.formattedNumber,
                    emailAddress:application.email_address,
                    language:application.language,
                    message:application.message,
                    reference:application.reference
                    }).then(function(response){
                    application.myModel = false;
                    application.first_name = '';
                    application.last_name = '';
                    application.phone_number = '';
                    application.phoneresults = null;
                    application.email_address = '';
                    application.language = '';
                    application.reference = '';
                    application.message = '';
                    application.hiddenId = '';
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            }
        } else {
            Swal.fire({
                position: 'top-end',
                type: 'warning',
                title: 'Please fill in all fields in the form and check',
                showConfirmButton: false,
                timer: 1500
            });
        }
  },

  isEdmailValid() {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email_address)) {
            this.msg['email'] = 'Please enter a valid email address';
        } else {
            this.msg['email'] = '';
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
               
        }
    }
 }
});

</script>