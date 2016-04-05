<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used accross all the application
    | except for auth & password
    |
    */

    /* 
    MENU
    */
    'menu' => [
        'home' => 'Inicio',
        'logout' => 'Salir',
        'users' => 'Usuario|Usuarios',
        'departments' => 'Departmento|Departmentos',
        'companies' => 'Empresa|Empresas',
        'priorities' => 'Prioridad|Prioridades',
        'positions' => 'Puesto|Puestos',
        'periods' => 'Período|Períodos',
        'objectives' => 'Objetivo|Objetivos',
        'areas' => 'Área|Áreas',
        'catalogs' => 'Catálogos',
        'rewarding' => 'Rewarding',
        'task_manager' => 'Gestor de Tareas',
        'tasks' => 'Tarea|Tareas',
        'one_page' => 'One Page',
        'reports' => 'Reporte|Reportes',
        'my_profile' => 'Mi Perfil',
        'emotions' => 'Emoción|Emociones',
        'virtues' => 'Valor|Valores',
        'dreams' => 'Sueño|Sueños',
        'assesments' => 'Assesment|Assesments',
        'assessments' => 'Assesment|Assesments',
        'education' => 'Educación',
        'industries' => 'Industria|Industrias',
        'coaches' => 'Coach|Coaches',
        'virtues' => 'Valor|Valores',

    ],

    /* ERRORS */

    'http' => [
        '200u' => 'Se actualizó la información del usuario',
        '200up' => 'Se agregó un nuevo usuario, por favor reinicie la contraseña',
        '204' => 'Eliminado',
        '204b' => 'Deshabilitado',
        '403t' => 'Accesso Restringido',
        '403' => 'El usuario actual no puede acceder al recurso',
        '404' => 'No se encontró el recurso',
        'select_company' => 'Primero es necesario seleccionar una empresa',
        'select_department' => 'Primero es necesario seleccionar un departmento',
    ],

    /*
    
    FORMS

    */

    'forms' => [
        'forgot_my_password'  => 'Olvidé mi contraseña',
        'employee_number' => 'Número de empleado',
        'name' => 'Nombre',
        'commercial_name' => 'Nombre Comercial',
        'lastname' => 'Apellido',
        'active' => 'Activo',
        'inactivo' => 'Inactivo',
        'user_details' => 'Detalles de Usuario',
        'basic_info' => 'Información Básica',
        'phone' => 'Teléfono',
        'mobile' => 'Móvil',
        'education' => 'Educación',
        'blood_type' => 'Tipo de sangre',
        'birth_date' => 'Fecha de nacimiento',
        'admission_date' => 'Fecha de admisión',
        'alergies' => 'Alergias',
        'emergency_contact' => 'Contacto de emergencia',
        'submit' => 'Enviar',
        'cancel' => 'Cancelar',
        'reset_password' => 'Resetear contraseña',
        'add_new' => 'Añadir nuevo',
        'no_progress' => 'Sin progreso',
        'some_progress' => 'Progresando',
        'completed' => 'Completado',
        'completed_on' => 'Completado el',
        'validation_error' => 'Error de validación, por favor corrija lo siguiente:',
        'gender' => 'Género',

    ],

    'new' => 'Nuevo',
    'login' => 'Entrar',
    'entries' => 'Registros',
    'modify' => 'Modificar',
    'status' => 'Estatus',
    'description' => 'Descripción',
    'asigned_to' => 'Asignado a',
    'register_progress' => 'Registrar avance',
    'select_week' => 'Seleccionar semana',
    'select_progress' => 'Seleccionar avance',
    'week' => 'Semana',
    'delete' => 'Eliminar',
    'active' => 'Activo',
    'inactivo' => 'Inactivo',
    'search' => 'Buscar',
    'disable' => 'Deshabilitar',
    'parent' => 'Padre',
    'boss' => 'Líder de Equipo',
    'actions' => 'Acción|Acciones',
    'types' => 'Tipo|Tipos',
    'edit' => 'Editar',
    'personal' => 'Personal',
    'authorized' => 'Autorizado',
    'asigned' => 'Asignado',
    'pending' => 'Pendiente',
    'success' => 'Listo',
    'confirm_delete' => 'Desea eliminar el elemento?',
    'from' => 'Desde',
    'to' => 'Hasta',
    'language' => 'Idioma',
    'lang_updated' => 'Se actualizo el idioma, actualice la página.',
    'country' => 'País',
    'select_this' => 'Seleccionar',
    'measuring_unit' => 'Unidad de medida|Unidades de medida',
    'categories' => 'Categoría|Categorias',
    'subcategories' => 'Subcategoría|Subcategorías',
    'mine' => 'Mi|Mis',
    'semaforo' => 'Semáforo',
    'actual' => 'Resultado Actual',
    'expected' => 'Resultado Esperado',
    'males' => 'Hombre|Hombres',
    'females' => 'Mujer|Mujeres',
    'dates' => 'Fecha|Fechas',
    'values' => 'Valor|Valores',
    'others' => 'Otro|Otros',
    'review' => 'Revisar',
    'users' => [
        'super_admin' => 'Super Administrador',
        'ceo' => 'CEO',
        'champion' => 'Champion',
        'coach' => 'Coach',
        'employee' => 'Empleado',
    ],

    'emotions' => [
        'pick_one' => '¿Cómo te sientes hoy?',
        'welcome' => '¡Bienvenido!',
        'agradecido' => 'Agradecido',
        'alegre' => 'Alegre',
        'ansioso' => 'Ansioso',
        'apasionado' => 'Apasionado',
        'emocionado' => 'Emocionado',
        'enojado' => 'Enojado',
        'esperanzado' => 'Esperanzado',
        'estresado' => 'Estresado',
        'frustracion' => 'Frustración',
        'inspirado' => 'Inspirado',
    ],
    'priorities' => [

        'verde' => 'Por buen camino',
        'amarillo' => 'Retrasado',
        'rojo' => 'Estoy estancado',
        'azul' => 'Terminado',
    ],
    'objectives' => [
        'target' => 'Valor Objetivo : ',
        'green' => 'Valor Verde : ',
        'yellow' => 'Valor Amarillo : ',
        'red' => 'Valor Rojo : ',
        'greater' => 'Mayor o igual a: ',
        'lesser' => 'Menor a: ',
        'period_target' => 'Semáforos para el período: ',
        'daily_target' => 'Semáforos por día: ',
        'month_target' => 'Objetivo Mensual:',
        'day_target' => 'Objetivo Diario:',
        'ignore' => 'Éste objetivo es personal y no está alineado a las metas de mi departamento ni de la empresa.',
        'inverted_goals' => 'Metas Invertidas (Menor es mejor)',
    ],

];