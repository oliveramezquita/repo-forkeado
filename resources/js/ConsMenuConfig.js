const ConsMenuConfig = [
  {
    label: 'Home',
    icon: 'fa-light fa-house',
    routeName: 'dashboard',
  },
  {
    label: 'Grupos',
    icon: 'fa-light fa-user-group',
    drop: 'true',
    submenu: [
      {
        label: 'Colectivos',
        routeName: 'group.show',
        permissionName: 'group.show'
      },
      { label: 'Individuales',
        routeName: 'group.individual.show' ,
        permissionName: 'group.individual.show'
      },
      { label: 'Cuadrante',
        routeName: 'group.grid.show',
        permissionName: 'group.grid.show'
      },
      { label: 'Cambiar de fecha',
        routeName: 'group.schedule.show',
        permissionName: 'group.schedule.show'
      },
    ],
  },
  {
    label: 'Currículo',
    icon: 'fa-light fa-pen-to-square',
    drop: 'true',
    submenu: [
      {
        label: 'Plan de Estudios',
        routeName: 'syllabi.show',
        permissionName: 'syllabi.show'
      },
      { 
        label: 'Elementos',
        routeName: 'syllabi.elements.show',
        permissionName: 'syllabi.elements.show'
      },
      {
        label: 'Departamentos',
        routeName: 'department.show',
        permissionName: 'department.show'
      },
    ],
  },
  {
    label: 'Alumnado',
    icon: 'fa-light fa-circle-user',
    drop: 'true',
    submenu: [
      { 
        label: 'Lista',
        routeName: 'student.show',
        permissionName: 'student.show'
      },
      {
        label: 'Nueva Alta',
        routeName: 'student.register.show',
        permissionName: 'student.register.show'
      },
      { 
        label: 'Solicitudes',
        routeName: 'student.request.show',
        permissionName: 'student.request.show'
      },
    ],
  },
  {
    label: 'Personal',
    icon: 'fa-light fa-address-card',
    drop: 'true',
    submenu: [
      { 
        label: 'Lista',
        routeName: 'staff.show',
        permissionName: 'staff.show'
      }, 
      { 
        label: 'Consulta Diario',
        routeName: 'staff.diary.show',
        permissionName: 'staff.diary.show'
      }, 
      { 
        label: 'Sustituciones',
        routeName: 'staff.substitution.show',
        permissionName: 'staff.substitution.show'
      },
    ],
  },
  {
    label: 'Agrupaciones',
    icon: 'fa-light fa-music',
    drop: 'true',
    submenu: [
      { 
        label: 'Lista',
        routeName: 'grouping.show',
        permissionName: 'grouping.show'
      },
      {
        label: 'Miembros',
        routeName: 'grouping.member.show',
        permissionName: 'grouping.member.show'
      }, 
      {
        label: 'Instrumentos',
        routeName: 'grouping.instrument.show',
        permissionName: 'grouping.instrument.show'
      }, 
      {
        label: 'Eventos',
        routeName: 'grouping.event.show',
        permissionName: 'grouping.event.show'
      },
      {
        label: 'Ensayos',
        routeName: 'grouping.rehearsal.show',
        permissionName: 'grouping.rehearsal.show'
      },
      { 
        label: 'Partituras',
        routeName: 'grouping.sheet.show',
        permissionName: 'grouping.sheet.show'
      }, 
    ],
  },
  {
    label: 'Inventario',
    icon: 'fa-light fa-notebook',
    drop: 'true',
    submenu: [
      { 
        label: 'Lista',
        routeName:'inventory.show',
        permissionName: 'inventory.show'
      },
      { 
        label: 'Historial',
        routeName:'inventory.log.show',
        permissionName: 'inventory.log.show'
      },
    ],
  },
  {
    label: 'Evaluación',
    icon: 'fa-light fa-star',
    drop: 'true',
    submenu: [
      { 
        label: 'Evaluación Docente',
        routeName:'evaluation.show',
        permissionName: 'evaluation.show'
      },
      { 
        label: 'Sesión de Evaluación',
        routeName:'evaluation.session.show',
        permissionName: 'evaluation.session.show'
      },
      { 
        label: 'Estadistcas',
        routeName: 'evaluation.statistic.show',
        permissionName: 'evaluation.statistic.show'
      },
    ],
  },
  // {
  //   label: ' Centro',
  //   icon: 'fa-light fa-question',
  //   routeName: 'center',
  // },
  {
    label: 'Docente',
    icon: 'fa-light fa-graduation-cap',
    drop: 'true',
    submenu: [
      { 
        label: 'Cuaderno del profesor',
        routeName: 'teacher.diary.show',
        permissionName: 'teacher.diary.show'
      },
      { 
        label: 'Firma Jornada',
        routeName: 'teacher.signature.show',  
        permissionName: 'teacher.signature.show'
      },
    ],
  },
  {
    label: 'Utiles',
    icon: 'fa-light fa-paperclip',
    drop: 'true',
    submenu: [
      { 
        label: 'Calendario',
        routeName: 'utility.calendar.show',
        permissionName: 'utility.calendar.show'
      },
      { 
        label: 'Horario',
        routeName: 'utility.schedule.show',
        permissionName: 'utility.schedule.show'
      },
      { 
        label: 'Repositorio',
        routeName: 'utility.repository.show',
        permissionName: 'utility.repository.show'
      },
      { 
        label: 'Incidencias',
        routeName: 'utility.incidence.show',
        permissionName: 'utility.incidence.show'
      },
      { 
        label: 'Aulas',
        routeName: 'utility.classroom.show',
        permissionName: 'utility.classroom.show'
      },
      { 
        label: 'Historial Registro',
        routeName: 'utility.log.show',
        permissionName: 'utility.log.show'
      },
      { 
        label: 'Asistencia',
        routeName: 'utility.assistance.show',
        permissionName: 'utility.assistance.show'
      },
    ],
  },
  {
    label: 'Ayuda',
    icon: 'fa-light fa-circle-question',
    drop: 'true',
    submenu: [
      {
        label: 'Tutoriales',
        routeName: 'help.tutorial.show',
        permissionName: 'help.tutorial.show'
      },
      {
        label: 'Soporte',
        routeName: 'help.support.show',
        permissionName: 'help.support.show'
      },
      {
        label: 'Sugerencias',
        routeName: 'help.suggestion.show',
        permissionName: 'help.suggestion.show'
      }
    ],
  },
]

export default ConsMenuConfig