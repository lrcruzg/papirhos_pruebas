# Página pueba de papirhos

La página copia el estilo de la pagina de [Papirhos](http://texedores.matem.unam.mx/publicaciones/index.html)
para añadir las funciones de agregar/eliminar autor, ver los libros en la base de datos y sus respectivos autores, 
tener control del inventario de libros, además tiene (aún en construcción) un formulario para vender los libros, 
faltan bastantes funciones que eventualmente estarán disponibles (creo) pero que aún no he pensado cómo hacerlas 
o no me han salido como lo son:
- Agregar libros de forma adecuada
- Mejorar la forma de agregar autores (agregar autores sin que estos tengan libro)
- Ventas (agregar la fecha de venta, la persona que vende y cosa por el estilo)
- Inventarios (opción de actualizar el inventario y mostrarlo)
- Log in 

Para lo anterior aún falta pensar bien como hacer las tablas que guardarán la información (inventarios, ventas)
y definir exactamente las tablas existentes.
La base de datos que uso para esta página es muy parecida a la dada pero no es la misma, cambié los id de libros y autores
por numeros auto incrementables y les puse otro nombre a las tablas como _libros_aux_ en lugar de _libros_ como era 
originalmente, por lo que usar la BD dada es necesario.

## Página principal
![index2_ss](https://user-images.githubusercontent.com/18238011/61854535-e5270800-ae83-11e9-81bb-9bbc45366da2.png)

## Lista de Autores
![autores2_ss](https://user-images.githubusercontent.com/18238011/61854597-0b4ca800-ae84-11e9-95ab-6500e56bb990.png)

## Libros escritos por cierto autor
![libros_autor2_ss](https://user-images.githubusercontent.com/18238011/61854627-1bfd1e00-ae84-11e9-8386-78ffe1d8855e.png)

## Lista de Libros
![libros2_ss](https://user-images.githubusercontent.com/18238011/61854756-5c5c9c00-ae84-11e9-91ca-40abe05ba2ca.png)

## Página de Ventas
![ventas2_ss](https://user-images.githubusercontent.com/18238011/61854689-3df6a080-ae84-11e9-979c-afe2f40f29b3.png)
