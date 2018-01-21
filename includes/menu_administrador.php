<?php
require_once("src/App.php");
require_once("src/logic/Categorias.php");
?>
<!-- Sidebar -->
<div id="sidebar">
	<div class="inner">
		<!-- Menu -->
		<nav id="menu">
			<header class="major">
				<h2>Menú</h2>
			</header>
			<ul>
				<li><a href="index.php">Página de inicio</a></li>
				<li>
					<span class="opener">Categorías</span>
					<ul>
						<?php
						$i = 1;
						// SE MUESTRAN LAS CATEGORÍAS VISIBLES QUE ESTÁN EN LA BASE DE DATOS
						$categoriasBBDD = new Categorias();
						$categoriasVisibles = $categoriasBBDD->getCategoriesVisibles();

						if(empty($categoriasVisibles)){
							$categoriasVisibles = $categoriasBBDD->getCategories('1');
						}

						foreach ($categoriasVisibles as $category) { ?>
									<li><a href="list_videos.php?categoria=<?=$i?>"><?=$category['nombre_categoria'] ?></a></li>
							<?php
							$i++;
						}
						?>
					</ul>
				</li>

				<li>
					<span class="opener">Administración</span>
					<ul>
						<li><a href="administracion.php">Panel de Administración</a></li>
						<li><a href="gestion_categorias.php">Gestionar Categorías</a></li>
						<li><a href="subir_subtitulos.php">Subir/Eliminar subtítulo</a></li>
						<li><a href="anadir_administrador.php">Añadir/Eliminar adminsitrador</a></li>
						<li><a href="subir_informacion.php">Subir información adicional</a></li>
					</ul>
				</li>
				<li><a onclick="Ejecutar('actualizar')" href="#">Actualizar la información del Blog</a></li>
			</ul>
		</nav>
	</div>
</div>