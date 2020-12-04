<template>
  <transition name="modal-fade">
    <div class="modal-backdrop"
     v-on:click.self="close"
     >
      <div
        ref="modal"
        class="modale"
        role="dialog"
        aria-labelledby="modalTitle"
        aria-describedby="modalDescription"
      >
        <header
          class="modal-header"
          id="modalTitle"
        >
          <slot name="header">
            <h3>Login/Register</h3>
            <h4
                class="close-btn"
                v-on:click="close">x</h4>
          </slot>
        </header>
        <section
          class="modal-body"
          id="modalDescription"
        >
            <slot name="body">
                <div class="loginForm col-lg-8 offset-lg-2">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input v-model="username" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input v-model="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <div class="error-msg">{{this.errorMsg}}</div>
                    </form>
                </div>


            </slot>
        </section>
        <div class="footer-wrap">
            <footer class="modal-footer">
                <slot name="footer">
                    <button
                    type="button"
                    class="btn-green"
                    @click="register"
                    aria-label="Close modal"
                    >
                    Register
                    </button>
                    <button
                    type="button"
                    class="btn-blue"
                    @click="login"
                    aria-label="Close modal"
                    >
                    Login
                    </button>

                </slot>
            </footer>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
  export default {
    name: 'loginModal',
    data(){
        return{
            errorMsg:"",
            username:"",
            password:"",
            token_type:"",
            access_token:"",
            expires_in:"",
        }
    },
    methods: {
      close() {
        this.$emit('close');
      },
      login(){
          this.errorMsg=""
          this.$loading(true)
          axios.post('/api/login',{
                  email: this.username,
                  password: this.password
          })
          .then(response =>{
              this.token_type = response.data.token_type
              this.access_token = response.data.access_token
              this.expires_in = response.data.expires_in
              this.$cookie.set("studoAccesToken",this.access_token,70)
              this.$cookie.set("studoIsLoggedIn",true)

              this.$emit('loggedIn')
          }).catch(error =>{
              console.log(error)
              this.errorMsg = "Neispravni podaci!"
          });


      },
      register(){
          this.$emit('openRegister')
      }
    },
  };
</script>

<style scoped>

@media only screen and (max-width: 760px){
    .modale {
        background: #FFFFFF;
        height: 400px;
        box-shadow: 2px 2px 20px 1px;
        width: 96vw;
        display: flex;
        flex-direction: column;
    }
}
@media only screen and (min-width: 760px){

    .modale {
        background: #FFFFFF;
        height: 450px;
        box-shadow: 2px 2px 20px 1px;
        width: 30vw;
        display: flex;
        flex-direction: column;
  }

}

.error-msg{
    color:red
}
.loginForm{
    margin-top:25px
}

p{
    display: inline-block;
}
button{
    width: 71px;
}
.footer-wrap{
    margin-top: 5px;
    border-top: 1px solid #c9c9c9;
}
.area{
     border-bottom: 1px solid #eeeeee;
     padding-top: 5px;
     padding-bottom: 5px;
     display: flex;
     justify-content:flex-start;
}
.area-title{
    min-width: 97px;
    width: 98px;
    font-weight: 700;
    padding-right: 8px;
}
  .modal-backdrop {
    position: fixed;
    height: 100vh;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(161, 161, 161, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
  }



  .modal-header,
  .modal-footer {
    padding: 10px;
    display: flex;
  }

  .modal-header {
    border-bottom: 1px solid #eeeeee;
    color: #4AAE9B;
    justify-content: space-between;
  }

  .modal-footer {
    border:0px;
    justify-content:center;
    max-height: 55px;
    width:100%

  }
  .close-btn{
      padding: 1px 10px 6px 10px;
  }
  .close-btn:hover{
      cursor: pointer;
  }
  .modal-body {
    overflow: auto;
    position: relative;
    padding: 0px 8px;
  }
  .btn-green {
    color: white;
    background: #4AAE9B;
    border: 1px solid #4AAE9B;
    border-radius: 2px;
  }
  .btn-blue{
      color: white;
    background: rgb(79, 156, 201);
    border: 1px solid rgb(99, 136, 192);
    border-radius: 2px;
  }
  .btn-green:hover{
    background: rgb(60, 143, 128);
    border: 1px solid rgb(110, 231, 209);
    transition: 0.3s all;
  }
  .btn-blue:hover{
    background: rgb(62, 123, 158);
    border: 1px solid rgb(99, 176, 221);
    transition: 0.3s all;
  }
   .modal-fade-enter,
  .modal-fade-leave-active {
    opacity: 0;
  }

  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity .5s ease
  }
</style>
