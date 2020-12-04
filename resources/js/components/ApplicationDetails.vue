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
            <h3>Prijave</h3>
            <h4
                class="close-btn"
                v-on:click="close">x</h4>
          </slot>
        </header>
        <div class="body">
            <div class="application-item" v-bind:key="application.id" v-for="application in applications">
            <application-item
                v-bind:application="application"
                />
        </div>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
  export default {
    name: 'applicationDetails',
    props:['applications'],
    methods: {
      close() {
        this.$emit('close');
      },
    },
  };
</script>

<style scoped>

@media only screen and (max-width: 760px){
    .modale {
        height: 96vh;
        width: 96vw;
    }
}
@media only screen and (min-width: 760px){

    .modale {
        height: 80vh;
        width: 30vw;

  }
}
.modale{
    overflow: auto;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 2px 20px 1px;
    background: #FFFFFF;
}
.close-btn:hover{
      cursor: pointer;
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
    .modal-fade-enter,
  .modal-fade-leave-active {
    opacity: 0;
  }

  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity .5s ease
  }
</style>
