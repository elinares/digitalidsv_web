<div align="center">
  <img src="http://toolboxsv.com/git/hackathon0118/icon_blue.png" width="200" />
</div>

# Digital ID SV

Digital ID SV es un proyecto basado en blockchain el cual busca decentralizar la información de las personas a través de la distribución de los segmentos de información en diferentes bloques en una cadena. A través de esta segmentación se logrará que las entidades puedan consultar solo la información necesaria para ellos la cual se mantiene inmutable en la red blockchain.

## Elementos Web

A continuación se describen los elementos web desarrollados y que funcionan en conjunto con la red blockchain.

### Registro de Entidades

![Landing para registro de entidades](http://toolboxsv.com/git/hackathon0118/entidades.png)

Se creó una landing page la cual permite registrar las diversas entidades que quieran consultar la información de las personas a través de la app. En este registro se tiene la posibilidad de seleccionar el tipo de información que la entidad requiere así como el registro de usuario para ingresar desde la app.

### API

Se desarrollo una API que permitiera la conexión tanto con el blockchain como con la base de datos *(contenida en el archivo digitalidsv.sql)*. A continuación se describen los endpoints creados para la API:

 - Registro
		 - Endpoint: [URL_BASE]/api.php?mode=users&id=register
		 - Descripción: Permite añadir un nuevo usuario, ingresando los datos, usuario, 		contraseña	y número de teléfono.
 - Login
		 - Endpoint: [URL_BASE]/api.php?mode=users&id=login
		 - Descripción: Permite hacer el inicio de sesión a través del nombre de usuario y contraseña del usuario.
 - Login de entidad
		 - Endpoint: [URL_BASE]/api.php?mode=entity&id=login
		 - Descripción: Permite hacer el inicio de sesión de la entidad a través de su correo electrónico y contraseña.
 - Adición de fragmento
		 - Endpoint: [URL_BASE]/api.php?mode=fragments&id=add
		 - Descripción: Permite añadir fragmentos y sus diferentes tipos, los cuales son añadidos al blockchain y referenciados en la base de datos.
 - Obtener fragmentos
		 - Endpoint: [URL_BASE]/api.php?mode=fragments&id=get
		 - Descripción: Permite obtener fragmentos de información según el tipo de entidad que la requiere y de que usuario desea obtenerla.