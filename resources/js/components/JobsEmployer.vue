<template>
    <div class="center">
        <div class="job-item" v-bind:key="job.id" v-for="job in jobs">
            <job-item-empl
                v-bind:job="job"
                v-on:details="detailsEmployer"
                v-on:deleteJob="deleteJob"
                />
        </div>
            <application-details
                v-show="isDetailsVisible"
                v-bind:applications="applications" :key="applications.lenght"
                v-on:close="close"
            />

    </div>
</template>
<script>
export default {
    name: "EmployerJobs",
    props:["jobs"],
    data(){
        return{
            user:{},
            applications:[],
            isDetailsVisible:false
        }
    },
    created(){
        if(this.$cookie.get('studoAccesToken')!=null){
            this.user.id = this.$cookie.get('studoUserId')
        }
    },
    methods:{
        detailsEmployer(apps){
            this.isDetailsVisible = true
            this.applications = []
            apps.forEach(application => {
                    this.applications.push(application)
                });
        },
        deleteJob(jobId){
            this.$emit("deleteJob", jobId)
        },
        close(){
            this.isDetailsVisible = false
        }
    }
}

</script>
<style scoped>
.job-item{
    display: inline-block;
    margin: 10px;
}

@media only screen and (max-width: 760px){
    .job-item{
        margin: 5px 0px 0px 0px;
    }
}
.center{
    text-align: center;
}
</style>

