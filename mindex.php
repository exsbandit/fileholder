
<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue-phone-number-input@1.1.9/dist/vue-phone-number-input.css">
<script src="https://cdn.jsdelivr.net/npm/vue-phone-number-input@1.1.9/dist/vue-phone-number-input.umd.min.js"></script>
 
  <style>
   .modal-mask {
     position: fixed;
     z-index: 9998;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     background-color: rgba(0, 0, 0, .5);
     display: table;
     transition: opacity .3s ease;
   }

   .modal-wrapper {
     display: table-cell;
     vertical-align: middle;
   }
  </style>
 </head>
 <body>
  <div class="container" id="crudApp">
   <br />
   <h3 align="center">Trem Global Application List</h3>
   <br />
   <div class="panel panel-default">
    <div class="panel-heading">
     <div class="row">
      <div class="col-md-6">
       <h3 class="panel-title">Trem Global</h3>
      </div>
      <div class="col-md-6" align="right">
       <input type="button" class="btn btn-success btn-xs" @click="openModel" value="Add" />
      </div>
     </div>
    </div>
    <div class="panel-body">
     <div class="table-responsive">
      <table class="table table-bordered table-striped">
       <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Message</th>
        <th>Language</th>
        <th>Reference</th>
        <th>Application Date</th>
        <th>Edit</th>
        <th>Delete</th>
       </tr>
       <tr v-for="row in allData">
        <td>{{ row.name }}</td>
        <td>{{ row.lastname }}</td>
        <td>{{ row.phone }}</td>
        <td>{{ row.email }}</td>
        <td>{{ row.message }}</td>
        <td>{{ row.lngname }}</td>
        <td>{{ row.reference }}</td>
        <td>{{ row.appdate }}</td>
        <td><button type="button" name="edit" class="btn btn-primary btn-xs edit" @click="fetchData(row.id)">Edit</button></td>
        <td><button type="button" name="delete" class="btn btn-danger btn-xs delete" @click="deleteData(row.id)">Delete</button></td>
       </tr>
      </table>
     </div>
    </div>
   </div>
   <div v-if="myModel">
    <transition name="model">
     <div class="modal-mask">
      <div class="modal-wrapper">
       <div class="modal-dialog">
        <div class="modal-content">
         <div class="modal-header">
          <button type="button" class="close" @click="myModel=false"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">{{ dynamicTitle }}</h4>
         </div>
         <div class="modal-body">
          <div class="form-group">
           <label>First Name :</label>
           <input type="text" class="form-control" v-model="first_name" />
          </div>
          <div class="form-group">
           <label>Last Name :</label>
           <input type="text" class="form-control" v-model="last_name" />
          </div>
          <div class="form-group">
           <label>Phone Number :</label>
           <vue-phone-number-input v-model="phone_number" :disabled-fetching-country="false" :no-use-browser-locale="false"></vue-phone-number-input>
          </div>
          <div class="form-group">
           <label>Email :</label>
           <input for="email" type="email" placeholder="Please enter your email here" required v-model="email_address" @blur="validateEmail" >

           <!-- <input type="email" class="form-control" v-model="email_address" /> -->
          </div>
          <div class="form-group">
           <label>Language</label>
           <input type="text" class="form-control" v-model="language" />
          </div>
          <div class="form-group">
           <label>Reference :</label>
           <input type="text" class="form-control" v-model="reference" />
          </div>
          <div class="form-group">
           <label>Message :</label>
           <textarea v-model="message" class="form-control"></textarea>
          </div>
          <br />
          <div align="center">
           <input type="hidden" v-model="hiddenId" />
           <input type="button" class="btn btn-success btn-xs" v-model="actionButton" @click="submitData" />
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </transition>
   </div>
  </div>
 </body>
</html>
<script>
  const VuePhoneNumberInput = window['vue-phone-number-input'];
    Vue.component('vue-phone-number-input', VuePhoneNumberInput);
var application = new Vue({
 el:'#crudApp',
 data:{
  allData:'',
  myModel:false,
  actionButton:'Insert',
  dynamicTitle:'Add Data',
 },
 watch: {
      email(value) {
        // binding this to the data value in the email input
        this.email_address = value;
        this.validateEmail(value);
      }
    },
 methods:{
  fetchAllData:function(){
   axios.post('action.php', {
    action:'fetchall'
   }).then(function(response){
    application.allData = response.data;
   });
  },
  validateEmail() {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email_address)) {
        this.msg['email'] = 'Please enter a valid email address';
    } else {
        this.msg['email'] = '';
    }
  },
  openModel:function(){
   
   application.first_name = '';
   application.last_name = '';
   application.email_address = '';
   application.language = '';
   application.phone_number = '';
   application.message = '';
   application.reference = '';
   application.actionButton = "Insert";
   application.dynamicTitle = "Add Data";
   application.myModel = true;
  },
  submitData:function(){
   if(application.first_name != '' && application.last_name != '')
   {
    if(application.actionButton == 'Insert')
    {
     axios.post('action.php', {
      action:'insert',
      firstName:application.first_name, 
      lastName:application.last_name,
      phoneNumber:application.phone_number,
      emailAddress:application.email_address,
      language:application.language,
      message:application.message,
      reference:application.reference
     }).then(function(response){
      application.myModel = false;
      application.fetchAllData();
      application.first_name = '';
      application.last_name = '';
      application.phone_number = '';
      application.email_address = '';
      application.language = '';
      application.reference = '';
      application.hiddenId = '';
      alert(response.data.message);
     });
    }
    if(application.actionButton == 'Update')
    {
     axios.post('action.php', {
      action:'update',
      firstName : application.first_name,
      lastName : application.last_name,
      hiddenId : application.hiddenId
     }).then(function(response){
      application.myModel = false;
      application.fetchAllData();
      application.first_name = '';
      application.last_name = '';
      application.hiddenId = '';
      alert(response.data.message);
     });
    }
   }
   else
   {
    alert("Fill All Field");
   }
  },
  fetchData:function(id){
   axios.post('action.php', {
    action:'fetchSingle',
    id:id
   }).then(function(response){
    application.first_name = response.data.first_name;
    application.last_name = response.data.last_name;
    application.hiddenId = response.data.id;
    application.myModel = true;
    application.actionButton = 'Update';
    application.dynamicTitle = 'Edit Data';
   });
  },
  deleteData:function(id){
   if(confirm("Are you sure you want to remove this data?"))
   {
    axios.post('action.php', {
     action:'delete',
     id:id
    }).then(function(response){
     application.fetchAllData();
     alert(response.data.message);
    });
   }
  },
  fakebutton:function(){
    axios.post('action.php', {
      action:'entercountry'
    }).then(function(response){
      application.fetchAllData();
      alert(response.data.message);
    });
  }
 },
 created:function(){
  this.fetchAllData();
 }
});

</script>