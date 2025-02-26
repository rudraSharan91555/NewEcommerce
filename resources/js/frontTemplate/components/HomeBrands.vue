<template>
    <div class="instagram-post-area">
               <div class="container-fluid p-0 fix">
                   <div class="row no-gutters insta-active">

                       <div v-for="item in homeBrands" class="col">
                           <div class="insta-post-item">
                               <a href="#">
                                   <i class="fab fa-instagram"></i>
                                   <img style="height: 300px; width:300px" :src="item.image" alt="">
                               </a>
                           </div>
                       </div>

                    
                     
                   </div>
               </div>
           </div>
</template>
<script>
export default{
  name:'HomeBrands',
  props:{
   homeBrands:[]
  }
}
</script>