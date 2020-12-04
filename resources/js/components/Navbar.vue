<template>
    <nav class="navbar navbar-gradient navbar-expand-lg navbar-dark mb-2">
        <div class="container">
            <a v-on:click="$emit('homepage')"  class="navbar-brand">Studo</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li v-on:click="showProfile" class="nav-item ">
                        <a  class="nav-link active">{{user.username}}</a>
                    </li>
                    <li v-on:click="newJob" v-if="user.type == 'employer'" class="nav-item ">
                        <a class="nav-link active">Predaj oglas</a>
                    </li>
                </ul>
                <template v-if="!user.isLogged">
                    <div
                    class="login-area"
                    v-on:click = "login"
                    >
                        <a href="" class="login-text">Prijava</a>
                        <svg class="bi bi-box-arrow-right" width="2em" height="2em" viewBox="0 0 16 16" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M11.646 11.354a.5.5 0 010-.708L14.293 8l-2.647-2.646a.5.5 0 01.708-.708l3 3a.5.5 0 010 .708l-3 3a.5.5 0 01-.708 0z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M4.5 8a.5.5 0 01.5-.5h9a.5.5 0 010 1H5a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M2 13.5A1.5 1.5 0 01.5 12V4A1.5 1.5 0 012 2.5h7A1.5 1.5 0 0110.5 4v1.5a.5.5 0 01-1 0V4a.5.5 0 00-.5-.5H2a.5.5 0 00-.5.5v8a.5.5 0 00.5.5h7a.5.5 0 00.5-.5v-1.5a.5.5 0 011 0V12A1.5 1.5 0 019 13.5H2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </template>
                <template v-else>
                    <div
                    class="login-area"
                    v-on:click = "logOut"
                    >
                        <a href="" class="login-text">Odjava</a>
                        <svg class="bi bi-box-arrow-right" width="2em" height="2em" viewBox="0 0 16 16" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M11.646 11.354a.5.5 0 010-.708L14.293 8l-2.647-2.646a.5.5 0 01.708-.708l3 3a.5.5 0 010 .708l-3 3a.5.5 0 01-.708 0z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M4.5 8a.5.5 0 01.5-.5h9a.5.5 0 010 1H5a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M2 13.5A1.5 1.5 0 01.5 12V4A1.5 1.5 0 012 2.5h7A1.5 1.5 0 0110.5 4v1.5a.5.5 0 01-1 0V4a.5.5 0 00-.5-.5H2a.5.5 0 00-.5.5v8a.5.5 0 00.5.5h7a.5.5 0 00.5-.5v-1.5a.5.5 0 011 0V12A1.5 1.5 0 019 13.5H2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </template>
            </div>
        </div>
    </nav>
</template>
<script>
export default {
    props: ['user'],
    methods:{
        login(){
            this.$emit('login')
        },
        logOut(){
            this.$emit('logOut')
        },
        newJob(){
            this.$emit('newJob')
        },
        showProfile(){
            this.$emit("showProfile")
        }
    }
}
</script>

<style scoped>
.login-text{
    color: white;
    padding-right: 0.3em;
    pointer-events: none;
}
.login-text:hover{
    text-decoration: none;
}
.login-area{
    padding: 1px 6px 0px 6px
}

.login-area:hover{
    border:rgb(86, 95, 122) solid 1px;
    cursor: pointer;
}
.navbar-brand:hover{
    cursor: pointer
}

.active:hover{
    color: blue !important;
    cursor: pointer !important;
}


.navbar-brand{
    font-weight: 700;
    font-size: 1.5em;
    padding-top: 0;
    padding-bottom: 0;
}
</style>

<style>
.navbar-gradient{
    background-image: linear-gradient(rgb(86, 95, 122),rgba(51,57,73,1));
}



</style>
