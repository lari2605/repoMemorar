<template>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@200;300;400;500;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
      crossorigin="anonymous"
    />

    <title>Crie sua conta || Loja Memorar</title>
    <meta name="description" content="Crie sua conta online na Loja Memorar!" />
  </head>
  <body>
      <div class="container my-4 col-md-6 col-lg-6 col-xl-4">
        <div class="d-flex justify-content-center">
          <img
            src="./assets/memorar.fot.br.png"
            width="200px"
            title="Logo Loja Memorar"
            alt="Logo da Loja Memorar: Frame com coração e ao lado a palavra Memorar"
          />
        </div>

        <h1 class="h5 fw-bold text-center mt-2 mb-3">
          Crie sua conta na Memorar
        </h1>
        <form class="row gx-3" action="" method="POST" v-on:submit.prevent="onSubmitFunction">
          <div class="form-floating mb-3">
            <input
              class="form-control"
              v-model="userForm.name"
              id="UserName"
              placeholder="Nome Completo"
              name="name"
              type="text"
              minlength="5"
              required
            />
            <label for="UserName">Nome Completo</label>
          </div>
          <div class="col-sm-6 form-floating mb-3">
            <input
              class="form-control"
              v-model="userForm.telephone"
              id="telephoneNumber"
              placeholder="Telefone"
              name="telephoneNumber"
              type="tel"
              maxlength="14"
              required
            />
            <label for="telephoneNumber"> Telefone</label>
          </div>
          <div class="col-sm-6 form-floating mb-3">
            <input
              class="form-control"
              v-model="userForm.birthDate"
              id="birthDate"
              placeholder="Data Nasc."
              name="birthDate"
              type="date"
              required
            />
            <label for="birthDate">Data de Nascimento</label>
          </div>
          <div class="form-floating mb-3">
            <input
              class="form-control"
              v-model="userForm.email"
              id="email"
              placeholder="E-mail"
              name="email"
              type="email"
              pattern="^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$"
              required
            />
            <label for="email">E-mail</label>
          </div>
          <div class="col-sm-6 form-floating">
            <input
              class="form-control"
              v-model="userForm.password"
              id="password"
              placeholder="Crie uma senha"
              name="password"
              type="password"
              pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
              required
            />
            <label for="password">Crie uma senha</label>
          </div>

          <small class="ps-3 mb-2 text-muted d-sm-none"
            >Sua senha deverá ter ao menos 8 caracteres, 1 número e 1
            letra</small
          >
          <div class="col-sm-6 form-floating">
            <input
              class="form-control"
              v-model="userForm.repeatedPassword"
              id="repeatedPassword"
              placeholder="Repita a senha"
              name="repeatedPassword"
              type="password"
              pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
              required
            />
            <label for="repeatedPassword">Repita a senha</label>
          </div>
          <small class="ps-4 text-muted d-none d-sm-block"
            >Sua senha deverá ter ao menos 8 caracteres, 1 número e 1
            letra</small
          >
          <div class="form-floating my-3">
            <input
              class="form-control"
              v-model="userForm.cpf"
              id="CPF"
              placeholder="CPF"
              name="cpf"
              type="text"
              pattern="^([-\.\s]?(\d{3})){3}[-\.\s]?(\d{2})$"
              required
            />
            <label for="CPF">CPF</label>
          </div>

          <div class="alert alert-danger" v-if="showErrorMessage" >
            {{errorMessage}}
          </div>

          <div class="alert alert-success" v-if="showConfirmMessage" >
           Seus dados foram salvos com sucesso! 😊
          </div>

          <button
            class="btn btn-primary p-3 px-5 w-auto m-auto"
            type="submit"
            name="action"
          >
            Criar Conta
          </button>
        </form>

        <table id="registers" class="table table-striped mt-4">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nome</th>
              <th scope="col">Telefone</th>
              <th scope="col">Nascimento</th>
              <th scope="col">E-mail</th>
              <th scope="col">CPF</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <th scope="row">{{user.id}}</th>
              <td> {{user.name}}</td>
              <td> {{user.telephoneNumber}}</td>
              <td> {{user.birthDate}} </td>
              <td> {{user.email}} </td>
              <td> {{user.cpf}} </td>
            </tr>
          </tbody>
        </table>
      </div>
  </body>
</html>

</template>

<script>
import axios from 'axios'

export default {
  name: "App",
  components: {},
  data: function(){
    return{
      showConfirmMessage: false,
      showErrorMessage: false,
      errorMessage:'Algo deu errado',
      userForm:{},
      users:[]
   }
  },
  
  methods: {
    async postUsers(){
      try {
        await axios.post("http://localhost:9090/user",this.data);
        this.getUsers();
        this.showConfirmMessage = true
      } catch (error) {
        console.log(error)
        this.showErrorMessage = true
        this.errorMessage= 'Não conseguimos salvar seus dados, por favor, tente novamente!'
      }
    },
    onSubmitFunction: function(){
      if(this.userForm.repeatedPassword != this.userForm.password){
        
        this.showErrorMessage = true
        this.errorMessage= 'As senhas são diferentes, por favor verifique!'
     
     }else{
        this.showErrorMessage = false      

        const data = new URLSearchParams();

        for(var[key, value] of Object.entries(this.userForm)){
          data.append(key, value);
        }

        this.postUsers();      
     }
    },

    getUsers: function(){
      axios
        .get('http://localhost:9090/user').then((response) => {
          this.users = response.data;})   
    }
  },
  
  mounted: function(){
    this.getUsers()
  }
};
</script>

<style>
  body {
    font-family: "Work Sans", sans-serif;
  }

  #createAccount label {
    left: auto !important;
  }
</style>