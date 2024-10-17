//example routes file
export default [
    {
        path: '/',
        name: 'welcome',
        component: () => import('../views/welcome')
    },
    {
        path: '/about',
        name: 'about',
        component: () => import('../views/about')
    }
]