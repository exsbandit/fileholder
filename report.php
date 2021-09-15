
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
       <input type="button" class="btn btn-success btn-xs" @click="openModel" value="showJson" />
       <a href="index.php" class="btn btn-primary btn-xs" target="_self">Home Page</a>
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
       </tr>
       <tr v-for="row in allData">
        <td>{{ row.name }}</td>
        <td>{{ row.lastname }}</td>
        <td>{{ row.phone }}</td>
        <td>{{ row.email }}</td>
        <td>{{ row.message }}</td>
        <td>{{ row.lngname }}</td>
        <td>{{ row.reference ? row.reference : '-'}}</td>
        <td>{{ row.appdate }}</td>
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
           <label>Json Data :</label>
           <textarea v-model="jsondata" class="form-control" rows="20"></textarea>
          </div>
          <br />
          <div align="center">
           <input type="button" class="btn btn-success" v-model="actionButton" @click="exportData" />
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

var application = new Vue({
    el:'#crudApp',
    data:{
    allData:'',
    myModel:false,
    actionButton:'Insert',
    dynamicTitle:'Json Data',
    },
    methods:{
        fetchLastData:function(){
            console.log('test');
            axios.post('action.php', {
                action:'fetchlast'
            }).then(function(response){
                console.log(response);
                application.allData = response.data;
            });
        },
        openModel:function() {
            axios.post('action.php', {
            action:'export'
        }).then(function(response){
            application.jsondata = JSON.stringify(response.data);
            application.actionButton = "Export";
            application.dynamicTitle = "Json Data Information";
            application.myModel = true;
        });
        
        },
        exportData:function() {
            axios.post('action.php', {
                action:'export'
            }).then(response => {
                console.log(response.data);
                const blob = new Blob([JSON.stringify(response.data)], { type: 'application/json' })
                const link = document.createElement('a')
                link.href = URL.createObjectURL(blob)
                const current = new Date();
                link.download = current + '_jsonfile'
                link.click()
                URL.revokeObjectURL(link.href)
            }).catch(console.error)
        },
    },
    created:function(){
        this.fetchLastData();
    }
 
});

</script>