# Página pueba de papirhos

La página copia el estilo de la pagina de [Papirhos](http://texedores.matem.unam.mx/publicaciones/index.html)
y agrega las funciones de agregar/eliminar autor, ver los libros en la base de datos y sus respectivos autores, 
además tiene (aún en construcción) una forma para vender los libros, faltan bastantes funciones que eventualmente 
estarán disponibles (creo) pero que aún no he pensado cómo hacerlas o no me han salido como lo son:
- Agregar libros de forma adecuada
- Mejorar la forma de agregar autores (agregar autores sin que estos tengan libro)
- Ventas (buena interfaz y que funcione)
- Inventarios
- Log in

Para lo anterior aún falta pensar bien como hacer las tablas que guardarán la información (inventarios, ventas)
y definir exactamente las tablas existentes.
La base de datos que uso para esta página es muy parecida a la dada pero no es la misma, cambié los id de libros y autores
por numeros auto incrementables y les puse otro nombre a las tablas como _libros_aux_ en lugar de _libros_ como era 
originalmente, por lo que usar la BD dada es necesario.

## Página principal
![index_ss](https://user-images.githubusercontent.com/18238011/61589503-54dd8000-ab70-11e9-8bab-2ab867d52db5.png)

## Lista de Autores
![autores_ss](https://user-images.githubusercontent.com/18238011/61589530-a554dd80-ab70-11e9-9617-dd36deb80a69.png)

## Libros escritos por cierto autor
![libtos_autor_ss](https://user-images.githubusercontent.com/18238011/61589538-cd444100-ab70-11e9-8b2e-9b87723e3e4f.png)
