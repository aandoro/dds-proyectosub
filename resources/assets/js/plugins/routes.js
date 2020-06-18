import Vue from 'vue'
import VueRouter from 'vue-router';
import firebase from 'firebase'

Vue.use(VueRouter);

const routes = new VueRouter({
    routes: [{
            path: '/',
            redirect: {
                path: "/home"
            }
        },
        {
            path: '/home',
            component: require('../components/Home.vue'),
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/login',
            component: require('../components/Login.vue')
        },
        {
            path: '/challenges',
            component: require('../components/ChallengesForm.vue'),
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/challenge/new',
            component: require('../components/ChallengeEdit.vue'),
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/challenge/:id',
            component: require('../components/ChallengeEdit.vue'),
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/challenge/view/:id',
            component: require('../components/ChallengeEdit.vue'),
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/trivias',
            component: require('../components/TriviasForm.vue'),
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/trivia/new',
            component: require('../components/TriviaEdit.vue'),
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/trivia/:id',
            component: require('../components/TriviaEdit.vue'),
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/trivia/view/:id',
            component: require('../components/TriviaEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/groups',
            component: require('../components/GroupsForm.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/group/new',
            component: require('../components/GroupEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/group/:id',
            component: require('../components/GroupEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/group/view/:id',
            component: require('../components/GroupEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/species',
            component: require('../components/SpeciesForm.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/specie/new',
            component: require('../components/SpecieEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/specie/:id',
            component: require('../components/SpecieEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/specie/view/:id',
            component: require('../components/SpecieEdit.vue'),
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/users',
            component: require('../components/UsersForm.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/user/new',
            component: require('../components/UserEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/user/:id',
            component: require('../components/UserEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/user/view/:id',
            component: require('../components/UserEdit.vue'),
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/responses',
            component: require('../components/ResponsesForm.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/response/view/:id',
            component: require('../components/ResponseEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/levels',
            component: require('../components/LevelsForm.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/level/new',
            component: require('../components/LevelEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/level/:id',
            component: require('../components/LevelEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/level/view/:id',
            component: require('../components/LevelEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/locations',
            component: require('../components/LocationsForm.vue'),
            meta: {
                requiresAuth: true
            }
        },{
            path: '/location/new',
            component: require('../components/LocationEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/location/:id',
            component: require('../components/LocationEdit.vue'),
            meta: {
                requiresAuth: true
            }
        }, {
            path: '/location/view/:id',
            component: require('../components/LocationEdit.vue'),
            meta: {
                requiresAuth: true
            }
        },
    ]
});

routes.beforeEach((to, from, next) => {
    if (to.matched.some(route => route.meta.requiresAuth)) {
        const user = firebase.auth().currentUser;
        if (user) {
            next()
        } else {
            next({
                path: '/login'
            })
        }
    } else {
        next();
    }
})


export default routes