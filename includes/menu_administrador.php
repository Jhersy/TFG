<?php
require_once("src/App.php");
require_once("scraping.php");
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
							$i = 0;
							//SI SE MUESTRA CATEGORIAS DE LA BBDD, PASAR EN VALUE OTRO CAMPO INDICANDO QUE SE MIRE EN LA BBDD
							$categoriasBBDD = new Categorias();
							$categoriasVisibles = $categoriasBBDD->getCategoriesVisibles();
							$categoriaScraping = false;

							//Si no hay categorías visibles, recoge vía scrapping las del blog
							if(empty($categoriasVisibles)){
								$categoriasVisibles = getAllCategories();
								$categoriaScraping = true;
							}

							foreach ($categoriasVisibles as $category) { ?>
										<li><a href="list_videos.php?categoria=<?=$categoriaScraping ?  $i : $category['id_categoria'] . "|" . $category['nombre_categoria']?>"><?= $categoriaScraping ?  $category : $category['nombre_categoria']?></a></li>
								<?php
								$i++;
							}
							?>
							</ul>
						</li>

						<li>
							<span class="opener">Administración</span>
							<ul>
								<li><a href="administracion.php">Administrar</a></li>
								<li><a href="conjunto_categorias.php">Gestionar Categorías</a></li>
								<li><a href="subir_subtitulos.php">Subir subtítulo</a></li>
								<li><a href="anadir_administrador.php">Añadir adminsitrador</a></li>
							</ul>
						</li>
						
					</ul>
				</nav>
			</div>
		</div>