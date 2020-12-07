<template>
<a-layout id="components-layout-demo-fixed-sider">
    <side-bar></side-bar>
    <MobileSideBar :visible="menuVisible" />
    <a-layout :style="{ marginLeft: '200px', height: '100vh' }">
        <a-layout-header>
            <div class="hamburger-icon" @click="menuVisible = !menuVisible">
                <a-icon type="menu" class="menu-btn" style="display: none;" />
            </div>
            <a-tooltip>
                <template slot="title">
                    Đăng xuất
                </template>
                <a-icon type="logout" class="logout-btn" @click="logout()" />
            </a-tooltip>
        </a-layout-header>
        <a-layout-content :style="{ marginTop: '24px', overflow: 'initial' }">
            <div class="dashboard-content" :style="{ marginTop: '40px', padding: '24px', textAlign: 'left' }">

                <dashboard-content> </dashboard-content>

            </div>
        </a-layout-content>
        <a-layout-footer :style="{ textAlign: 'center' }">
            Vocabulary Learining ©2020 Created with <a-icon type="heart"></a-icon>
        </a-layout-footer>
    </a-layout>
</a-layout>
</template>

<script>
import SideBar from './SideBar';
import MobileSideBar from './MobileSidebar';

import DashboardContent from './Content.vue';
import AuthenticationUtils from '../../../common/AuthenticationUtils';

export default {
    components: {
        SideBar,
        DashboardContent,
        MobileSideBar
    },
    data() {
        return {
            menuVisible: false,
        }
    },
    methods: {
        logout() {
            AuthenticationUtils.logout();
            this.$router.push({ path: '/login' });
        },
        showDrawer() {
            this.menuVisible = true;
        },
    },
}
</script>

<style lang="scss">
.ant-layout-header {
    position: fixed;
    width: 90%;
    z-index: 999;
    background: #fff !important;
    padding: 0 !important;
}
@media screen and (max-width: 600px) {
    .v--modal-box {
        height: 100vh !important;
        top: 0px !important;
        bottom: 0px !important;
        padding: 20px !important;
        
    }
    .hamburger-icon {
        display: block !important;
        i {
            padding: 2px;
        background-color: white;
        border-radius: 2%;
        width: 100px;height: 66px; position: absolute;
        }
    }
    .ant-layout {
        margin-left: 0px !important;
    }

    .login {
        position: absolute !important;
        bottom: 0px;
        top: 0px;
    }
}
.hamburger-icon {
    display: none;
}
.dashboard-content {
    padding: 0px !important;
}

.ant-layout-footer {
    display: none;
}


.menu-btn {
    display: block !important;
    float: left;
    margin-top: 20px;
    margin-left: 39px;
    font-size: 26px;
    cursor: pointer;
}

.menu-btn {
    display: none;
}

#components-layout-demo-fixed-sider .logo {
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    margin: 16px;
}

.logout-btn {
    float: right;
    margin-top: 20px;
    margin-right: 39px;
    font-size: 26px;
    cursor: pointer;
}
</style>
