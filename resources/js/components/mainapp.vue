<template>
    <div >
        <div v-if="isLoggedin">
            <!--========== ADMIN SIDE MENU one ========-->
          <div class="_1side_menu" >
            <div class="_1side_menu_logo">
              <h3 style="text-align:center;">Logo Image</h3>
              <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
            </div>

            <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
            <div class="_1side_menu_content">
              <div class="_1side_menu_img_name">
                <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                <p class="_1side_menu_name">Admin</p>
              </div>

              <!--~~~ MENU LIST ~~~~~~-->
              <div class="_1side_menu_list">
                <ul class="_1side_menu_list_ul">
                  
                  <li><router-link to="/"><Icon type="ivu-icon ivu-icon-ios-appstore-outline" /> Admin</router-link></li>
                  <li><router-link to="users"><Icon type="ios-speedometer" /> User</router-link></li>
                  <li><router-link to="tags"><Icon type="ios-speedometer" /> Tags</router-link></li>
                  <li><router-link to="categorys"><Icon type="ios-speedometer" /> Category</router-link></li>
                </ul>
              </div>
            </div>
          </div>
          <!--========== ADMIN SIDE MENU ========-->

          <!--========= HEADER ==========-->
          <div class="header">
            <div class="_2menu _box_shadow">
              <div class="_2menu_logo">
                <ul class="open_button">
                  <li>
                    <Icon type="ios-list" />
                  </li>
                  <!--<li><Icon type="ios-albums" /></li>-->
                </ul>
              </div>
            </div>
          </div>
        </div>
      <!--========= HEADER ==========-->
         <router-view></router-view>
    </div>   
</template>


<script>
export default {
    date(){
      return{
        isLoggedin :false
      }
    }
}
</script>
