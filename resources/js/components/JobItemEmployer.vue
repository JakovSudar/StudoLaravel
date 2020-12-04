<template>
    <div
    tabindex="0"
    @click="$emit('details',job.applications)"
    class="job-item border border-black text-center rounded-top shadow">
        <div class="category rounded-top bold">{{job.category}}</div>
            <p class="employer bold">{{job.employer}}</p>
            <hr>
            <p class="position bold">{{job.title}}</p>
            <p class="city">{{job.city}}</p>
            <div class="descr-container text-center">
                <p class="description">{{job.description}}</p>
            </div>
            <p class="wage bold">{{job.wage}} kn/h</p>
            <p class="bold applied">Broj prijavljenih: {{job.applications.length}}</p>
            <button
                class="btn btn-outline-danger btn-sm mt-2"
                v-on:click.stop="del"
            >Obriši</button>
        </div>
</template>

<script>
export default {
    name:"JobItemEmployer",
    props:["job","appliedJobs"],
    methods:{
        del(){
            this.$emit("deleteJob",this.$props.job.id)
        }
    }
}
</script>

<style scoped>
.applied{
    background-color: rgb(77, 212, 77);
}
.inline{
    display: inline-block;
    width: 50%;
    font-weight: 500;
}
.applied{
    margin-top: 10px;
}
.detalji{
    cursor: pointer;
    float: left;
    border-right: 1px solid rgb(100, 100, 100);
}
.btn-hover:hover{
    background-color:rgb(199, 199, 199);
}
.prijava{
    cursor: pointer;
    float: right;
    border-left: 1px solid rgb(100, 100, 100);
}
.city{
    margin-top: 10px;
    font-size: 1.2em;
    font-weight: 600;
    letter-spacing: 0.08em;
}

.btn-cont{
    border-style: outset;
    position:relative;
    margin-top: 10px;
    width: 200px;
    background-color: rgb(223, 230, 231);
    display: inline-block;
}
.job-item{
    transition: all .1s ease-in-out;
    display: inline-block;
    width: 330px;
    height: 350px;
    outline:none;
}

.job-item:hover{
    transform: scale(1.05);
    cursor: pointer;
}
.category{
    background-color: rgb(216, 216, 216);
    padding: 3px;
}
.employer{
    margin-top: 10px;
}
.position{
    font-size: 1.25em;
}
.description{
    position: absolute;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    width:318px;
    max-height: 80px;
    overflow: auto;
    text-align: justify;
}
.bold{
    font-weight: 700;
}
.wage{
    font-size: 1.3em;
}
.descr-container{
    margin: 5px 5px 10px 5px;
    height: 70px;
    position: relative;
}
p{
    margin-block-end: 0px;
}

hr{
    margin-block-start: 5px;
    margin-block-end: 5px;
    width: 200px;
    background-color: black;
}
</style>
