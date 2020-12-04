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
            <h3>Prijava na posao</h3>
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
                    <form class="applicationForm">
                        <div class="form-group">
                            <label for="AboutMe">Recite nešto o sebi</label>
                            <textarea v-model="about" class="form-control" id="AboutMe" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="email">Kontakt email</label>
                            <input v-model="email" type="email" class="form-control" id="email" required />
                        </div>
                        <div class="form-group">
                            <label for="phone">Kontakt telefon</label>
                            <input v-model="phone" type="text" class="form-control" id="phone"/>
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
                        class="btn btn-success"
                        v-on:click="prijava"
                    >Prijavi se!</button>
                </slot>
            </footer>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
  export default {
    name: 'jobApplication',
    props:['user','job'],
    data(){
        return{
            errorMsg:"",
            about:"",
            email:"",
            phone:""
        }
    },
    methods: {
      close() {
        this.$emit('close');
      },
      prijava(){
        var formData = new FormData()
        console.log($(".applicationForm")[0])
        if($(".applicationForm")[0].checkValidity()){
            formData.set('about_me',this.about)
            formData.set('job_id',this.$props.job )
            formData.set('email',this.email)
            formData.set('phone',this.phone)
            this.$loading(true)
            axios({
                method:'post',
                url: '/api/users/'+this.$props.user.id+'/jobApplications',
                data: formData,
                headers:{'Content-Type': 'multipart/form-data' }
            })
            .then(res=>{
                this.$loading(false)
                this.$emit("applied")
            }).catch(error=>{
                this.$loading(false)
                this.$emit("applyError")
            })
        }else{
            this.errorMsg = "Provjerite podatke"
        }

      }
    },
  };
</script>

<style scoped>

@media only screen and (max-width: 760px){
    .modale {
        background: #FFFFFF;
        height: 530px;
        box-shadow: 2px 2px 20px 1px;
        width: 96vw;
        display: flex;
        flex-direction: column;
    }
}
@media only screen and (min-width: 760px){

    .modale {
        background: #FFFFFF;
        height: 550px;
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
    width: 200px;
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


   .modal-fade-enter,
  .modal-fade-leave-active {
    opacity: 0;
  }

  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity .5s ease
  }
</style>
