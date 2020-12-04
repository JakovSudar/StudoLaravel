<template>
  <transition name="modal-fade">
    <div class="main">
        <header
          class="modal-header"
          id="modalTitle">
            <h3>{{user.username}}</h3>
        </header>
        <template v-if="user.type=='student'">

            <div class="job-item" v-bind:key="job.id" v-for="job in jobs">
                <applied-job
                    v-bind:job="job"
                    v-on:details="details"
                    v-on:cancelApply="cancelApply"
                    />
            </div>
        </template>

        <template v-else>
            <div>

            </div>
            <div
                class="jobs-space">
                    <jobs-space-empl
                        v-bind:jobs="jobs" key="jobs"
                        v-on:deleteJob="deleteJob"
                    />
                </div>
        </template>
    </div>

  </transition>
</template>
<script>
  export default {
    name: 'profile',
    props:['user'],
    methods: {
        cancelApply(jobId){
             this.$loading(true)
            axios.delete("api/users/"+this.$props.user.id+"/jobApplications/"+jobId)
                .then(res=>{
                    console.log(res)
                    this.jobs = this.jobs.filter(job=> job.id!=res.data.id)
                     this.$loading(false)
                     this.$emit("cancleApply")
                }).catch(error=>{
                    console.log("error: "+error)
                })
        },
        deleteJob(jobId){
            this.$loading(true)
            axios.delete("api/users/"+this.$props.user.id+"/jobs/"+jobId)
                .then(res=>{
                    console.log(res)
                    this.jobs = this.jobs.filter(job=> job.id!=res.data.id)
                    this.$loading(false)
                }).catch(error=>{
                    console.log(error)
                })
        },
        details(jobId){
            this.$emit("details", jobId)
        }
    },
    mounted(){
        this.$root.$on('loadData',()=>{
            let tokenStr = this.$cookie.get('studoAccesToken')
            if(this.$props.user.type == "employer"){
            axios.get("/api/users/"+this.$props.user.id+"/jobs",{ headers: {"Authorization" : `Bearer ${tokenStr}`} })
                .then(res =>{
                    console.log(res.data.data)
                    this.jobs = res.data.data
                } )
                .catch(error=>{
                    console.log(error)
                })
            }else{
                axios.get("/api/users/"+this.$props.user.id+"/jobApplications",{ headers: {"Authorization" : `Bearer ${tokenStr}`} })
                .then(res =>{
                    console.log(res.data)
                    this.jobs = res.data
                } )
                .catch(error=>{
                    console.log(error)
                })
        }
        })
    },
    data(){
        return{
            jobs:[],
        }
    },
    created(){

    }
  };
</script>

<style scoped>
.main{
    min-height: 90vh;
}

.job-item{
    display: inline-block;
    margin: 10px;
}

@media only screen and (max-width: 760px){
    .job-item{
        margin: 5px 0px 0px 0px;
    }
}
</style>
