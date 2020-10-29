<template>
<a-layout-sider class="sidebar-pc" :style="{ overflow: 'auto', height: '100vh', position: 'fixed', left: 0 }">
    <div class="logo" />
    <a-menu theme="dark"  :inline-collapsed="collapsed" @click="handleClick">

        <a-menu-item key="1">
            <a-icon type="book" />
            <span class="nav-text">Quản lý từ</span>
        </a-menu-item>
        <a-menu-item key="2">
            <a-icon type="sketch" />
            <span class="nav-text">Trò chơi</span>
        </a-menu-item>
        <a-menu-item key="3">
            <a-icon type="schedule" />
            <span class="nav-text">Nhắc từ</span>
        </a-menu-item>
        <a-menu-item key="4">
            <a-icon type="user" />
            <span class="nav-text">Tôi</span>
        </a-menu-item>
    </a-menu>
</a-layout-sider>
</template>

<script>
export default {
    data() {
        return {
            items: [{
                    key: 1,
                    routerName: 'Dashboard'
                },
                {
                    key: 2,
                    routerName: 'Game'
                },
                {
                    key: 3,
                    routerName: 'Schedule'
                },
                {
                    key: 4,
                    routerName: 'AboutMe'
                }
            ]
        }
    },
    methods: {
        handleClick(e) {
            this.$router.push({
                name: this.items[e.key - 1].routerName
            });
        }
    },
}
</script>

<style lang="scss" scoped>
@media screen and (max-width: 600px) {
    .sidebar-pc {
        display: none;
    }
}
</style>
