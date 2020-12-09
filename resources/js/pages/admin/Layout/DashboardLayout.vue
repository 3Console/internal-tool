<template>
  <div class="wrapper">
    <notifications></notifications>

    <side-bar>
      <mobile-menu slot="content"></mobile-menu>
      <sidebar-link to="/admin/dashboard">
        <md-icon>dashboard</md-icon>
        <p>Dashboard</p>
      </sidebar-link>
      <sidebar-link to="/admin/employee">
        <md-icon>content_paste</md-icon>
        <p>Employee</p>
      </sidebar-link>
      <sidebar-link to="/admin/project">
        <md-icon>content_paste</md-icon>
        <p>Project</p>
      </sidebar-link>
      <sidebar-link to="/admin/absence">
        <md-icon>content_paste</md-icon>
        <p>Absence Management</p>
      </sidebar-link>
      <sidebar-link to="/admin/overtime">
        <md-icon>content_paste</md-icon>
        <p>Overtime Management</p>
      </sidebar-link>
      <sidebar-link to="/admin/salary">
        <md-icon>content_paste</md-icon>
        <p>Pay slip</p>
      </sidebar-link>
    </side-bar>

    <div class="main-panel">
      <top-navbar></top-navbar>

      <dashboard-content>

      </dashboard-content>

      <content-footer v-if="!$route.meta.hideFooter"></content-footer>
    </div>
  </div>
</template>
<style lang="scss">

</style>
<script>
import TopNavbar from './TopNavbar.vue'
import ContentFooter from './ContentFooter.vue'
import DashboardContent from './Content.vue'
import MobileMenu from '@/pages/admin/Layout/MobileMenu.vue'

export default {
  components: {
    TopNavbar,
    DashboardContent,
    ContentFooter,
    MobileMenu
  }
}
</script>
