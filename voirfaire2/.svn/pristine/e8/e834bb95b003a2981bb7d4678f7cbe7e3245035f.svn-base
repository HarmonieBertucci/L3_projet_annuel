"use strict";

let compteur = 0 ;// image qu'on voit
let tempsAffichage;
let elements_a_Afficher;
let slides; //un tableau contenant la liste des images
let slideWidth;

window.onload = () => {
    // On récupère le conteneur principal du diaporama (class=diapo) dans le DOM
    const diapo = document.querySelector(".diapo")

    // On récupère le conteneur de toutes les images dans le DOM
    elements_a_Afficher = document.querySelector(".elements")

    //on crée le tableau a partir des images
    slides = Array.from(elements_a_Afficher.children)

    // on définit la largeur visible du diaporama
    slideWidth = diapo.getBoundingClientRect().width

    // On récupère les deux flèches de navigation
    let nextFleche = document.querySelector("#nav-droite")
    let prevFleche = document.querySelector("#nav-gauche")

    // On écoute les évènements des flèches
    nextFleche.addEventListener("click", next)
    prevFleche.addEventListener("click", prev)

    // On définit le temps d'affichage des images => on appelle next toutes les 5 secondes
    tempsAffichage = setInterval(next, 5000)

    // Mise en oeuvre du "responsive"
    window.addEventListener("resize", () => {
        slideWidth = diapo.getBoundingClientRect().width
        next()
    })
}

/**
 * permet de passer a l'image suivante
 */
function next(){
    compteur++ //permet de savoir a quelle image on est (on est passé a la suivante)

    // si on a dépassé le nombre d'images, on revient a la première
    if(compteur == slides.length){
        compteur = 0
    }

    // permet de décaler l'image
    let decal = -slideWidth * compteur
    elements_a_Afficher.style.transform = `translateX(${decal}px)`
}

/**
 * Cette fonction fait défiler le diaporama vers la gauche
 */
function prev(){
    compteur-- //permet de savoir a quelle image on est (on est revenu en arrière)

    // si le compteur est négatif, revient a la dernière image
    if(compteur < 0){
        compteur = slides.length - 1
    }

    // permet de décaler l'image
    let decal = -slideWidth * compteur
    elements_a_Afficher.style.transform = `translateX(${decal}px)`
}
