const MobileSchoolMenuConfig = [
  {
    icon: 'fa-light fa-user',
    routeName: 'profile.edit',
  },
  {
    icon: 'fa-light fa-message',
    routeName: 'messaging.show',
  },
  {
    icon: 'fa-light fa-house',
    routeName: 'dashboard',
  },
  {
    icon: 'fa-light fa-bell',
    routeName: 'dashboard', // TODO: currently developing notifications
  },
  {
    icon: 'fa-regular fa-bars',
    drop: 'true',
    submenu: [
      // {
      //   label: '',
      //   icon: 'fa-regular',
      //   routeName: '',
      //   permissionName: ''
      // },
    ],
  }
]

export default MobileSchoolMenuConfig