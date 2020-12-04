<template>
  <transition name="modal-fade">
      <div
        class="modale"
        v-on:click="close"
      >
      <p class="message">{{message}}</p>
      <p class="dismiss">x</p>
      </div>

  </transition>
</template>
<script>
  export default {
    name: 'messageModal',
    props:['message'],
    methods: {
      close() {
        this.$emit('close');
      }
    },
  };
</script>

<style scoped>

@media only screen and (max-width: 760px){
    .modale {
        width: 96vw;
    }
}
@media only screen and (min-width: 760px){
    .modale {
        width: 30vw;
  }
}
p.dismiss{
    width: 10%;
    display: flex;
    justify-content: flex-end;
    margin-right: 10px;
    font-size: 1.1em;
    font-weight: 500;
}
p.message{
    display: inline-block;
    color: blue;
    margin-top: 2px;
    font-weight: 600;
    width: 90%;
}
.modale{
    display: flex;
    flex-direction: row;
    padding-left: 10px;
    height: 30px;
    background: rgba(241, 241, 228,0.7);
    border-radius: 10px;
    position:fixed;
    top: 8px;
    left: 50%;
    transform: translate(-50%,0);
    z-index: 5;
    border: 1px solid black
}
.modale:hover{
    cursor:pointer;
    background: rgb(196, 196, 177);
}
  .modal-backdrop {
    position: fixed;
    height: 30px;
    top: 5px;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(161, 161, 161, 0);
    display: flex;
    justify-content: center;
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
