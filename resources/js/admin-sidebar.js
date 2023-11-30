const items =[
    {
        label: 'Posts',
        icon: 'pi pi-book',
        items: [
            {
                label: 'new',
                icon: 'pi pi-plus',
                href:'/post/create'
            },
            {
                label: 'show all',
                icon: 'pi pi-list',
                href:'/post/',

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
                href: '/news/create'
            },
            {
                label: 'show all',
                icon: 'pi pi-list',
                href: '/news'
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
                href:'user/create'
            },
            {
                label: 'show all',
                icon: 'pi pi-list',
                href: 'user/index'
            }
        ]
    }
];

export default items;
