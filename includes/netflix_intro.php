<?php 


?>

<style>
    html,
body {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
}

#container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  background-color: #000000;
  overflow: hidden;
  z-index: 100;
  position: absolute;
}
#container netflixintro {
  display: block;
  position: relative;
  width: 300px;
  height: 300px;
  overflow: hidden;
  animation-name: zoom-in;
  animation-delay: 0.5s;
  animation-duration: 4.5s;
  animation-timing-function: ease-in;
  animation-fill-mode: forwards;
  background-size: 4000px;
  background-position: -1950px 0;
}
#container netflixintro::before {
  content: "";
  position: absolute;
  display: block;
  background-color: #000000;
  width: 150%;
  height: 30%;
  left: -25%;
  bottom: -27%;
  border-radius: 50%;
  z-index: 5;
  transform-origin: left center;
  background-size: 4000px;
  background-position: -1950px 0;
}
#container netflixintro[letter=N] {
  transform-origin: 30% center;
}
#container netflixintro[letter=N] .helper-1 {
  width: 19.5%;
  height: 100%;
  background-color: rgba(228, 9, 19, 0.5);
  left: 22.4%;
  top: 0;
  transform: rotate(180deg);
  animation-name: fading-lumieres-box;
  animation-duration: 2s;
  animation-delay: 0.6s;
  animation-fill-mode: forwards;
}
#container netflixintro[letter=N] .helper-1 .effect-brush {
  animation-name: brush-moving;
  animation-duration: 2.5s;
  animation-fill-mode: forwards;
  animation-delay: 1.2s;
}
#container netflixintro[letter=N] .helper-1 .effect-brush [class*=fur-] {
  bottom: 0;
  height: 40%;
}
#container netflixintro[letter=N] .helper-3 {
  width: 19%;
  height: 150%;
  left: 40.5%;
  top: -25%;
  transform: rotate(-19.5deg);
  box-shadow: 0px 0px 35px -12px rgba(0, 0, 0, 0.4);
  overflow: hidden;
}
#container netflixintro[letter=N] .helper-3 .effect-brush {
  animation-name: brush-moving;
  animation-duration: 2s;
  animation-fill-mode: forwards;
  animation-delay: 0.8s;
}
#container netflixintro[letter=N] .helper-2 {
  width: 19.5%;
  height: 100%;
  left: 57.8%;
  top: 0;
  transform: rotate(180deg);
  overflow: hidden;
}
#container netflixintro[letter=N] .helper-2 .effect-brush {
  animation-name: brush-moving;
  animation-duration: 2s;
  animation-fill-mode: forwards;
  animation-delay: 0.5s;
}

#container netflixintro[letter=F] {
  transform-origin: 30% center;
}
#container netflixintro[letter=F] .helper-1 {
  width: 19.5%;
  height: 100%;
  background-color: rgba(228, 9, 19, 0.5);
  left: 22%;
  top: 0;
  transform: rotate(180deg);
  animation-name: fading-lumieres-box;
  animation-duration: 2s;
  animation-delay: 0.6s;
  animation-fill-mode: forwards;
}
#container netflixintro[letter=F] .helper-1 .effect-brush {
  animation-name: brush-moving;
  animation-duration: 2.5s;
  animation-fill-mode: forwards;
  animation-delay: 1.2s;
}
#container netflixintro[letter=F] .helper-1 .effect-brush [class*=fur-] {
  bottom: 0;
  height: 30%;
}
#container netflixintro[letter=F] .helper-2 {
  width: 17.5%;
  height: 50%;
  left: 38%;
  top: -49px;
  transform: rotate(270deg);
  overflow: hidden;
}
#container netflixintro[letter=F] .helper-2 .effect-brush {
  animation-name: brush-moving;
  animation-duration: 3s;
  animation-fill-mode: forwards;
  animation-delay: 0.7s;
}
#container netflixintro[letter=F] .helper-3 {
  width: 17%;
  height: 39%;
  left: 33%;
  top: 29%;
  transform: rotate(-90deg);
  box-shadow: 0px 0px 35px -12px rgba(0, 0, 0, 0.4);
  overflow: hidden;
  animation-name: fading-out;
  animation-duration: 2s;
  animation-fill-mode: forwards;
  animation-delay: 1s;
}
#container netflixintro[letter=F] .helper-3 .effect-brush {
  animation-name: brush-moving;
  animation-duration: 2s;
  animation-fill-mode: forwards;
  animation-delay: 0.5s;
}

#container netflixintro [class*=helper-] {
  position: absolute;
}
#container netflixintro [class*=helper-] .effect-brush {
  position: absolute;
  width: 100%;
  height: 300%;
  top: 0;
  overflow: hidden;
}
#container netflixintro [class*=helper-] .effect-brush::before {
  display: block;
  content: "";
  position: absolute;
  background-color: #e40913;
  width: 100%;
  height: 70%;
  box-shadow: 0px 0px 29px 24px #e40913;
}
#container netflixintro [class*=helper-] .effect-brush [class*=fur-] {
  display: block;
  position: absolute;
  bottom: 10%;
  height: 30%;
}
#container netflixintro [class*=helper-] .effect-brush .fur-1 {
  left: 0%;
  width: 3.8%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 15%, rgba(0, 0, 0, 0) 81%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-2 {
  left: 3.8%;
  width: 2.8%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 10%, rgba(0, 0, 0, 0) 62%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-3 {
  left: 6.6%;
  width: 4.8%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 37%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-4 {
  left: 11.4%;
  width: 4%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 23%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-5 {
  left: 15.4%;
  width: 4%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 15%, rgba(0, 0, 0, 0) 86%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-6 {
  left: 19.4%;
  width: 2.5%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 27%, rgba(0, 0, 0, 0) 89%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-7 {
  left: 21.9%;
  width: 4%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 20%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-8 {
  left: 25.9%;
  width: 2%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 30%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-9 {
  left: 27.9%;
  width: 4%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 35%, rgba(0, 0, 0, 0) 95%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-10 {
  left: 31.9%;
  width: 3.5%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 39%, rgba(0, 0, 0, 0) 95%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-11 {
  left: 35.4%;
  width: 2%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 34%, rgba(0, 0, 0, 0) 95%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-12 {
  left: 37.4%;
  width: 2.6%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 22%, rgba(0, 0, 0, 0) 95%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-13 {
  left: 40%;
  width: 6%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 47%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-14 {
  left: 46%;
  width: 2%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 36%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-15 {
  left: 48%;
  width: 5.5%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 29%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-16 {
  left: 53.5%;
  width: 3%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 39%, rgba(0, 0, 0, 0) 95%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-17 {
  left: 56.5%;
  width: 4.1%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 45%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-18 {
  left: 60.6%;
  width: 2.4%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 34%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-19 {
  left: 63%;
  width: 4%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 47%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-20 {
  left: 67%;
  width: 1.5%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 27%, rgba(0, 0, 0, 0) 95%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-21 {
  left: 68.5%;
  width: 2.8%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 37%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-22 {
  left: 71.3%;
  width: 2.3%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 9%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-23 {
  left: 73.6%;
  width: 2.2%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 28%, rgba(0, 0, 0, 0) 92%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-24 {
  left: 75.8%;
  width: 1%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 37%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-25 {
  left: 76.8%;
  width: 2.1%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 28%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-26 {
  left: 78.9%;
  width: 4.1%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 34%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-27 {
  left: 83%;
  width: 2.5%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 21%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-28 {
  left: 85.5%;
  width: 4.5%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 39%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-29 {
  left: 90%;
  width: 2.8%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 30%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-30 {
  left: 92.8%;
  width: 3.5%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 19%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-brush .fur-31 {
  left: 96.3%;
  width: 3.7%;
  background: linear-gradient(to bottom, #e40913 0%, #e40913 37%, rgba(0, 0, 0, 0) 100%);
}
#container netflixintro [class*=helper-] .effect-lumieres {
  position: absolute;
  width: 100%;
  height: 100%;
  opacity: 0;
  animation-name: showing-lumieres;
  animation-duration: 2s;
  animation-delay: 1.6s;
  animation-fill-mode: forwards;
}



@keyframes brush-moving {
  0% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(-100%);
  }
}
@keyframes fading-out {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}
@keyframes lumieres-moving-right {
  0% {
    transform: translate(0);
  }
  40% {
    transform: translate(-10px) scaleX(1);
  }
  50% {
    transform: translate(-60px);
  }
  100% {
    transform: translate(-120px) scaleX(3);
  }
}
@keyframes lumieres-moving-left {
  0% {
    transform: translate(0);
  }
  40% {
    transform: translate(10px) scaleX(1);
  }
  50% {
    transform: translate(60px);
  }
  100% {
    transform: translate(120px) scaleX(3);
  }
}
@keyframes zoom-in {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(20);
  }
  100% {
    transform: scale(50);
  }
}
@keyframes showing-lumieres {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
@keyframes fading-lumieres-box {
  0% {
    background-color: rgba(228, 9, 19, 0.5);
  }
  100% {
    background-color: rgba(228, 9, 19, 0);
  }
}
@keyframes fadeOut {
  from { opacity: 1; }
  to { opacity: 0; }
}

.fadeOut {
  animation: fadeOut 2s forwards;
  animation-delay: 2s;
}
    </style>


<div class ="fadeOut" id="container">
  <!-- Edit the letter attr to: N, E, T, F, L, I or X -->
  <netflixintro letter="F">
    <div class="helper-1">
      <div class="effect-brush">
        <span class="fur-31"></span>
        <span class="fur-30"></span>
        <span class="fur-29"></span>
        <span class="fur-28"></span>
        <span class="fur-27"></span>
        <span class="fur-26"></span>
        <span class="fur-25"></span>
        <span class="fur-24"></span>
        <span class="fur-23"></span>
        <span class="fur-22"></span>
        <span class="fur-21"></span>
        <span class="fur-20"></span>
        <span class="fur-19"></span>
        <span class="fur-18"></span>
        <span class="fur-17"></span>
        <span class="fur-16"></span>
        <span class="fur-15"></span>
        <span class="fur-14"></span>
        <span class="fur-13"></span>
        <span class="fur-12"></span>
        <span class="fur-11"></span>
        <span class="fur-10"></span>
        <span class="fur-9"></span>
        <span class="fur-8"></span>
        <span class="fur-7"></span>
        <span class="fur-6"></span>
        <span class="fur-5"></span>
        <span class="fur-4"></span>
        <span class="fur-3"></span>
        <span class="fur-2"></span>
        <span class="fur-1"></span>
      </div>
      <div class="effect-lumieres">
        <span class="lamp-1"></span>
        <span class="lamp-2"></span>
        <span class="lamp-3"></span>
        <span class="lamp-4"></span>
        <span class="lamp-5"></span>
        <span class="lamp-6"></span>
        <span class="lamp-7"></span>
        <span class="lamp-8"></span>
        <span class="lamp-9"></span>
        <span class="lamp-10"></span>
        <span class="lamp-11"></span>
        <span class="lamp-12"></span>
        <span class="lamp-13"></span>
        <span class="lamp-14"></span>
        <span class="lamp-15"></span>
        <span class="lamp-16"></span>
        <span class="lamp-17"></span>
        <span class="lamp-18"></span>
        <span class="lamp-19"></span>
        <span class="lamp-20"></span>
        <span class="lamp-21"></span>
        <span class="lamp-22"></span>
        <span class="lamp-23"></span>
        <span class="lamp-24"></span>
        <span class="lamp-25"></span>
        <span class="lamp-26"></span>
        <span class="lamp-27"></span>
        <span class="lamp-28"></span>
      </div>
    </div>
    <div class="helper-2">
      <div class="effect-brush">
        <span class="fur-31"></span>
        <span class="fur-30"></span>
        <span class="fur-29"></span>
        <span class="fur-28"></span>
        <span class="fur-27"></span>
        <span class="fur-26"></span>
        <span class="fur-25"></span>
        <span class="fur-24"></span>
        <span class="fur-23"></span>
        <span class="fur-22"></span>
        <span class="fur-21"></span>
        <span class="fur-20"></span>
        <span class="fur-19"></span>
        <span class="fur-18"></span>
        <span class="fur-17"></span>
        <span class="fur-16"></span>
        <span class="fur-15"></span>
        <span class="fur-14"></span>
        <span class="fur-13"></span>
        <span class="fur-12"></span>
        <span class="fur-11"></span>
        <span class="fur-10"></span>
        <span class="fur-9"></span>
        <span class="fur-8"></span>
        <span class="fur-7"></span>
        <span class="fur-6"></span>
        <span class="fur-5"></span>
        <span class="fur-4"></span>
        <span class="fur-3"></span>
        <span class="fur-2"></span>
        <span class="fur-1"></span>
      </div>
    </div>
    <div class="helper-3">
      <div class="effect-brush">
        <span class="fur-31"></span>
        <span class="fur-30"></span>
        <span class="fur-29"></span>
        <span class="fur-28"></span>
        <span class="fur-27"></span>
        <span class="fur-26"></span>
        <span class="fur-25"></span>
        <span class="fur-24"></span>
        <span class="fur-23"></span>
        <span class="fur-22"></span>
        <span class="fur-21"></span>
        <span class="fur-20"></span>
        <span class="fur-19"></span>
        <span class="fur-18"></span>
        <span class="fur-17"></span>
        <span class="fur-16"></span>
        <span class="fur-15"></span>
        <span class="fur-14"></span>
        <span class="fur-13"></span>
        <span class="fur-12"></span>
        <span class="fur-11"></span>
        <span class="fur-10"></span>
        <span class="fur-9"></span>
        <span class="fur-8"></span>
        <span class="fur-7"></span>
        <span class="fur-6"></span>
        <span class="fur-5"></span>
        <span class="fur-4"></span>
        <span class="fur-3"></span>
        <span class="fur-2"></span>
        <span class="fur-1"></span>
      </div>
    </div>
    <div class="helper-4">
      <div class="effect-brush">
        <span class="fur-31"></span>
        <span class="fur-30"></span>
        <span class="fur-29"></span>
        <span class="fur-28"></span>
        <span class="fur-27"></span>
        <span class="fur-26"></span>
        <span class="fur-25"></span>
        <span class="fur-24"></span>
        <span class="fur-23"></span>
        <span class="fur-22"></span>
        <span class="fur-21"></span>
        <span class="fur-20"></span>
        <span class="fur-19"></span>
        <span class="fur-18"></span>
        <span class="fur-17"></span>
        <span class="fur-16"></span>
        <span class="fur-15"></span>
        <span class="fur-14"></span>
        <span class="fur-13"></span>
        <span class="fur-12"></span>
        <span class="fur-11"></span>
        <span class="fur-10"></span>
        <span class="fur-9"></span>
        <span class="fur-8"></span>
        <span class="fur-7"></span>
        <span class="fur-6"></span>
        <span class="fur-5"></span>
        <span class="fur-4"></span>
        <span class="fur-3"></span>
        <span class="fur-2"></span>
        <span class="fur-1"></span>
      </div>
    </div>
  </netflixintro>
</div>
<script>
document.querySelector('netflixintro').addEventListener('animationend', function() {
  const container = document.getElementById('container');
  // Ajoute la classe 'fadeOut' pour commencer l'animation d'opacité.
  container.classList.add('fadeOut');

});

document.querySelector('netflixintro').addEventListener('animationend', function() {
  setTimeout(() => {
    document.getElementById('container').style.display = 'none';
  }, 500); // Délai de 2 secondes
});
    </script>