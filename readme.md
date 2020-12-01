<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>


# Códigos de estados base de datos

+ tipo estado = 1 -> estados del brief
+ tipo estado = 2 -> estados de etapas
+ tipo estado = 3 -> estados de actividades

# Códigos de logs base de datos

+ tipo log = 1 -> estados del brief
+ tipo log = 2 -> estados de las actividades

* origen_id: para el caso de estados del brief es campania_id, para el caso de actividades, es actividad_id (identificar el origen del log)


# Por hacer
+ mostrar la categoría de la campaña 
+ revisar en qué parte agregar la categoría a la campaña

+ Eliminar el controlador de google drive
+ Terminar la última etapa, mirar en caso de que no agreguen "creatividad" como cambio el estado de la siguiente, arreglar en caso de que no tenga la etapa asignada antes de marcar como finalizado (como cambio el estado)

+ Definir el cambio de fase en planear ejecución
+ Revisar el mimetype 
+ Al crear campania, asignar etapas de una vez 
+ arreglar el select de crear campania (clientes) 

- mostrar un mensaje en caso de que la campaña no tenga archivos 
- tiempo de vencimiento de sesión drive 
- validaciones en crear carpeta drive
- En el gantt arreglar la creación actividades (entregables)
- Terminar lo de las etapass
- Averiguar la forma de cambiar la url de campania etapas, a cambio de enviar campania_id y etapa_id, enviar campaniaetapa_id 
- asignación de roles, poblar la base de datos nuevamente, asignación de actividades
- Todo lo de roles
- Poner botones de gantt y roles
- Definir y aclarar como se manejan los entregables para el cliente en la parte de planear ejecución (que no se confundan con los entregables internos de la agencia)

- Agregar los logs de cambio de estado