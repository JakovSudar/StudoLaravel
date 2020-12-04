<template>
    <div>
        <div class="job-item" v-bind:key="job.id" v-for="job in jobs">
            <job-item
                v-bind:job="job"
                v-on:details="$emit('details',job.id)"
                v-on:prijava="$emit('prijava',job.id)"
                v-on:close="$emit('close')"
                />
        </div>
    </div>
</template>

<script>

export default {
    name: "Jobs",
    props:["jobs"],
    data(){
        return{
            user:{},
        }
    },
    created(){
        if(this.$cookie.get('studoAccesToken')!=null){
            this.user.id = this.$cookie.get('studoUserId')
        }
    },

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

</style>
