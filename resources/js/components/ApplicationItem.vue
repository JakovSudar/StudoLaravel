<template>
    <div class="wrap">
        <div class="area">
            <p class="area-title">Email: </p>{{application.email}}
        </div>
        <div class="area">
            <p class="area-title">Kontakt: </p>{{application.phone}}
        </div >
        <div class="area">
             <p class="area-title">O meni: </p><p class="about-me">{{application.about_me}}</p>
        </div>

    </div>

</template>
<script>
export default {
    name:"applicationItem",
    props:['application']
}
</script>

<style scoped>
.wrap{
    padding: 10px 10px 0px 10px;
    border-bottom: 1px solid rgb(196, 130, 33);
}
.area-title{
    min-width: 80px;
    width: 80px;
    font-weight: 700;
    padding-right: 8px;
}
.area{
     border-bottom: 1px solid #eeeeee;
     display: flex;
     justify-content:flex-start;
}
.about-me{
    white-space: pre-line;
}
</style>
