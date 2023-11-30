const items =[
    {
        label: 'Posts',
        icon: 'pi pi-book',
        items: [
            {
                label: 'new',
                icon: 'pi pi-plus',
                href:'/admin/post/create'
            },
            {
                label: 'show all',
                icon: 'pi pi-list',
                href:'/admin/post/'

            }
        ]
    },
    {
        label: 'News',
        icon: 'pi pi-desktop',
        items: [
            {
                label: 'new',
                icon: 'pi pi-plus',
                href: '/admin/news/create'
            },
            {
                label: 'show all',
                icon: 'pi pi-list',
                href: '/admin/news'
            }
        ]
    },
    {
        label: 'Users',
        icon: 'pi pi-users',
        items: [
            {
                label: 'new',
                icon: 'pi pi-plus',
                href:'/admin/user/create'
            },
            {
                label: 'show all',
                icon: 'pi pi-list',
                href: '/admin/user/index'
            }
        ]
    }
];

export default items;
