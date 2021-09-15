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
   </head>
   <style>
      a {
        text-decoration: none;
      }
      .fake-button {
      text-align: center;
      padding: 50px;
      border: 2px solid;
      border-radius: 8px;
      background-color: #e9e9e969;
      }
      .fake-button:hover {
      background-color: #23527c;
      }
      .fake-button p{
      font-size: 14pt;
      font-weight: bold;
      }
      .fake-button:hover p{
      color: #ffffff;
      }
   </style>
   <body>
      <div class="container">
         <h1 align="center">Görev Çalışması</h1>
         <br />
         <div class="panel panel-default">
            <div class="panel-heading">
               <div class="row">
                  <div class="col-md-6">
                     <h3 class="panel-title">Trem Global</h3>
                  </div>
               </div>
            </div>
            <div class="panel-body">
               <div class="col-md-4">
                  <a href="form.php" target="_self">
                     <div class="fake-button">
                        <p>Form Page</p>
                     </div>
                  </a>
               </div>
               <div class="col-md-4">
                  <a href="report.php" target="_self">
                     <div class="fake-button">
                        <p>Report Page</p>
                     </div>
                  </a>
               </div>
               <div class="col-md-4">
                  <a href="list.php" target="_self">
                     <div class="fake-button">
                        <p>Fully List Page</p>
                     </div>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>