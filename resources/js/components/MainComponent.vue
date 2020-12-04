<template>
    <div id="main"
        v-bind:class="{'modal-open': isDetailModallVisible}"
        >
        <navbar
            v-bind:user="user" :key="user.isLogged"
            v-on:login="showLogin"
            v-on:logOut ="logOut"
            v-on:newJob ="newJob"
            v-on:showProfile="showProfile"
            v-on:homepage="homepage"

        />
        <profile
            v-bind:user="user"
             v-on:details="showDetails"
             v-on:cancleApply="cancelApply"
            class="container main-section shadow back"
             v-show="isProfileVisible" >
            </profile>
        <transition name="fade">

            <div
                class="container main-section shadow back"
                 v-show="!isProfileVisible"
            >
                <filter-bar
                v-on:filter="filterJobs"
                />
                <div
                class="jobs-space">
                    <jobs-space
                        v-bind:jobs="jobs" key="jobs"
                        v-on:details="showDetails"
                        v-on:prijava="prijava"
                        v-on:close="closeDetails"
                    />
                </div>
            </div>
        </transition>
        <login-modal
            v-show="isLoginVisible"
            v-on:close="closeLogin"
            v-on:loggedIn="loggedIn"
            v-on:openRegister="isRegisterVisible=true"
            />
        <register-modal
            v-show="isRegisterVisible"
            v-on:close="isRegisterVisible=false"
            v-on:registered="registered"
            />
        <details-modal
            v-bind:job="detailJob" :key="detailJob.detid"
            v-show="isDetailModallVisible"
            @close="closeDetails"
            v-on:prijava="prijava"
        />
        <message-modal
            v-bind:message="message" :key="message"
            v-show="isMessageModalVisible"
            @close="closeMessage"
        />
        <newJob-modal
            v-bind:id="user.id" :key="user.id"
            v-show="isNewJobModalVisible"
            @close="closeNewJob"
            @newJobPosted="newJobPosted"
        />
        <jobApplication-modal
            v-show="isApplicationVisible"
            v-bind:user="user"
            v-bind:job="selectedJob" :key="selectedJob"
            v-on:close="closeApp"
            v-on:applied="applied"
            v-on:applyError="applyError"
        />


    </div>
</template>
<script>

export default {

    name:"app",
    data () {
        return {
            detailJob:{
                "detid": 9865432,
                "title": "sed",
                "description": "Dolor qui dolorem architecto voluptas. Hic neque pariatur molestias quos.",
                "category": "Turizam",
                "city": "Rijeka",
                "wage": 35,
                "requirements": "Asperiores est repudiandae molestiae vero.",
            },
            message: "Message",
            isNewJobModalVisible: false,
            isMessageModalVisible: false,
            isDetailModallVisible: false,
            isRegisterVisible:false,
            isProfileVisible:false,
            isApplicationVisible:false,
            isLoginVisible: false,
            selectedJob:0,
            jobs:[ ],
            user:{
                id:65668521,
                username: "",
                isVerified: 0,
                isLogged: false,
                type: "student"
            }
        }
    },
    created(){
        if(this.$cookie.get('studoAccesToken')!=null){
            this.user.isLogged = true
            this.user.username = this.$cookie.get('studoUsername')
            this.user.type =  this.$cookie.get('studoUserType')
            this.user.isVerified = this.$cookie.get('studoVerified')
            this.user.id = this.$cookie.get('studoUserId')
        }else
            this.user.isLogged = false
        this.fetcJobs();
    },
    mounted(){
        this.$root.$emit('loadData')
    },
    methods:{
        cancelApply(){
            this.toastMessage("Otkazali ste prijavu!")
        },
        applied(){
            this.toastMessage("Uspješno ste prijavljeni!")
            this.$root.$emit('loadData')
            this.isApplicationVisible = false
        },
        showProfile(){
            this.isProfileVisible = true
        },
        applyError(){
             this.toastMessage("Već ste prijavljeni!")
             this.isApplicationVisible = false
        },
        newJobPosted(){
            this.fetcJobs()
            this.closeNewJob()
             this.$root.$emit('loadData')
            this.toastMessage("Uspješno ste objavili posao!")
        },
        homepage(){
            this.isProfileVisible = false
        },
        closeApp(){
            this.isApplicationVisible = false
        },
        newJob(){
            this.isNewJobModalVisible = true
        },
        closeNewJob(){
            this.isNewJobModalVisible = false
        },
        closeMessage(){
            this.isMessageModalVisible =false
        },
        registered(){
            this.isLoginVisible = false
            this.isRegisterVisible = false
            this.$loading(false)
            this.loggedIn()
            this.toastMessage("Uspješno ste registrirani! Potvrdite mail.")
        },
        logOut(){
            let config = {
                headers : {
                    Authorization: "Bearer " + this.$cookie.get('studoAccesToken')
                }
            }
            let data = {
                'HTTP_CONTENT_LANGUAGE': self.language
            }
            this.homepage();
            this.fetcJobs();
            this.$loading(true)
            axios.post("/api/logout",data,config)
                .then(res=>{
                    this.$cookie.delete('studoUsername')
                    this.$cookie.delete('studoUserType')
                    this.$cookie.delete('studoVerified')
                    this.$cookie.delete('studoUserId')
                    this.$cookie.delete('studoAccesToken')
                    this.user.username = ""
                    this.user.type =  ""
                    this.user.isVerified = 0
                    this.user.isLogged=false
                    this.$loading(false)
                    this.toastMessage("Uspješno ste odjavljeni!")
                })
                .catch(error=>{
                    console.log(error)
                    this.$loading(false)
                    this.toastMessage("Dogodila se pogreška!")
                })
        },
        loggedIn(){
            let tokenStr = this.$cookie.get('studoAccesToken')
            axios.get('/api/user', { headers: {"Authorization" : `Bearer ${tokenStr}`} })
                .then(res=>{
                    this.user.isVerified = res.data.verified
                    this.user.username = res.data.name
                    this.user.type = res.data.type
                    this.user.id = res.data.id
                    this.$cookie.set('studoUsername',this.user.username,70)
                    this.$cookie.set('studoUserType',this.user.type,70)
                    this.$cookie.set('studoVerified',this.user.isVerified,70)
                    this.$cookie.set('studoUserId',this.user.id,70)
                    this.closeLogin()
                    this.user.isLogged = true
                    this.$loading(false)
                    this.toastMessage("Uspješno ste logirani!")
                    this.$root.$emit('loadData')
                })
                .catch(error=>{
                    console.log(error)
                    this.$loading(false)
                    this.toastMessage("Dogodila se pogreška!")
                })
        },
        showDetails(id){
            this.detailJob =  this.jobs.filter(job => {
                if(job.id == id) return job
            })
            this.detailJob = this.detailJob[0];
            document.querySelector("body").style.overflow = 'hidden';
            this.isDetailModallVisible = true;

        },
        closeLogin(){
            this.isLoginVisible = false;
        },
        closeDetails(){
            this.isDetailModallVisible = false;
            document.querySelector("body").style.overflow = 'auto';
        },
        prijava(jobId){
            this.selectedJob= jobId
            if(this.user.isLogged){
               if(this.user.isVerified){
                   this.isApplicationVisible = true
               }else
                    this.toastMessage("Potvrdite račun prije nastavka")
            }else{
                this.isLoginVisible = true
            }

        },
        fetcJobs(){
            this.$loading(true)
            fetch('api/jobs')
                .then(res => res.json())
                .then(res => {
                    this.jobs = res.data;
                    this.$loading(false)
                })
                .catch(error=>{
                    console.log(error)
                    this.$loading(false)
                    this.toastMessage("Dogodila se pogreška prilikom dohvaćanja poslova!")
                })
        },
        filterJobs(query){
            console.log(query);
            this.$loading(true)
            fetch('api/jobs'+query)
                .then(res => res.json())
                .then(res => {
                    this.jobs = res.data;
                    this.$loading(false)
                })
                .catch(error=>{
                    console.log(error)
                    this.$loading(false)
                    this.toastMessage("Dogodila se pogreška prilikom filtriranja!")
                })
        },
        showLogin(){
            this.isLoginVisible = true
        },
        toastMessage(msg){
            this.message = msg
            this.isMessageModalVisible = true
        }
    }
}
</script>

<style scoped>
#main{
    position:relative;
    z-index: 1;
}
.back{
    position:relative;
    z-index: 1;
}
.main-section{
    padding: 0;
    background-color: rgb(245, 247, 253)
}
.jobs-space{
    padding: 10px;
    position:relative;
    z-index: 1;
    text-align:center;
}
.modal-open{
   overflow: hidden !important;

}
.fade-enter-active, .fade-leave-active {
  transition: all .13s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>

<style>
.shadow{
box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
