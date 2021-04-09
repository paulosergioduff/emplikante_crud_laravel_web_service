<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Processo seletivo Replikante</title>
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
      <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/json2html/2.1.0/json2html.min.js"></script>

      <style type="text/css">
          .formContainer{
            position: absolute;
            left: 5%;
          }
          .resposta{
            position: fixed;
            top: 20%;
            right: 5%;
          }
          .status0{
            display: none;
          }
          input{
            background-color: #ffff66;
          }
      </style>

   </head>
   <body>
      <center>
         <img src="https://www.replikante.com.br/assets/img/logo/logo.png">
         <h3>Processo seletivo Replikante</h3>
      </center>
      <hr>
      <div class="formContainer">
         <h4>Login/Token</h4>
         <p>Email: <input type="text" id="txtEmail"></p>
         <p>Senha: <input type="password" id="txtPassword"></p>
         <p>Token: <input type="text" id="user_token" value="Aguardando login..." disabled="true"></p>
         <button class="btn btn-success" onclick="login();">Login</button>
            
         <hr>
         <h4>Cadastro</h4>
         <p>Nome: <input type="text" id="registroNome"></p>
         <p>Email: <input type="email" id="registroEmail"></p>
         <p>Senha: <input type="password" id="registroPassword"></p>
         <button class="btn btn-success" onclick="cadastrar();">Cadastrar</button>
      </div>

        <div class="resposta">
              <h4>Resposta</h4>
         <textarea id="output" rows="5" cols="40"></textarea>
         <hr>
         <h4><button class="btn btn-success" onclick="listar();">Listar</button></h4>
         <table id="lista">

            <tr>
    <th>id</th>
    <th>Nome</th>
    <th>E-mail</th>
    <th>Ação</th>
    <th></th>
  </tr>
           </div>

       </table>


        </div>
   
      <script>

        var listaGlobal = "";
        var container = "";

          function xrud_miniController($content){
                    
                    var html = json2html.transform($content,{'<>':'span','html': '<tr class="status${status}">'+'<td>${id}</td>'+'<td>${name}</td>'+'<td>${email}</td>'+'</tr><tr><td></td><td>Editar:</td><td>Editar:</td></tr><tr><td></td><td><input type="text" value="${name}" id="name${id}"></td><td><input type="text" value="${email}" id="email${id}"></td><td><button class="btn btn-warning" onclick="updateUser(${id});">Atualizar</button></td><td><button class="btn btn-danger" onclick="removeUser(${id});">Remover</button></td></tr>'});
                    //var html = html+json2html.transform($content,{'<>':'span','html': '<td>'+'${name}'+'</td>'});
                    //var html = html+json2html.transform($content,{'<>':'span','html': '<td>'+'${email}'+'</td></tr>'});
                    var listaGlobal = window.document.getElementById('lista').innerHTML;
                    var htmlFinal = window.document.getElementById('lista').innerHTML = html;
                    listaGlobal = htmlFinal;
                }

                function campo_token($content){
                    
                    var html = json2html.transform($content,{'':'','html': '${token}">'});
                    var htmlFinal = window.document.getElementById('user_token').value = $content.token;
                }



         var servidor = '{{Request::url()}}'; // Usando o blade para capturar o endereço do servidor. Troque para o endereço do servidor ao executar a aplicação externamente

         function resposta($dados){
            let tratamento = JSON.stringify($dados);
            xrud_miniController($dados.data.Users);


            window.window.document.getElementById("output").innerHTML = tratamento;
         }

         function revelaToken($dados){
            let tratamento = JSON.stringify($dados);
            //window.window.document.getElementById("user_token").value = tratamento;//$data.data['token'];//
            campo_token($dados.data);
         }
         
         function login() {
            let txtEmail  = window.document.getElementById('txtEmail').value;
            let txtPassword  = window.document.getElementById('txtPassword').value;
            let dados = {email: txtEmail, password: txtPassword  };
             axios.post(servidor + '/login', dados)
                 .then(function(response) {
                     revelaToken(response);
                     autoList();
                 });

                 //listar();
         }
         
         function listar() {
            let user_token = window.document.getElementById('user_token').value;
            let path = '/app?token='+user_token;
             fetch(servidor + path)
                 .then(response => response.json())
                 .then(data => resposta(data))
                 .then(data => console.log(path))
                 //.then(data => console.log(data))//xrud_miniController($content)
                 .catch(error => console.log('error is', error));

         }
         
         
         function cadastrar() {

                let registroNome  = window.document.getElementById('registroNome').value;
                let registroEmail = window.document.getElementById('registroEmail').value;
                let registroPassword  = window.document.getElementById('registroPassword').value;
            

            if (registroNome[0] == null | registroEmail[0] == null | registroPassword[0] == null) {
                alert("Todos os campos são obrigatórios!!");
            }else{
                let registroNome  = window.document.getElementById('registroNome').value;
                let registroEmail = window.document.getElementById('registroEmail').value;
                let registroPassword  = window.document.getElementById('registroPassword').value;
                let dados = { name: registroNome, email: registroEmail, password: registroPassword };

                axios.post(servidor + '/register', dados)
                 .then(function(response) {
                     resposta(response);
                     revelaToken(response);
                     autoList();
                 });
            }


             
         }


         function updateUser($id) {
        
        let user_token = window.document.getElementById('user_token').value;
        let namePath = 'name'+$id;
        let emailPath = 'email'+$id;
        let nameClass = window.document.getElementById(namePath).value;
        let emailClass = window.document.getElementById(emailPath).value;

        //alert(nameClass + '-' + emailClass);

             axios.put(servidor + '/app/'+$id, {
                     name: nameClass,
                     email: emailClass,
                     token: user_token,
                 })
                 .then(response => { 
                        console.log(response)
                        resposta(response);
                        autoList();
                    })
                    .catch(error => {
                        console.log(error.response)
                    });

         }

         function removeUser($id) {
        
        let user_token = window.document.getElementById('user_token').value;
        

        //alert(nameClass + '-' + emailClass);

             axios.delete(servidor + '/app/'+$id+'?token='+user_token, {

                     token: user_token,
                 })
                 .then(response => { 
                        console.log(response)
                        resposta(response);
                        autoList();
                    })
                    .catch(error => {
                        console.log(error.response)
                    });

         }

         function autoList(){
             setTimeout( function() {
                    listar();
                  }, 500 );
         }

         
         
             

  
      </script>
   </body>
</html>