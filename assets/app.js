/*
 * Bienvenue dans le fichier JavaScript principal de votre application !
 *
 * Nous vous recommandons d'inclure la version construite de ce fichier JavaScript
 * (et son fichier CSS) dans votre mise en page de base (base.html.twig).
 */

// tout CSS que vous importez sortira dans un seul fichier CSS (app.css dans ce cas)
import "./styles/app.scss";

// démarrer l'application Stimulus
import "./bootstrap";

const btnLogin = document.querySelector("#btn-login");

btnLogin.addEventListener("click", () => {
  document.querySelector("#spinner").classList.remove("d-none");
  setTimeout(() => {
    document.querySelector("#spinner").classList.add("d-none");
  }, 1000);
});
