<html>  
    <head>
        <meta charset=utf-8>
		<title>MODELO 3D</title>
		<style>
			body { margin: 0; }
			canvas { width: 100%; height: 100% }
		</style>
    </head>
    <body>
		<?php
			if(isset($_GET['c'])) {
				echo '<span id="'.'../'.$_GET['c'].'"></span>';
			} else {
				if( !headers_sent() ){
						header("Location: /views/erro404.php");
				}else{
					?>
						<script type="text/javascript">
						document.location.href="/views/erro404.php";
						</script>
						Redirecting to <a href="/views/erro404.php">views/erro404.php</a>
					<?php
				}
				die();  				
			}
		?>
		<script src="three.js"></script>
         <script src="three.module.js"></script>
         <script src="http://mamboleoo.be/learnThree/demos/OBJLoader.js"></script>
         <script src="OBJLoader.js"></script>
		<script>
			var container;
			var camera, scene, renderer;
            //responsaveis por capturar a posição do mouse
			var mouseX = 0, mouseY = 0;
            //Acredito que tenha o objetivo de localizar o centro da tela
			var windowHalfX = window.innerWidth / 2;
			var windowHalfY = window.innerHeight / 2;
            //Start do metodo init
			init();
            //start do metodo responsavel pela animação
			animate();

			function init() {
                //cria uma div para armazenar a sena
				container = document.createElement( 'div' );
                //adiciona a div ao container
				document.body.appendChild( container );
                //regulando o primeiro parametro, avasta e aproxima a camera do objeto, quanto menor o valor, maior a proximidade
				camera = new THREE.PerspectiveCamera( 20, window.innerWidth / window.innerHeight, 1, 2000 );
				camera.position.z = 250;
				// scene
				scene = new THREE.Scene();
				var ambient = new THREE.AmbientLight( 0x101030 );
				scene.add( ambient );
                var directionalLight = new THREE.DirectionalLight( 0xffffff );
				directionalLight.position.set( 0, 0, 1 );
                //criando luz ambiente
                var ambientLight = new THREE.AmbientLight(0xFFFFFF);
                //adicionando luz ambiente na cena
                scene.add(ambientLight);
				scene.add( directionalLight );
				// texture
				var manager = new THREE.LoadingManager();
				manager.onProgress = function ( item, loaded, total ) {
					console.log( item, loaded, total );
				};
				var texture = new THREE.Texture();
				var onProgress = function ( xhr ) {
					if ( xhr.lengthComputable ) {
						var percentComplete = xhr.loaded / xhr.total * 100;
						console.log( Math.round(percentComplete, 2) + '% downloaded' );
					}
				};
				var onError = function ( xhr ) {
				};
				// model
                // leitura do objeto
				var loader = new THREE.OBJLoader( manager );
				loader.load(document.getElementsByTagName("span")[0].getAttribute("id"), function ( object ) {
					object.traverse( function ( child ) {
						if ( child instanceof THREE.Mesh ) {
                            //aplica a imagem como um "mapa" (textura), do objeto
							child.material.map = texture;
						}
					} );
                    //altera a posição do objeto na tela, na posião y -> vertical
					object.position.y =  0;
                    //adiciona o objeto na sena
					scene.add( object );
				}, onProgress, onError );
				//configuraões do render
				renderer = new THREE.WebGLRenderer();
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth, window.innerHeight );
				container.appendChild( renderer.domElement );
				document.addEventListener( 'mousemove', onDocumentMouseMove, false );
				//
				window.addEventListener( 'resize', onWindowResize, false );
			}
			function onWindowResize() {
				windowHalfX = window.innerWidth / 2;
				windowHalfY = window.innerHeight / 2;
				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();
				renderer.setSize( window.innerWidth, window.innerHeight );
			}
            //recebe o eventoreferente ao movimento do mouse
			function onDocumentMouseMove( event ) {
				mouseX = ( event.clientX - windowHalfX ) / 2;
				mouseY = ( event.clientY - windowHalfY ) / 2;
			}
			//
			function animate() {
				requestAnimationFrame( animate );
				render();
			}
            //configura a posição da camera na sena
			function render() {
				camera.position.x += ( mouseX - camera.position.x ) * .05;
				camera.position.y += ( - mouseY - camera.position.y ) * .05;
				camera.lookAt( scene.position );
				renderer.render( scene, camera );
			}
		</script>
    </body>
</html>