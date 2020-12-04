<template>
    <nav class="navbar navbar-gradient navbar-expand-xxl navbar-dark mb-2">
        <p></p>
        <div class="custom-toggler" type="button" data-toggle="collapse" data-target="#filters" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-filter fa-2x white"></i>
        </div>
        <div class="collapse navbar-collapse" id="filters">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Grad:</label>
                            </div>
                            <select v-model="city" class="custom-select" id="inputGroupSelect01">
                                <option value="">Svi</option>
                                <option value="Osijek">Osijek</option>
                                <option value="Zagreb">Zagreb</option>
                                <option value="Split">Split</option>
                                <option value="Pula">Pula</option>
                            </select>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Vrsta:</label>
                            </div>
                            <select v-model="type" class="custom-select" id="inputGroupSelect01">
                                <option value="">Svi</option>
                                <option value="Turizam">Turizam</option>
                                <option value="Fizički posao">Fizički poslovi</option>
                                <option value="Ljepota i njega">Ljepota i njega</option>
                                <option value="Dostavljač">Dostavljač</option>
                            </select>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" id="">Satnica:</label>
                                </div>
                                <input v-model="wage" type="number" class="form-control" placeholder="Minimalna satnica">
                                <div class="input-group-append">
                                    <button
                                    class="btn-success btn btn-md"
                                    v-on:click="filter"
                                    >Primjeni</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>
<script>
export default {
    methods:{
        filter(){
            var query="?"
            if(!(this.city ==="")){
                query = query + "city="+this.city+"&"
            }
            if(!(this.type === "")){
                query = query + "category="+this.type+"&"
            }
            if(this.wage){
                query = query + "wage="+this.wage
            }

            this.$emit('filter',query)
        }
    },
    data () {
        return {
            city:"",
            type:"",
            wage:"",
        }
    }
}
</script>

<style scoped>
.custom-toggler .navbar-toggler-icon {
  background-color: brown ;
}

.custom-toggler.navbar-toggler {
  border-color: rgb(255,102,203);
}
.white{
    color : white
}
.input-group-prepend {
  width : 27%; /*adjust as needed*/
}

.input-group-prepend label {
  width: 100%;
  overflow: hidden;
}

</style>
