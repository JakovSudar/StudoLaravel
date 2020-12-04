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
            <h3>Registracija</h3>
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
                            <label for="exampleInputEmail1">Username</label>
                            <input v-model="username" type="email" class="form-control" id="username" v-bind:class="{'form-error': unameError }" aria-describedby="emailHelp" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input v-model="email" type="email" class="form-control" id="email" v-bind:class="{'form-error': emailError }" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input v-model="password" type="password" class="form-control"  v-bind:class="{'form-error': pwdError }" id="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input v-model="rPassword" type="password" class="form-control" v-bind:class="{'form-error': pwdError }" id="rPassword"  placeholder="Repeat password">
                        </div>
                            <div class="form-check form-check-inline">
                                <input v-model="type" class="form-check-input" type="radio" name="exampleRadios" id="student" value="student" >
                                <label class="form-check-label" for="student">
                                    Student
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input v-model="type" class="form-check-input" type="radio" name="exampleRadios" id="poslodavac" value="employer">
                                <label class="form-check-label" for="poslodavac">
                                    Poslodavac
                                </label>
                            </div>
                            <p v-show="typeError">Odaberite student ili poslodavac</p>
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
                    >
                    Register
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
    name: 'registerModal',
    data(){
        return{
            username:"",
            email:"",
            password:"",
            rPassword:"",
            type:"",
            pwdError:false,
            unameError:false,
            emailError:false,
            typeError:false
        }
    },
    methods: {
        close(){
            this.$emit('close')
        },
        register(){
            if((this.password != this.rPassword) || this.password==""){
                this.pwdError=true
            }else this.pwdError =false
            if(this.username == ""){
                this.unameError = true
            }else this.unameError = false
            if(this.email == ""){
                this.emailError = true
            }else this.emailError =false
            if(this.type==""){
                this.typeError = true
            }else this.typeError = false
            if(!(this.pwdError || this.emailError || this.unameError|| this.typeError)){
                var formData = new FormData()
                formData.set('email',this.email)
                formData.set('password',this.password)
                formData.set('password_confirmation',this.rPassword)
                formData.set('name',this.username)
                formData.set('type',this.type)
                this.$loading(true)
                axios({
                    method:'post',
                    url: '/api/users',
                    data: formData,
                    headers:{'Content-Type': 'multipart/form-data' }
                })
                .then(res=>{
                    axios.post('/api/login',{
                  username: this.email,
                  password: this.password
                        })
                        .then(response =>{
                            this.token_type = response.data.token_type
                            this.access_token = response.data.access_token
                            this.expires_in = response.data.expires_in
                            this.$cookie.set("studoAccesToken",this.access_token,70)
                            this.$cookie.set("studoIsLoggedIn",true)
                            this.$emit('registered')
                        }).catch(error =>{
                            this.$loading(true)
                            console.log(error)
                            alert("Dogodila se pogreška")
                        });
                }).catch(error=>{
                    this.$loading(false)
                    console.log(error)
                    alert("Dogodila se pogreška")
                })
            }


        }
    },
  };
</script>

<style scoped>

@media only screen and (max-width: 760px){
    .modale {
        background: #FFFFFF;
        height: 90vh;
        box-shadow: 2px 2px 20px 1px;
        width: 96vw;
        display: flex;
        flex-direction: column;
    }
}
@media only screen and (min-width: 760px){

    .modale {
        background: #FFFFFF;
        height: 600px;
        box-shadow: 2px 2px 20px 1px;
        width: 30vw;
        display: flex;
        flex-direction: column;
  }

}
.form-error{
    border: 1px solid red !important
}

.error-msg{
    color:red
}
.loginForm{
    margin-top:25px
}

p{
    display: inline-block;
    color:red
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
