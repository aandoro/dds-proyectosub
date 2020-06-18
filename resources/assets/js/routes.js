import VueRouter from 'vue-router';

let routes = [{
        path: '/',
        redirect: {
            path: "/home"
        }
    },
    {
        path: '/home',
        component: require('./components/Home.vue')
    },
    {
        path: '/login',
        component: require('./components/Login.vue')
    },
    {
        path: '/challenges',
        component: require('./components/ChallengesForm.vue')
    },
    {
        path: '/challenge/new',
        component: require('./components/ChallengeEdit.vue')
    },
    {
        path: '/challenge/:id',
        component: require('./components/ChallengeEdit.vue')
    },
    {
        path: '/challenge/view/:id',
        component: require('./components/ChallengeEdit.vue')
    },
    {
        path: '/trivias',
        component: require('./components/TriviasForm.vue')
    },
    {
        path: '/trivia/new',
        component: require('./components/TriviaEdit.vue')
    },
    {
        path: '/trivia/:id',
        component: require('./components/TriviaEdit.vue')
    },
    {
        path: '/trivia/view/:id',
        component: require('./components/TriviaEdit.vue')
    }, {
        path: '/groups',
        component: require('./components/GroupsForm.vue')
    }, {
        path: '/group/new',
        component: require('./components/GroupEdit.vue')
    }, {
        path: '/group/:id',
        component: require('./components/GroupEdit.vue')
    }, {
        path: '/group/view/:id',
        component: require('./components/GroupEdit.vue')
    }, {
        path: '/species',
        component: require('./components/SpeciesForm.vue')
    }, {
        path: '/specie/new',
        component: require('./components/SpecieEdit.vue')
    }, {
        path: '/specie/:id',
        component: require('./components/SpecieEdit.vue')
    }, {
        path: '/specie/view/:id',
        component: require('./components/SpecieEdit.vue')
    },
    {
        path: '/users',
        component: require('./components/UsersForm.vue')
    }, {
        path: '/user/new',
        component: require('./components/UserEdit.vue')
    }, {
        path: '/user/:id',
        component: require('./components/UserEdit.vue')
    }, {
        path: '/user/view/:id',
        component: require('./components/UserEdit.vue')
    },
    {
        path: '/responses',
        component: require('./components/ResponsesForm.vue')
    }, {
        path: '/response/view/:id',
        component: require('./components/ResponseEdit.vue')
    }, {
        path: '/levels',
        component: require('./components/LevelsForm.vue')
    }, {
        path: '/level/new',
        component: require('./components/LevelEdit.vue')
    }, {
        path: '/level/:id',
        component: require('./components/LevelEdit.vue')
    }, {
        path: '/level/view/:id',
        component: require('./components/LevelEdit.vue')
    },
];

export default new VueRouter({
    routes
});