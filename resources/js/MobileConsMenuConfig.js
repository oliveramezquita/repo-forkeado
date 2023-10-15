const MobileConsMenuConfig = [
  {
    title: "Perfil",
    icon: 'fa-light fa-user',
    routeName: 'profile.edit',
  },
  {
    title: "Mensajería",
    icon: 'fa-light fa-message',
    routeName: 'messaging.show',
  },
  {
    title: "Inicio",
    icon: 'fa-light fa-house',
    routeName: 'dashboard',
  },
  {
    title: "Notificaciones",
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

export default MobileConsMenuConfig