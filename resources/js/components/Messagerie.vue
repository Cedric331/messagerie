<template>
  <div class="container my-5 py-5 px-md-5 z-depth-1">


    <section class="text-center text-lg-left dark-grey-text">

        <div class="text-center font-weight-bold"><span>4</span> comments</div>

        <div class="media d-block d-md-flex mt-4">
            <div class="media-body text-center text-md-left ml-md-3 ml-0">
               <div v-for="message in messages" :key="message.id">
                  <p class="font-weight-bold my-0">
                    {{ message.name }}
                    <a href="" class="pull-right ml-1">
                      <i class="fas fa-reply"></i>
                    </a>
                  </p>
                  <p>
                     {{ message.message }}
                  </p>
               </div>

            </div>
        </div>
    </section>
  </div>
</template>

<script>
    export default {
  props: ['messages'],

    }
</script>
