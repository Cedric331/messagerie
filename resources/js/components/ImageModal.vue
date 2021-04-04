<template>
<div class="modal fade" id="modalYT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-body mb-0 p-0">
        <div class="embed-responsive embed-responsive-16by9">
            <img class="embed-responsive-item" :src="'/storage/image/images/'+channel+'/'+image">
        </div>
        <button @click="upload" class="btn btn-dark btn-block">Télécharger</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  methods: {
     upload(){
        axios.post('/upload/image', {
           image: this.image,
           channel: this.channel
        }).then(res => {
          this.forceFileDownload(res)
        }).catch(err => {

        })
     },
      async forceFileDownload(file){

      let blob = new Blob([file.data], {type:'application/*'})
      let link = document.createElement('a')
      link.href = window.URL.createObjectURL(blob)
      link.download = this.image
      link._target = 'blank'
      link.click();
   }
  },
  props: ['channel', 'image'],

}
</script>