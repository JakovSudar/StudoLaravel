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
            <h3>{{job.title}} - {{job.employer}}</h3>
          </slot>
        </header>
        <section
          class="modal-body"
          id="modalDescription"
        >
          <slot name="body">
            <div class="jobDescr area">
                <p class="area-title">Opis posla: </p>  <p class="line-break">{{job.description}}</p>
            </div>
             <div class="area">
                <p class="area-title">Mjesto rada: </p> <p >{{job.city}}</p>
            </div>
            <div class="area">
                <p class="area-title">Zahtjevi: </p> <p class="line-break">{{job.requirements}}</p>
            </div>
            <div class="area">
                <p class="area-title">Satnica: </p> <p >{{job.wage}}</p>
            </div>
            <div class="area">
                <p class="area-title">Dodatno: </p> <p class="line-break">{{job.notes}} </p>
            </div>
          </slot>
          </section>
    <div class="footer-wrap">
            <footer class="modal-footer col-md-4 col-sm-12 offset-md-8">
                <slot name="footer">
                    <button
                    type="button"
                    class="btn-blue"
                    @click="prijava"
                    aria-label="Close modal"
                    >
                    Prijavi se!
                    </button>
                    <button
                    type="button"
                    class="btn-green"
                    @click="close"
                    aria-label="Close modal"
                    >
                    Zatvori!
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
    name: 'detailsModal',
    props:['job'],
    methods: {
      close() {
        this.$emit('close');
      },
      prijava(){
          this.$emit('prijava',this.job.id);
      }
    },
  };
</script>

<style scoped>

p{
    display: inline-block;
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
    min-width: 110px;
    width: 115px;
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
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
  }
/*mobitel*/
  @media only screen and (max-width: 760px){
    .modale {
        background: #FFFFFF;
        height: 90vh;
        box-shadow: 2px 2px 20px 1px;
        width: 96vw;
        display: flex;
        flex-direction: column;
        margin-top:5px
    }
    .modal-backdrop{
        align-items: flex-start;

    }
}
/*laptop*/
@media only screen and (min-width: 760px){

    .modale {
        background: #FFFFFF;
        height: 80vh;
        box-shadow: 2px 2px 20px 1px;
        width: 40vw;
        display: flex;
        flex-direction: column;
  }
  .modal-backdrop{
        align-items: center;
    }

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
  .line-break{
    white-space: pre-line;
  }

</style>
