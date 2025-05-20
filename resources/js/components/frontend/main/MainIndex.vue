<template>

   <HeaderSwiper></HeaderSwiper>

   <div class="container">
      <div class="row">
         <div class="col-md-6">
            <BoxResults
               icon_lg='icon_g'
               title_lg='Liga mistrzów'
               take_part="50 osób"
               left_day="7 dni"
               link="/link"
               results_list
            ></BoxResults>
         </div>
         <div class="col-md-6">
            <BoxResults
               icon_lg='icon_f'
               title_lg='Liga mistrzów Cash'
               take_part="13 osób"
               left_day="27 dni"
               link="/link"
               results_list
            ></BoxResults>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <BoxResults
               icon_lg='icon_c'
               title_lg='Konkursy i Akcje Sprzedażowe'
               take_part="50 osób"
               left_day="7 dni"
               link="/link"
               swiper
            ></BoxResults>
         </div>
         <div class="col-md-6">
            <BoxResults
               icon_lg='icon_t'
               title_lg='Zadania specjalne'
               take_part="13 osób"
               left_day="27 dni"
               month="Maj - czerwiec"
               link="/link"
               results_list
               spacer
            ></BoxResults>
         </div>
      </div>

      <div class="row">
         <div class="col">
            <Card
               icon_lg='icon_r'
               title_lg='Pojedynki'
            >
            </Card>
         </div>
      </div>
   </div>

</template>


<script>
   import BoxResults from '../../../components/frontend/subcomponents/BoxResults'
   import Card from '../../../components/frontend/subcomponents/Card'
   import HeaderSwiper from '../../../components/frontend/subcomponents/HeaderSwiper'

   export default {
      components: {
         HeaderSwiper,
         BoxResults,
         Card
      }
   }
</script>
