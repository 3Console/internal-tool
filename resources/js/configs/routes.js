import Login from '@/pages/LoginPage.vue';
import Register from '@/pages/RegisterPage.vue';

import AdminDashboardLayout from '@/pages/admin/Layout/DashboardLayout.vue'
import AdminDashboard from '@/pages/admin/Dashboard.vue';
import AdminEmployee from '@/pages/admin/Employee.vue';
import AbsenceManagement from '@/pages/admin/AbsenceManagement.vue';
import AbsenceManagementDetail from '@/pages/admin/AbsenceManagementDetail.vue';
import OTManagement from '@/pages/admin/OTManagement.vue';
import OTManagementDetail from '@/pages/admin/OTManagementDetail.vue';
import SalaryManagement from '@/pages/admin/SalaryManagement.vue';
import Project from '@/pages/admin/Project.vue';
import ProjectMember from '@/pages/admin/ProjectMember.vue';

import UserDashboardLayout from '@/pages/user/Layout/DashboardLayout.vue'
import WordList from '@/pages/user/WordList.vue';
import Category from '@/pages/user/Category.vue';
import Phrase from '@/pages/user/Phrase.vue';
import CategoryDetail from '@/pages/user/CategoryDetail.vue';
import GameList from '@/pages/user/GameList.vue';
import AboutMe from '@/pages/user/AboutMe.vue';
import Game1 from '@/pages/user/game/Game1.vue';
import Game3 from '@/pages/user/game/Game3.vue';
import Schedule from '@/pages/user/Schedule.vue';
import Absence from '@/pages/user/Absence.vue';
import Overtime from '@/pages/user/Overtime.vue';
import PaySlip from '@/pages/user/PaySlip.vue';
import PaySlipDetail from '@/pages/user/PaySlipDetail';
import MyProject from '@/pages/user/MyProject';
import MyProjectDetail from '@/pages/user/MyProjectDetail';
import Notification from '@/pages/user/Notification';


export default {
    mode: 'history',
    routes: [{
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/register',
            name: 'Register',
            component: Register
        },
        {
            path: '/',
            component: UserDashboardLayout,
            redirect: '/',
            children: [{
                    path: '/',
                    name: 'Dashboard',
                    component: Category,
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: 'word-list',
                    name: 'WordList',
                    component: WordList,
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: 'games',
                    name: 'Game',
                    component: GameList,
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: 'me',
                    name: 'AboutMe',
                    component: AboutMe,
                    meta: {
                        requiresAuth: true
                    }

                },
                {
                    path: 'category',
                    name: 'Category',
                    component: Category,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'category/phrase',
                    name: 'Phrase',
                    component: Phrase,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'category/:slug',
                    name: 'CategoryDetail',
                    component: CategoryDetail,
                    props: true,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'schedule',
                    name: 'Schedule',
                    component: Schedule,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'absence',
                    name: 'Absence',
                    component: Absence,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'overtime',
                    name: 'Overtime',
                    component: Overtime,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'payslip',
                    name: 'PaySlip',
                    component: PaySlip,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'payslip/:id',
                    name: 'PaySlipDetail',
                    component: PaySlipDetail,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'project',
                    name: 'MyProject',
                    component: MyProject,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'project/:id',
                    name: 'MyProjectDetail',
                    component: MyProjectDetail,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'notifications',
                    name: 'Notification',
                    component: Notification,
                    meta: {
                        requiresAuth: true
                    }
                }
            ]
        },
        {
            path: '/admin',
            component: AdminDashboardLayout,
            redirect: '/admin/dashboard',
            children: [{
                    path: 'dashboard',
                    name: 'Dashboard',
                    component: AdminDashboard,
                    meta: {
                        requiresAdmin: true
                    }
                },
                {
                    path: 'employee',
                    name: 'Employee',
                    component: AdminEmployee,
                    meta: {
                        requiresAdmin: true
                    }
                },
                {
                    path: 'absence',
                    name: 'Absence Management',
                    component: AbsenceManagement,
                    meta: {
                        requiresAdmin: true
                    }
                },
                {
                    path: 'absence/:id',
                    name: 'Absence Management Detail',
                    component: AbsenceManagementDetail,
                    meta: {
                        requiresAdmin: true
                    }
                },
                {
                    path: 'overtime',
                    name: 'Overtime Management',
                    component: OTManagement,
                    meta: {
                        requiresAdmin: true
                    }
                },
                {
                    path: 'overtime/:id',
                    name: 'Overtime Management Detail',
                    component: OTManagementDetail,
                    meta: {
                        requiresAdmin: true
                    }
                },
                {
                    path: 'salary',
                    name: 'Pay Slip',
                    component: SalaryManagement,
                    meta: {
                        requiresAdmin: true
                    }
                },
                {
                    path: 'project',
                    name: 'Project',
                    component: Project,
                    meta: {
                        requiresAdmin: true
                    }
                },
                {
                    path: 'project/:id',
                    name: 'Project Member',
                    component: ProjectMember,
                    meta: {
                        requiresAdmin: true
                    }
                },
            ]
        }
    ]
}