import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.152.2/build/three.module.js';
import { OrbitControls } from 'https://cdn.jsdelivr.net/npm/three@0.152.2/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from 'https://cdn.jsdelivr.net/npm/three@0.152.2/examples/jsm/loaders/GLTFLoader.js';

let scene, camera, renderer, carModel, controls;

init();
animate();

function init() {
  // Scene setup
  scene = new THREE.Scene();

  // Gradient background using a canvas texture
  const canvas = document.createElement('canvas');
  canvas.width = 1;
  canvas.height = 512;

  const ctx = canvas.getContext('2d');
  const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
  gradient.addColorStop(0, '#222222'); // Top color
  gradient.addColorStop(1, '#000000'); // Bottom color

  ctx.fillStyle = gradient;
  ctx.fillRect(0, 0, 1, canvas.height);

  const texture = new THREE.CanvasTexture(canvas);
  scene.background = texture;

  // Camera setup
  camera = new THREE.PerspectiveCamera(
    45,
    window.innerWidth / window.innerHeight,
    0.1,
    1000
  );
  camera.position.set(3, 2, 5); // Better angle to view the car

  // Renderer setup
  renderer = new THREE.WebGLRenderer({ antialias: true });
  const container = document.getElementById('fortuner-container');
  container.appendChild(renderer.domElement);
  renderer.setSize(container.clientWidth, container.clientHeight);
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.shadowMap.enabled = true;
  renderer.shadowMap.type = THREE.PCFSoftShadowMap;

  // Lighting
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.8);
  scene.add(ambientLight);

  const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
  directionalLight.position.set(5, 10, 7.5);
  directionalLight.castShadow = true;
  directionalLight.shadow.camera.left = -10;
  directionalLight.shadow.camera.right = 10;
  directionalLight.shadow.camera.top = 10;
  directionalLight.shadow.camera.bottom = -10;
  directionalLight.shadow.camera.near = 0.5;
  directionalLight.shadow.camera.far = 50;
  directionalLight.shadow.mapSize.width = 2048;
  directionalLight.shadow.mapSize.height = 2048;
  scene.add(directionalLight);

  // Controls
  controls = new OrbitControls(camera, renderer.domElement);
  controls.enableDamping = true;
  controls.dampingFactor = 0.05;
  controls.enableZoom = true;
  controls.enablePan = false;
  controls.minDistance = 5;
  controls.maxDistance = 8;
  controls.minPolarAngle = Math.PI / 4;
  controls.maxPolarAngle = Math.PI / 2;

  // Load car model
  const loader = new GLTFLoader();
  loader.load(
    'https://raw.githubusercontent.com/Shraddhey97/3dmodel/refs/heads/main/2015_toyota_fortuner.glb',
    (gltf) => {
      carModel = gltf.scene;
      carModel.scale.set(1,1,1);
      carModel.position.set(0, 0, 0);

      carModel.traverse((child) => {
        if (child.isMesh) {
          child.castShadow = true;
          child.receiveShadow = true;
        }
      });

      scene.add(carModel);
      controls.target.copy(carModel.position);
      controls.update();
      camera.lookAt(carModel.position);
    },
    (progress) => {
      const percent = (progress.loaded / progress.total * 100).toFixed(1);
      console.log(`Loading model: ${percent}%`);
    },
    (error) => {
      console.error('Error loading model', error);
    }
  );

  // Handle window resize
  window.addEventListener('resize', () => {
    camera.aspect = container.clientWidth / container.clientHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(container.clientWidth, container.clientHeight);
  });
}

function animate() {
  requestAnimationFrame(animate);
  controls.update();
  renderer.render(scene, camera);
}
