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
            <h3>Novi oglas</h3>
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
                    <form class="validate">
                        <div class="form-group">
                            <label for="Firma">Naziv poduzeća</label>
                            <input v-model="poslodavac" type="text" class="form-control" id="Firma" placeholder="Naziv poduzeća" required>
                        </div>
                        <div class="form-group">
                            <label for="vrsta">Vrsta posla</label>
                             <select v-model="vrsta" class="custom-select" id="vrsta-select" required>
                                <option value="Turizam">Turizam</option>
                                <option value="Fizički posao">Fizički poslovi</option>
                                <option value="Ljepota i njega">Ljepota i njega</option>
                                <option value="Dostavljač">Dostavljač</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pozicija">Pozicija</label>
                            <input v-model="pozicija" type="text" class="form-control" id="pozicija" placeholder="konobar,dostavljač,programer..." required>
                        </div>
                        <div class="form-group">
                            <label for="opis">Opis posla</label>
                           <textarea v-model="opisPosla" class="form-control" id="opis" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="satnica">Satnica</label>
                            <input v-model="satnica" type="number"  class="form-control"  id="satnica" step=0.01>
                        </div>
                        <div class="form-group">
                            <label for="mjesto-select">Mjesto rada</label>
                             <select v-model="mjestoRada" class="custom-select" id="mjesto-select" required>
                                <option value="Osijek">Osijek</option>
                                <option value="Zagreb">Zagreb</option>
                                <option value="Split">Split</option>
                                <option value="Pula">Pula</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="zahtjevi">Zahtjevi</label>
                            <textarea v-model="zahtjevi" class="form-control" id="zahtjevi" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="dodatno">Dodatne napomene</label>
                            <textarea v-model="dodatno" class="form-control" id="dodatno" rows="3"></textarea>
                        </div>
                        <div class="error-msg">{{this.errorMsg}}</div>

                    </form>
                     <div id="predaj">
                        <button
                            class="btn-success btn"
                            @click="postJob"
                            >
                            Predaj
                            </button>
                        </div>
                </div>


            </slot>
        </section>
      </div>
    </div>
  </transition>
</template>
<script>
  export default {
    props:['id'],
    name: 'newJobModal',
    data(){
        return{
            poslodavac:"",
            pozicija:"",
            satnica:25.39,
            vrsta:"",
            mjestoRada:"",
            zahtjevi:"",
            dodatno:"",
            opisPosla:"",
            errorMsg:""
        }
    },
    methods: {
      close() {
        this.$emit('close');
      },
      postJob(){
          if($(".validate")[0].checkValidity()){
                if(!(this.satnica<25.39)){
                    var formData = new FormData()
                    formData.set('title',this.pozicija)
                    formData.set('description',this.opisPosla)
                    formData.set('category',this.vrsta)
                    formData.set('city',this.mjestoRada)
                    formData.set('wage',this.satnica)
                    formData.set('employer',this.poslodavac)
                    formData.set('requirements',this.zahtjevi)
                    formData.set('notes',this.dodatno)
                    this.$loading(true)
                    axios({
                        method:'post',
                        url: '/api/users/'+this.$props.id+'/jobs',
                        data: formData,
                        headers:{'Content-Type': 'multipart/form-data' }
                    })
                    .then(res=>{
                        this.$loading(false)
                        this.$emit("newJobPosted")
                    }).catch(error=>{
                        this.$loading(false)
                        console.log(error)
                        alert("Dogodila se pogreška")
                    })
                }else
                     this.errorMsg = "Minimalna satnica je 25.39 kn/h!"
          }else
            this.errorMsg = "Nepotpuni podaci!"
      }
    },
  };
</script>

<style scoped>

@media only screen and (max-width: 760px){
    .modale {
        background: #FFFFFF;
        height: 98vh;
        box-shadow: 2px 2px 20px 1px;
        width: 96vw;
        display: flex;
        flex-direction: column;
    }
}
@media only screen and (min-width: 760px){

    .modale {
        background: #FFFFFF;
        height: 95vh;
        box-shadow: 2px 2px 20px 1px;
        width: 40vw;
        display: flex;
        flex-direction: column;
  }
}

.error-msg{
    color:red
}
.loginForm{
    margin-top:10px
}
label{
    font-weight: 600;
}
p{
    display: inline-block;
}
#predaj{
    display: flex;
    justify-content: center;
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
    padding: 5px;
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
    max-height: 60px;
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
