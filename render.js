//@ts-check

"use strict";

const TANKE_BLUE = "#2e45a2";
const PARENT_DIV = document.getElementById("render-area");

// Load 3D Scene
let scene = new THREE.Scene();
scene.background = new THREE.Color(TANKE_BLUE);

// Load Camera Perspektive
let camera = new THREE.PerspectiveCamera(
   25,
   window.innerWidth / window.innerHeight,
   1,
   20000
);
camera.position.set(0, 0, 17);

var x_axis = new THREE.Vector3(1, 0, 0);
var quaternion = new THREE.Quaternion();
camera.position.applyQuaternion(quaternion.setFromAxisAngle(x_axis, 1.5));
camera.up.applyQuaternion(quaternion.setFromAxisAngle(x_axis, 1.5));

// Load a Renderer
let renderer = new THREE.WebGLRenderer({ alpha: false, antialias: true });
renderer.setClearColor("white");
renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(window.innerWidth, window.innerHeight);

//renderer.shadowMap.enabled = true;

PARENT_DIV.appendChild(renderer.domElement);

/*
let pointLightInside = new THREE.PointLight("pink", 0.75 / 8);
pointLightInside.position.set(0, -1.5, 0);
pointLightInside.castShadow = true;
pointLightInside.shadow.bias = -0.000025;
//pointLightInside.shadow.mapSize.width = 512 * 4;
//pointLightInside.shadow.mapSize.height = 512 * 4;
scene.add(pointLightInside);

let pointLight = new THREE.PointLight("white", 0.5 / 8);
pointLight.position.set(2.6, 0, 6);
pointLight.castShadow = true;
pointLight.shadow.bias = -0.00025;
pointLight.shadow.radius = 8;
//pointLight.shadow.mapSize.width = 512 *4;
//pointLight.shadow.mapSize.height = 512 * 4;
scene.add(pointLight);

let ambientLight = new THREE.AmbientLight(TANKE_BLUE, 1.5);
ambientLight.position.set(1, 1, 1).normalize();
scene.add(ambientLight);
*/

let model, geometry;

let loader = new THREE.GLTFLoader();
loader.load("./data/TANKE_model.glb", function (gltf) {
   model = gltf.scene;

   model.position.x = 0; //Position (x = right+ left-)
   model.position.y = 0; //Position (y = up+, down-)
   model.position.z = 0; //Position (z = front +, back-)

   //object.castShadow = true;
   //object.receiveShadow = true;

   geometry = model.getObjectByName("Empty").children[0].geometry;

   console.log(geometry);

   const material = new THREE.PointsMaterial();
   //geometry.computeLineDistances();
   const lines = new THREE.Line(geometry, material);

   /*object.traverse((node) => {
      if (node.isMesh) {
         node.castShadow = true;
         node.receiveShadow = true;
         console.log(node);
      }
   });*/

   const box = new THREE.Box3().setFromObject(model);
   const size = box.getSize(new THREE.Vector3()).length();
   const center = box.getCenter(new THREE.Vector3());

   /*model.position.x += model.position.x - center.x;
   model.position.y += model.position.y - center.y;
   model.position.z += model.position.z - center.z;*/

   camera.near = size / 100;
   camera.far = size * 100;

   camera.updateProjectionMatrix();

   scene.add(lines);

   camera.lookAt(model.position);

   camera.position.x += -4;
   camera.position.y += 4;
   camera.position.z += -3;

   console.log("model loaded");
   render();
   setTimeout(() => {
      PARENT_DIV.style.animation = "fade-in 0.2s 1";
      PARENT_DIV.style.opacity = "1";
   }, 50);
   onScroll();
});

function render() {
   renderer.render(scene, camera);
}

function onWindowResize() {
   camera.aspect = window.innerWidth / window.innerHeight;
   camera.updateProjectionMatrix();

   renderer.setSize(window.innerWidth, window.innerHeight);
   requestAnimationFrame(render);
}

let geometryRotation = 0;

function onScroll() {
   setTimeout(() => {
      const scrollValue = window.scrollY / 1000;

      geometry.rotateZ(scrollValue - geometryRotation);
      geometryRotation = scrollValue;
      requestAnimationFrame(render);
   });
}

window.addEventListener("resize", onWindowResize);
window.addEventListener("scroll", onScroll);
window.addEventListener("touchmove", onScroll);
