<template>
<div class="centered-container">
    <md-content class="md-elevation-3 login">

        <div class="title">
            <img src="https://vuematerial.io/assets/logo-color.png">
            <div class="md-title">Internal Tool</div>
        </div>

        <div class="form">
            <md-field>
                <label>Username</label>
                <md-input type="text" :name="`${_uid}_name`" data-vv-validate-on="none" data-vv-as="name" v-validate="'required|max:30'" data-vv-scope="general" v-model="name" @keyup.enter="submit" autofocus></md-input>

            </md-field>
            <div v-if="errors.has(`general.${_uid}_name`)">
                <md-icon class="md-accent">warning</md-icon>
                This field is required
            </div>
            <md-field md-has-password>
                <label>Password</label>
                <md-input v-model="password" type="password" :name="`${_uid}_password`" data-vv-validate-on="none" data-vv-as="password" v-validate="'required|max:30'" data-vv-scope="general" @keyup.enter="submit"></md-input>
            </md-field>
            <div v-if="errors.has(`general.${_uid}_password`)">
                <md-icon class="md-accent">warning</md-icon>
                This field is required
            </div>
        </div>

        <div class="actions md-layout md-alignment-center-space-between" style="float: left; display: none;">
            <a style="color: black;" @click="redirectToRegister()">Đăng ký tài khoản</a>
        </div>

        <div class="actions md-layout md-alignment-center">
            <a-button type="primary" size="large" @click="submit" style="width: 100%">Login</a-button>
        </div>

        <div class="loading-overlay" v-if="loading">
            <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
        </div>

    </md-content>
    <div class="background" />
</div>
</template>

<script>
import rf from '../requests/RequestFactory';
import AuthenticationUtils from '../common/AuthenticationUtils';

export default {
    name: 'LoginPage',
    data() {
        return {
            name: '',
            password: '',
            isLoading: false,
            loading: false
        };
    },
    mounted() {
        this.name = this.$route.query.name;
    },
    methods: {
        redirectToRegister() {
            this.$router.push({ name: 'Register' });
        },
        async submit() {
            Promise.all([
                this.$validator.validateAll('general'),
            ]).then(() => {
                if (this.errors.any()) {
                    return;
                }
                const params = {
                    name: this.name,
                    password: this.password,
                };
                this.login(params);
            });
        },
        login(params) {
            const loading = this.$message.loading('Đang tải ...', 0);

            return rf.getRequest('UserRequest').login(params).then(async (response) => {
                // this.loading = true;
                await AuthenticationUtils.login(response);
                rf.getRequest('UserRequest').getCurrentUser().then((user) => {
                    if (user.role == 2) {
                        this.$router.push({ path: '/admin' });
                    } else {
                        this.$router.push({ path: '/' });
                    }
                });
            }).catch(async (error) => {
                this.$message.error('Tài khoản hoặc mật khẩu không đúng', 2);
            }).finally(() => {
                loading();
            });
        },
    },
};
</script>

<style lang="scss">
.centered-container {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    height: 100vh;

    .title {
        text-align: center;
        margin-bottom: 30px;

        img {
            margin-bottom: 16px;
            max-width: 250px !important;
        }
    }

    .actions {
        .md-button {
            margin: 0;
        }
    }

    .form {
        margin-bottom: 60px;
    }

    .background {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        z-index: 0;
    }

    .md-content {
        z-index: 1;
        padding: 40px;
        width: 100%;
        max-width: 400px;
        position: relative;
    }

    .loading-overlay {
        z-index: 10;
        top: 0;
        left: 0;
        right: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
    }
}
</style>
