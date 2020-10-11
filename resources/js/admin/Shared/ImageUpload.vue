<template>
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Image</div>
                    <div class="card-body">
                       <div class="row">

                          <div class="col-md-9">
                              <input type="file" v-on:change="onImageChange" class="form-control">
                          </div>
                           <div class="col-md-3" v-if="image">
                              <img :src="image" class="img-responsive" width="90">
                           </div>

                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                image: ''
            }
        },
        methods: {
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            uploadImage(){
                axios.post('/image/store',{image: this.image}).then(response => {
                   console.log(response);
                });
            }
        }
    }
</script>
